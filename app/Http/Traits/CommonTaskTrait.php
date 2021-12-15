<?php


namespace App\Http\Traits;


use App\Models\MerchantPayment;
use App\Models\TransactionHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait CommonTaskTrait
{
    private array $declined_codes = [99033, '00068', 152, '00017', '60019', '00036', '701'];

    public function saveTransactionHistory(int $transaction_id, string $origin, string $content, string $status_text)
    {
        $transactionHistory = new TransactionHistory;

        $transactionHistory->transaction_id = $transaction_id;
        $transactionHistory->origin = $origin;
        $transactionHistory->content = $content;
        $transactionHistory->status_text = $status_text;
        $transactionHistory->save();
    }

    /**
     * Send output response to the customer
     * @param Transaction $transaction
     * @param $response
     */
    protected function sendOutput(Transaction $transaction, $response)
    {
        $output_type = $transaction->output_type;
        $redirect_url = $transaction->return_url;

        if (in_array($response, array(0, 1))) {

            $transaction->status = \App\Http\Interfaces\Transaction::TRANSACTION_ONGOING; // ongoing
            $transaction->save();

            echo match ($output_type) {
                \App\Http\Interfaces\Transaction::WOOCOMMERCE_WEB_APP => json_encode([
                    "result" => 'success',
                    "redirect" => trim(strval($redirect_url)),
                    "message" => 'Transaction successfully sent!',
                ]),
                default => json_encode([
                    "result" => "success",
                    "message" => "Transaction successfully sent!",
                ]),
            };

        } else {

            // declined
            $this->updateTransactionStatus($transaction, $response);

            echo match ($output_type) {
                \App\Http\Interfaces\Transaction::WOOCOMMERCE_WEB_APP => json_encode([
                    "result" => 'declined',
                    "redirect" => trim(strval($redirect_url)),
                    "message" => 'Transaction declined',
                ]),
                default => json_encode([
                    "result" => "declined",
                    "message" => 'Transaction declined',
                ]),
            };
        }
    }

    public function createTransactionObject(Request $request): Transaction
    {
        $transaction = new Transaction;

        $endpoint = trim(strval($request->get('endpoint')));
        $amount = trim(floatval($request->get('amount')));
        $external = trim(strval($request->get('trans_code')));
        $account_number = str_shuffle($this->transactionCodeGenerator(null, 15));
        $operation_code = trim(strval($request->get('operation')));
        $callback_url = trim(strval($request->get('callback_url')));
        $generated_code = $this->generateCode($endpoint);
        $currency = trim(strval($request->get('currency')));

        $output_type = intval($request->input('output'));
        $return_url = $request->input('return_url');

        if (in_array($currency, ['Fr', 'fr', 'FR'])) {

            $currency = "CDF";
        }

        $transaction->operation_code = $operation_code;
        $transaction->requesting_code = $external;
        $transaction->generated_code = $generated_code;
        $transaction->endpoint = $endpoint;
        $transaction->amount = $amount;
        $transaction->currency_code = $currency;
        $transaction->account_number = $account_number;
        $transaction->callback_url = $callback_url;
        $transaction->output_type = $output_type;
        $transaction->return_url = $return_url;

        //Log::info("Output type: " . $output_type);

        return $transaction;
    }

    /**
     * @param string $url
     * @param $fields
     * @param array|null $headers
     * @param bool $return_transfer
     * @return bool|string|null
     */
    public function sendCurlRequest(string $url, $fields, array $headers = null, bool $return_transfer = false): bool|string|null
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // added especially for OM transaction
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $return_transfer);

        if ($headers) {

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($return_transfer) {

            $result = curl_exec($ch);

            /*Log::debug("RESULT");
            Log::debug(curl_error($ch));*/

            curl_close($ch);

            return $result;
        }

        curl_exec($ch);

        curl_close($ch);

        return null;
    }

    /**
     * @param Transaction $transaction
     * @param $status
     */
    protected function updateTransactionStatus(Transaction $transaction, $status)
    {
        if (in_array($status, $this->declined_codes)) {

            $transaction->status = \App\Http\Interfaces\Transaction::TRANSACTION_DECLINED;

        } elseif ($status == 200) {

            // completed
            $transaction->status = \App\Http\Interfaces\Transaction::TRANSACTION_COMPLETED;

        } else {

            $transaction->status = \App\Http\Interfaces\Transaction::TRANSACTION_ONGOING;
        }

        $transaction->save();
    }

    private function addCountryPrefix(string $phone_number, int $prefix = 243): string
    {
        $complete_phone_number = null;

        switch (strlen($phone_number)) {

            case 9:
                $complete_phone_number = sprintf('%s%s', $prefix, $phone_number);
                break;
            case 10:
                if ($phone_number[0] == 0) {

                    $complete_phone_number = sprintf('%s%s', $prefix, substr($phone_number, 1));
                }
                break;
        }

        return $complete_phone_number;
    }
}
