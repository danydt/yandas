<?php

namespace App\Http\Controllers;

use App\Mail\PaymentRegisteredMail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $order_id = intval($request->input('item_order'));
        $phone_number = sprintf('243%d', intval($request->input('phone_number')));
        $amount = floatval($request->input('payment_amount'));
        $currency = trim(strval($request->input('currency')));
        $reference = Str::random();

        /*$response = Http::withToken('$2y$10$QcWa/TsDl.DUjKgxTVNfuuSB8PhpoOav79cILnaaDP3r6w5OH2xRu')
            ->contentType('application/json')
            ->post('https://gateway.ntoprog.org/api/new-transaction', [
                'phone_number' => $phone_number,
                'endpoint' => 'om',
                'amount' => $amount,
                'trans_code' => $reference,
                'currency' => $currency,
                'language' => 'FR',
                'operation' => 'c2b',
                'callback_url' => 'http://payshipping.yandas243.com/api/callback/' . $reference,
                'output' => 1
            ]);*/

        $response = Http::withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNjk5MTc2Mjc5LCJzdWIiOiIyNTU1MWZlNDhlYjAxZTJhYTNhZDQzYjMwNWMxNjU3OSJ9.ynckdKe0wkrGUYg8bJPwUE7BcN4XoHJkNoOL1Tt7KY8')
            ->contentType('application/json')
            ->post('https://backend.flexpay.cd/api/rest/v1/paymentService', [
                'merchant' => 'YANDAS',
                'type' => 1,
                'reference' => $reference,
                'phone' => $phone_number,
                'amount' => $amount,
                'currency' => $currency,
                'callbackUrl' => 'http://delivery.yandas243.com/api/callback/' . $reference,
            ]);


        if ($response->status() == 200) {

            $body =  json_decode($response->body());

            Log::debug($response->body());

            // check result
            if ($body->code == 0) {

                $payment = new Payment;

                $payment->order_id = $order_id;
                $payment->paid_amount = $amount;
                $payment->payment_date = date('Y-m-d');
                $payment->reference_code = $reference;
                $payment->external_code = $body->orderNumber;
                $payment->currency_code = $currency;

                $payment->save();

                $return_value = "OK";

            } else {

                $return_value = "KO";
            }


        } else {

            $return_value = "KO";
        }

        return $return_value;
    }

    public function callback(string $reference)
    {
        $payment = Payment::query()->where('reference_code', $reference);

        if ($payment->exists()) {

            $payment = $payment->first();

            $raw_post = file_get_contents( 'php://input' );
            $decoded  = json_decode( $raw_post );

            Log::info($raw_post);

            $payment->paid = ($decoded->code == 0) ? 'true': 'false';

            $payment->save();

            // update order information

            if ($payment->paid == "true") {

                if ($payment->order->paid_amount < $payment->order->proforma_amount) {

                    $payment->order->update(['payment_status' => 'partial']);

                } else {

                    $payment->order->update(['payment_status' => 'paid']);
                }

                Mail::to([env('MAIL_USERNAME'), auth()->user()->email])->queue(new PaymentRegisteredMail($payment));
            }
        }
    }
}
