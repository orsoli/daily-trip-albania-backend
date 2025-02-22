<?php

use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TourController;
use App\Models\Destination;
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
// Route::prefix('/admin/users/')->name('user.')->group(function () {
//     Route::get('index', [UserController::class, 'index'])->name('index')->middleware('superadmin');
//     Route::get('{user}/show', [UserController::class, 'show'])->name('show')->middleware('check.profile');
//     Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit')->middleware('check.profile');
//     Route::put('{user}/update', [UserController::class, 'update'])->name('update')->middleware('check.profile');
//     Route::delete('{user}/delete', [UserController::class, 'destroy'])->name('destroy')->middleware('superadmin');
//     Route::post('{user}/restore', [UserController::class, 'restore'])->name('restore')->middleware('superadmin');
//     Route::delete('{user}/force-delete', [UserController::class, 'forceDelete'])->name('forceDelete')->middleware('superadmin');
// });

// Users Routes
Route::prefix('/admin/users')->name('user.')->group(function () {

    // SuperAdmin Middleware
    Route::middleware('superadmin')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('index');
        Route::delete('{user}/delete', [UserController::class, 'destroy'])->name('destroy');
        Route::post('{user}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('{user}/force-delete', [UserController::class, 'forceDelete'])->name('forceDelete');
    });

    // Check Profile Middleware
    Route::middleware('check.profile')->group(function () {
        Route::get('{user}/show', [UserController::class, 'show'])->name('show');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{user}/update', [UserController::class, 'update'])->name('update');
    });
});

// Roles Routes
Route::prefix('admin')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('tours', TourController::class);
    Route::resource('destinations', DestinationController::class);
});
