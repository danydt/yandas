<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    public function index(): Factory|View|Application
    {
        $address = ShippingAddress::query()->first();

        return view('shipments.index', compact('address'));
    }

    public function store(Request $request): RedirectResponse
    {
        $country = trim(strval($request->input('country')));
        $line1 = trim(strval($request->input('line1')));
        $line2 = trim(strval($request->input('line2')));
        $phone = trim(strval($request->input('phone')));
        $postal = trim(strval($request->input('postal')));

        $shipment = new ShippingAddress;

        $shipment->country_name = $country;
        $shipment->address_l1 = $line1;
        $shipment->address_l2 = $line2;
        $shipment->phone_number = $phone;
        $shipment->postal_code = $postal;

        ShippingAddress::query()->truncate();

        $shipment->save();

        return back();
    }

    public function address(): Factory|View|Application
    {
        $address = ShippingAddress::query()->first();
        $user = auth()->user();

        return view('shipments.show', compact('address', 'user'));
    }
}
