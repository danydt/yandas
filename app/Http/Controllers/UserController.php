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

class UserController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('users.index')->with([
            'users' => User::getUsersByType("admin")
        ]);
    }

    /**
     * Create.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $name = trim(filter_var($request->input('name'), FILTER_SANITIZE_STRING));
        $email = trim(filter_var($request->input('email'), FILTER_SANITIZE_EMAIL));

        $password = Str::random(8);


        $user = new User;

        $user->code = Str::random();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);

        try {

            $user->save();

            Log::info(sprintf("New password for user %s: %s", $name, $password));

        } catch (\Exception $exception) {

            Log::alert($exception->getMessage());
        }



        return redirect()->route('users.show', $user);
    }

    public function show(User $user): Factory|View|Application
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): Factory|View|Application
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $name = trim(filter_var($request->input('name'), FILTER_SANITIZE_STRING));
        $email = trim(filter_var($request->input('email'), FILTER_SANITIZE_EMAIL));

        $user->name = $name;
        $user->email = $email;

        $user->save();

        return redirect()->route('users.show', $user);
    }
}
