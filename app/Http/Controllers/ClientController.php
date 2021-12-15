<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('clients.index')->with([
            'clients' => User::getUsersByType("customer")
        ]);
    }

    /**
     * Create.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('clients.create');
    }

    public function show(User $client): RedirectResponse|Factory|View|Application
    {
        if (auth()->user()->user_type == "customer") {

            return back();
        }

        return view('clients.show', compact('client'));
    }

    public function edit(User $client): Factory|View|Application
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, User $client): RedirectResponse
    {
        $name = trim(strip_tags($request->input('name')));

        $client->name = $name;

        $client->save();

        return redirect()->route('clients.show', $client);
    }
}
