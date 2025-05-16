<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tours = Tour::with(['categories','guide', 'currency', 'services', 'itineraries', 'gallery'])
                        ->where('is_active', true)
                        ->orderByDesc('popularity')
                        ->paginate(8);

        return (TourResource::collection($tours))
        ->response()
        ->setStatusCode(200, 'Tours retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        $tour->load(['guide', 'currency', 'region', 'accommodation', 'categories', 'gallery', 'destinations', 'itineraries', 'services']);
        return new TourResource($tour);

        // return response()->json([
        //     'data' => $tour,
        // ])->setStatusCode(200, 'Tour retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
