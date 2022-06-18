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
}
