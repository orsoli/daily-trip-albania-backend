<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $bookings = Booking::count();

        $statistics = Booking::selectRaw('YEAR(reservation_date) as year, MONTH(reservation_date) as month, COUNT(*) as bookings_count, SUM(total_price) as total_booking_price')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $years = Booking::selectRaw('YEAR(reservation_date) as year')
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year');

        // $statistics = Booking::join('tours', 'bookings.tour_id', '=', 'tours.id')
        //     ->selectRaw('tours.title as tour_title, COUNT(bookings.id) as total_bookings')
        //     ->groupBy('tours.id', 'tours.title')
        //     ->orderBy('tour_title')
        //     ->get();

            // dd($statistics);

        return view('admin.bookings.index', compact('statistics', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}