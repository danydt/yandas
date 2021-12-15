<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $payment_method = intval($request->input('payment_method'));
        $order_id = intval($request->input('order'));
        $phone_number = intval($request->input('phone_number'));
        $amount = floatval($request->input('payment_amount'));
        $currency = trim(strval($request->input('currency')));
        $reference = Str::random();

        $response = Http::withToken('$2y$10$QcWa/TsDl.DUjKgxTVNfuuSB8PhpoOav79cILnaaDP3r6w5OH2xRu')
            ->contentType('application/json')
            ->post('https://gateway.ntoprog.org/api/new-transaction', [
                'phone_number' => $phone_number,
                'endpoint' => 'om',
                'amount' => $amount,
                'trans_code' => $reference,
                'currency' => $currency,
                'language' => 'FR',
                'operation' => 'c2b',
                'callback_url' => 'http://payshipping.yandas243.com/api/callback',
                'output' => 1
            ]);


        if ($response->status() == 200) {

            $body =  json_decode($response->body());

            // check result
            if ($body->result == "success") {

                $payment = new Payment;

                $payment->order_id = $order_id;
                $payment->paid_amount = $amount;
                $payment->payment_date = date('Y-m-d');
                $payment->reference_code = $reference;

                $payment->save();

                return "OK";

            } else {

                return "KO";
            }


        } else {

            return "KO";
        }
    }

    public function callback(string $reference)
    {

    }
}
