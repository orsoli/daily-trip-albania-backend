<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\TourController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('guest')->group(function () {
    // Tours Route
    Route::prefix('tours')->name('api.tours.')->group(function () {
        Route::get('', [TourController::class, 'index'])->name('index');
    });

    // Destinations Route
    Route::prefix('destinations')->name('api.destinations.')->group(function() {
        Route::get('', [DestinationController::class, 'index'])->name('index');
    });

    // Category Route
    Route::prefix('categories')->name('api.categories.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
    });
});