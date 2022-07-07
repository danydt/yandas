<?php

namespace App\Http\Controllers\API;

use App\Models\ShippingAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommonActionController extends BaseController
{
    public function myAddress(): JsonResponse
    {
        $address = ShippingAddress::query()->first();
        $user = auth()->user();

        $data = [
            'name' => sprintf('%s #%d', $user->name, $user->id),
            'country' => $address->country_name,
            'line_one' => $address->address_l1,
            'line_two' => $address->address_l2,
            'phone' => $address->phone_number,
            'post_code' => $address->postal_code,
        ];

        return $this->sendResponse($data, "OK");
    }
 
    public function SetAddress() : JsonResponse {
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
    }
}
