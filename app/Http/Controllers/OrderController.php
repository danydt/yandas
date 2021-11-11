<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(): Factory|View|Application
    {
        // check if the connected user is an administrator
        $user_type = auth()->user()->user_type;

        if (str_contains($user_type, 'customer')) {

            // it's a customer
            // select only its orders
            $orders = Order::query()->where('user_id', auth()->id())->paginate();

        } else {

            // get all
            $orders = Order::query()->where("enabled", 'true')->paginate();
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

        $order->code = Str::random();
        $order->enabled = true;

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

        } catch (Exception $exception) {

            Log::debug("Insertion error: " . $exception->getMessage());

            DB::rollBack();

            return back()->withInput()->with('message', 'Une erreur est survenue lors de votre commande. Veuillez recommencer.');
        }

        return redirect()->route('orders.show', compact('order'));

    }

    public function show(Order $order): Factory|View|Application
    {
        $currencies = Currency::all();
        return view('orders.show', compact('order', 'currencies'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        $order->enabled = !$order->enabled;

        $order->save();

        return back()->with('message', 'Vous venez d\'annuler votre commande !');
    }
}
