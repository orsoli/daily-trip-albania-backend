<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Tour;
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

        // $totVisitors =

        $totBookings = Booking::count();

        $totDestinations = Destination::count();

        $totTours = Tour::count();

        $totViewTours = Tour::sum('view_count');

        $totAccommodations = Accommodation::count();

        $tourStatistics = Booking::join('tours', 'bookings.tour_id', '=', 'tours.id')
            ->selectRaw('tours.title as tour_title, COUNT(bookings.id) as total_bookings')
            ->groupBy('tours.id', 'tours.title')
            ->orderBy('tour_title')
            ->get();

         $columns = [
            [
                'title' => __('static.tours_visitors'),
                'tot' => $totViewTours,
                'icon' => 'bi bi-eyeglasses',
            ],
            [
                'title' => __('static.bookings'),
                'tot' =>$totBookings,
                'icon' => 'bi bi-calendar-check',
            ],
            [
                'title' => __('static.destinations'),
                'tot' => $totDestinations,
                'icon' => 'bi bi-pin-map',
            ],
            [
                'title' => __('static.tours'),
                'tot' => $totTours,
                'icon' => 'bi bi-luggage',
            ],
            [
                'title' => __('static.accommodations'),
                'tot' => $totAccommodations,
                'icon' => 'bi bi-building-check',
            ],
        ];

        return view('dashboard', compact('columns','tourStatistics','totBookings', 'totDestinations', 'totTours', 'totAccommodations'));
    }
}
