<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('measurements.index')->with([
            'measurement' => Measurement::query()->first()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $length = floatval($request->input('length'));
        $width = floatval($request->input('width'));
        $height = floatval($request->input('height'));
        $weight = floatval($request->input('weight'));

        $measurement = new Measurement;

        $measurement->length = $length;
        $measurement->width = $width;
        $measurement->height = $height;
        $measurement->weight = $weight;

        // first truncate everything
        Measurement::query()->truncate();

        $measurement->save();

        return back();
    }

    public function simulate(Request $request)
    {
        if ($request->isMethod('POST')) {

            $length = floatval($request->input('length'));
            $width = floatval($request->input('width'));
            $height = floatval($request->input('height'));
            $weight = floatval($request->input('weight'));

            $measurement = Measurement::query()->first();

            if (!$measurement) {

                return "Paramètres de simulation non encore définis";
            }

            $result = $measurement->length * $length;
            $result += $measurement->width * $width;
            $result += $measurement->height * $height;
            $result += $measurement->weight * $weight;

            return "Vous allez payer $result EUR";
        }

        return view('measurements.create');
    }
}
