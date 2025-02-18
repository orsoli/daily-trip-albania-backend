<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Models\Role;

class RoleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('superadmin');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.createOrUpdate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, Role $role)
    {
        $data = $request->all();

        $role->create($data);

        session()->flash('success', $request->name . ' ' . __('static.success_created'));

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if($role->slug === 'super-admin'){

            return abort(403, 'Unauthorized action.');

        };

        return view('admin.roles.createOrUpdate', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        if($role->slug === 'super-admin'){

            return abort(403, 'Unauthorized action.');

        };

        $data = $request->all();

        $role->update($data);

        session()->flash('success', $request->name . ' ' . __('static.success_update'));

        return redirect()->route('roles.show', $role);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role->slug === 'super-admin'){

            return abort(403, 'Unauthorized action.');

        };

        $role->delete();

        session()->flash('success', $role->name . ' ' . __('static.success.delete'));

        return redirect()->route('roles.index');
    }
}
