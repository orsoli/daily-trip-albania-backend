<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $destinations = Destination::with(['region', 'currency', 'gallery', 'tours'])
                    ->where('is_visible', true)
                    ->withCount([
                        'tours as max_tour_popularity' => function ($query) {
                            $query->select(DB::raw('COALESCE(MAX(popularity), 0)'));
                        }
                    ])
                    ->orderByDesc('max_tour_popularity')
                    ->paginate(10);

                    return response()->json([
                        'data' => $destinations->items(),
                        'pagination' => [
                            'current_page' => $destinations->currentPage(),
                            'last_page' => $destinations->lastPage(),
                            'per_page' => $destinations->perPage(),
                            'total' => $destinations->total(),
                        ],
                    ])->setStatusCode(200, 'Destination retrieved successfully');
    }
}