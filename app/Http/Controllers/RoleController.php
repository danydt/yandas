<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    /**
     * Create.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $role = new Role;

        $role->code = Str::random();
        $role->name = trim(strip_tags(strval($request->input('name'))));
        $role->default_sidebar = trim(strval($request->input('sidebar')));
        $role->default_dashboard = trim(strval($request->input('dashboard')));
        $role->default_navigation_bar = trim(strval($request->input('navigation')));

        $role->save();

        return redirect()->route('roles.show', $role->code);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function show(Role $role): Factory|View|Application
    {
        return view('roles.show', compact('role'));
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
