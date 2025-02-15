<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('superadmin');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = ['Id', __('static.first_name'), __('static.last_name'), __('static.role'), __('static.email_address'), __('static.personal_nr'), __('static.action')];

        if ($request->has('trashed')) {

            $users = User::onlyTrashed()->paginate(10)->appends(['trashed' => true]);

        } elseif ($request->has('with_trashed')) {

            $users = User::withTrashed()->paginate(10)->appends(['with_trashed' => true]);

        } else {

            $users = User::paginate(10);

        }

        return view('admin.users.index', compact('columns','users'));
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
    public function update(UpdateUserRequest $request, User $user)
    {

        // Check if the email has been changed
        if ($request->email !== $user->email) {
            $user->email_verified_at = null; // Remove verification status
        }

        $data = $request->all();

        $user->update($data);

        session()->flash('success', $user->first_name . $user->last_name . ' ' . __('static.success_update'));

        if($request->personal_nr === $user->personal_nr){

            return view('admin.users.show', compact('user'));

        };

        return redirect()->route("user.index");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(auth()->user()->personal_nr === $user->personal_nr){

            return abort(403, 'Unauthorized action.');

        };

        $user->delete();

        session()->flash('success', $user->first_name . ' ' . $user->last_name . ' ' . __('static.success_delete'));

        return redirect()->route('user.index');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();

        session()->flash('success', $user->first_name . ' ' . $user->last_name . ' ' . __('static.success_restore'));

        return redirect()->route('user.index',['trashed' => true]);
    }

    /**
     * Permanently Delete the specified resource from DB.
     */
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->forceDelete();

        session()->flash('success', $user->first_name . ' ' . $user->last_name . ' ' . __('static.success_permanently_delete'));

        return redirect()->route('user.index', ['trashed' => true]);
    }
}
