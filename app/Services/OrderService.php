<?php

namespace App\Services;

use App\Http\Traits\CodeGeneratorTrait;
use App\Mail\OrderRegisteredMail;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderService
{
    use CodeGeneratorTrait;

    public function __construct(private Request $request)
    {

    }

    public function createHeader(): Order
    {
        $order = new Order;

        // get order items count
        $last_order_code = Order::query()->orderByDesc('id')->limit(1)?->value('code');

        $code = $this->transactionCodeGenerator($last_order_code, 6);

        $order->code = $code;
        $order->enabled = true;
        $order->internal_code = Str::random();
        $order->external_code = sprintf("%s.%s", date('Y.m'), $code);

        return $order;
    }

    public function create()
    {
        $order = $this->createHeader();

        try {

            DB::beginTransaction();

            // persist (save) order
            $this->request->user()->orders()->save($order);

            // prepare saving order details
            $articles = $this->request->input('articles');
            $urls = $this->request->input('urls');
            $quantities = $this->request->input('quantities');
            $descriptions = $this->request->input('descriptions');

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

            return false;
        }

        return $order->internal_code;
    }
}
