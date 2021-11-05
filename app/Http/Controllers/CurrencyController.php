<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('currencies.index')->with([
            'currencies' => Currency::query()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request): Response|RedirectResponse
    {
        $currency = new Currency();

        $currency->code = Str::lower(trim(strval($request->input('code'))));
        $currency->name = trim(strval($request->input('name')));

        try {

            $currency->save();

        } catch (Exception $exception) {

            Log::debug($exception->getMessage());

            return back()->withInput();
        }

        return redirect()->route('currencies.show', $currency->code);
    }

    /**
     * Display the specified resource.
     *
     * @param  Currency  $currency
     * @return Application|Factory|View
     */
    public function show(Currency $currency): View|Factory|Application
    {
        return view('currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Currency  $currency
     * @return Application|Factory|View
     */
    public function edit(Currency $currency): View|Factory|Application
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Currency $currency
     * @return RedirectResponse|Response
     */
    public function update(Request $request, Currency $currency): Response|RedirectResponse
    {
        $currency->code = Str::lower(trim(strval($request->input('code'))));
        $currency->name = trim(strval($request->input('name')));

        try {

            $currency->save();

        } catch (Exception $exception) {

            Log::debug($exception->getMessage());

            return back()->withInput();
        }

        return redirect()->route('currencies.show', $currency->code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
