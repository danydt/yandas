<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrderResource;
use App\Mail\OrderRegisteredMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\OrderService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::query()->where('user_id', auth()->id())->orderByDesc('id')->get();

        return $this->sendResponse(OrderResource::collection($orders), 'order items paginated by desc');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->getContentType() == 'json') {

            if ($request->has('items')) {

                $order = (new OrderService($request))->createHeader();

                try {

                    DB::beginTransaction();

                    auth()->user()->orders()->save($order);

                    $items = $request->input('items');

                    foreach ($items as $item) {

                        $detail = new OrderDetail;

                        $detail->product_name = trim(strval($item['article']));
                        $detail->product_url = trim(strval($item['url']));
                        $detail->quantity = trim(intval($item['quantity']));
                        $detail->description = trim(strval($item['description']));

                        $order->details()->save($detail);
                    }

                    DB::commit();

                     // send mail only if order has been saved
                    // Mail::to([env('MAIL_USERNAME'), auth()->user()->email])->queue(new OrderRegisteredMail($order->code));

                    return $this->sendResponse([
                        'code' => $order->internal_code
                    ], 'Order created!');

                } catch (QueryException $exception) {

                    Log::debug($exception->getMessage());

                    return $this->sendError([], 'Cannot persist data. Verify your data and retry.');
                }
            }

            return $this->sendError([], 'Cannot find items key');
        }

        return $this->sendError([], 'Invalid content type. Should be application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id){
            $order = Order::where('internal_code', $id);

            $items = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                            ->select('order_details.product_name', 'order_details.product_url', 'quantity', 'description')
                            ->where('order_details.order_id', 7)->get();

            dd($order);
            $data ['order'] = $order->get();
            $data ['items'] = $items;

            return $this->sendResponse($data, 'Voici la commande');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}