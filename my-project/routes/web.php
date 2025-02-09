<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {

    // Cjeck if user has verified email
    if (auth()->user()->hasVerifiedEmail()) {

        return redirect()->route('dashboard');
    }
    return view('auth.verify');
    })->middleware('auth')->name('verification.notice');

// Dashboard route
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// Admin Users route
Route::prefix('/admin/users/')->name('user.')->group(function () {
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::get('show/{user}', [UserController::class, 'show'])->name('show');
    Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::put('update/{user}', [UserController::class, 'update'])->name('update')->middleware(['auth', 'can:update,user']);
});