<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        // save user preferences
        session()->put('sidebar', auth()->user()->role?->default_sidebar);
        session()->put('dashboard', auth()->user()->role?->default_dashboard);
        session()->put('navigation', auth()->user()->role?->default_navigation_bar);

        if (auth()->user()->user_type == "admin") {

            $active_commands = Order::availableOrdersCount();
            $delivered_commands = Order::deliveredOrdersCount();

        } else {

            $active_commands = Order::myAvailableOrdersCount(auth()->id());
            $delivered_commands = Order::myDeliveredOrdersCount(auth()->id());
        }

        return view('home')->with([
            'active_commands' => $active_commands,
            'delivered_commands' => $delivered_commands,
        ]);
    }
}
