<?php

use App\Http\Controllers\Admin\UserController;
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
// Verify email route
Route::get('/email/verify', function () {

    return view('auth.verify');

    })->name('verification.notice');

// Dashboard route
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// Admin Users route
Route::prefix('/admin/users/')->name('user.')->group(function () {
    Route::get('index', [UserController::class, 'index'])->name('index')->middleware('superadmin');
    Route::get('{user}/show', [UserController::class, 'show'])->name('show')->middleware('check.profile');
    Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit')->middleware('check.profile');
    Route::put('{user}/update', [UserController::class, 'update'])->name('update')->middleware('check.profile');
    Route::delete('{user}/delete', [UserController::class, 'destroy'])->name('destroy')->middleware('superadmin');
    Route::post('{user}/restore', [UserController::class, 'restore'])->name('restore')->middleware('superadmin');
    Route::delete('{user}/force-delete', [UserController::class, 'forceDelete'])->name('forceDelete')->middleware('superadmin');
});
