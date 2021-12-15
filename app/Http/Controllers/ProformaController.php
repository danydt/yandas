<?php

namespace App\Http\Controllers;

use App\Mail\ProformaEditedMail;
use App\Models\Proforma;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProformaController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $amount = floatval($request->input('amount'));
        $order = intval($request->input('order'));
        $currency = intval($request->input('currency'));
        $modality = intval($request->input('modality'));
        $attachment = $request->file('attachment')->store('public/proformas');

        $proforma = new Proforma;

        $proforma->amount_to_pay = $amount;
        $proforma->currency_id = $currency;
        $proforma->attachment = $attachment;
        $proforma->order_id = $order;
        $proforma->payment_modality = $modality;
        $proforma->code = Str::random();

        try {

            // disable all the past proformas from this order
            Proforma::query()->where('order_id', $order)->update(['enabled' => 'false']);

            $proforma->save();

            // send email
            Mail::to($proforma->order->user->email)->queue(new ProformaEditedMail($proforma->order_code, $proforma->order->client_name));

        } catch (Exception $exception) {

            Log::debug($exception->getMessage());

            return back()->with('message', 'Impossible d\'enregistrer cette proforma');
        }

        return back()->with('message', 'Proforma enregistrée');
    }

    public function download(Proforma $proforma): BinaryFileResponse
    {
        $file = str_replace('public', 'storage', $proforma->attachment);

        return response()->download($file);
    }
}
