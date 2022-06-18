<?php

namespace App\Http\Controllers;

use App\Http\Traits\CodeGeneratorTrait;
use App\Mail\OrderRegisteredMail;
use App\Models\Order;
use App\Models\Currency;
use App\Models\OrderDetail;
use App\Services\OrderService;
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

        if ($order = (new OrderService($request))->create()) {

            return redirect()->route('orders.show', compact('order'));

        } else {

            return back()->withInput()->with('message', 'Une erreur est survenue lors de votre commande. Veuillez recommencer.');

        }

    }

    public function show(Order $order): Factory|View|Application
    {
        $currencies = Currency::all();

        if ($order->paid_amount == 0) {

            $amount_to_pay = $order->proforma_amount;

        } else {

            $amount_to_pay = $order->proforma_amount - $order->paid_amount;
        }

        if (is_null($amount_to_pay)) {

            $amount_to_pay = 0;
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
