<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // // Check if the user is authenticated and their email is not verified
        // if (auth()->user() && is_null(auth()->user()->email_verified_at)) {
        //     // Send verification email
        //     auth()->user()->sendEmailVerificationNotification;

        //     return redirect()->route('verification.notice');
        // }
        return view('dashboard');
    }
}