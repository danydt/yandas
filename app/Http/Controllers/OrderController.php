<?php

namespace App\Http\Controllers;

use App\Http\Traits\CodeGeneratorTrait;
use App\Mail\OrderRegisteredMail;
use App\Models\Order;
use App\Models\Currency;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use CodeGeneratorTrait;

    public function index(): Factory|View|Application
    {
        // check if the connected user is an administrator
        $user_type = auth()->user()->user_type;

        if (str_contains($user_type, 'customer')) {

            // it's a customer
            // select only its orders
            $orders = Order::query()->where('user_id', auth()->id())->orderByDesc('id')->paginate();

        } else {

            // get all
            $orders = Order::query()->where("enabled", 'true')->orderByDesc('id')->paginate();
        }

        return view('orders.index', compact('orders'));
    }

    public function create(): Factory|View|Application
    {
        return view('orders.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $order = new Order;

        // get order items count
        $last_order_code = Order::latest()->first()?->value('code');

        $code = $this->transactionCodeGenerator($last_order_code, 6);

        $order->code = $code;
        $order->enabled = true;
        $order->internal_code = Str::random();
        $order->external_code = sprintf("%s.%s", date('Y.m'), $code);

        try {

            DB::beginTransaction();

            // persist (save) order
            auth()->user()->orders()->save($order);

            // prepare saving order details
            $articles = $request->input('articles');
            $urls = $request->input('urls');
            $quantities = $request->input('quantities');
            $descriptions = $request->input('descriptions');

            foreach ($articles as $index => $article) {

                $detail = new OrderDetail;

                $detail->product_name = trim(strval($article));
                $detail->product_url = trim(strval($urls[$index]));
                $detail->quantity = intval($quantities[$index]);
                $detail->description = trim(strval($descriptions[$index]));

                $order->details()->save($detail);
            }

            DB::commit();

            // send mail only if order has been saved
            Mail::to([env('MAIL_USERNAME'), auth()->user()->email])->queue(new OrderRegisteredMail($order->code));

        } catch (Exception $exception) {

            Log::debug("Insertion error: " . $exception->__toString());

            DB::rollBack();

            return back()->withInput()->with('message', 'Une erreur est survenue lors de votre commande. Veuillez recommencer.');
        }

        return redirect()->route('orders.show', compact('order'));

    }

    public function show(Order $order): Factory|View|Application
    {
        $currencies = Currency::all();

        if ($order->paid_amount == 0) {

            $amount_to_pay = $order->proforma_amount;

        } else {

            $amount_to_pay = $order->proforma_amount - $order->paid_amount;
        }

        return view('orders.show', compact('order', 'currencies'))->with([
            'amount_to_pay' => $amount_to_pay,
        ]);
    }

    public function cancel(Order $order): RedirectResponse
    {
        $order->enabled = !$order->enabled;

        $order->save();

        return back()->with('message', 'Vous venez d\'annuler votre commande !');
    }

    public function search(Request $request): JsonResponse
    {
        $term = trim(strval($request->input('q')));

        $user_id = auth()->user()->user_type == "customer" ? auth()->id() : null;

        $orders = Order::searchOrders($term, $user_id);

        return response()->json([
            'items' => $orders->map(function ($order) {
                return [
                    'id' => $order->internal_code,
                    'code' => $order->external_code,
                    'name' => sprintf("Commande no %s, du %s", $order->code, Carbon::parse($order->created_at)->locale('fr_FR')->isoFormat('LL')),
                ];
            })
        ]);

    }
}
