<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateUserRequest;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('superadmin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = ['Id', __('static.first_name'), __('static.last_name'), __('static.role'), __('static.email_address'), __('static.personal_nr'), __('static.action')];
        // Get All users
        $users = User::all();

        return view('admin.users.index', compact('columns', 'users'));
    }

    /**
     * Display the specified resource
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOrUpdateUserRequest $request, User $user)
    {

        Gate::authorize('update-user', $user);

        $data = $request->all();

        // Password check
        if($data['password'] == ''){
            $data['password'] = $user->password;
        }else{
            $data['password'] = Hash::make($data['password']);
        };

        $user->update($data);

        // If the logged-in user is updating their own profile, log them out and redirect to login
        if($user->id == auth()->user()->id){

            auth()->logout();

            session()->flush();

            session()->flash('success', $user->first_name . ' ' . __('static.profile_update'));

            return redirect()->route('login');
        }

        session()->flash('success', $user->first_name . ' ' . __('static.success_update'));

        return redirect()->route("user.index");
    }
}