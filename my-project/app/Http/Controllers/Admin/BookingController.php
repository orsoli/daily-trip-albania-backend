<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
        if ($request->has('pending')) {

            $bookings = Booking::where('status', 'pending')
                ->whereDate('reservation_date', '>=', Carbon::today())
                ->orderBy('reservation_date')
                ->paginate(10)
                ->appends(['pending' => true]);

        } elseif ($request->has('all_status')) {

            $bookings = Booking::orderBy('reservation_date', 'desc')
                ->paginate(10)
                ->appends(['all_status' => true]);

        } else {

            $bookings = Booking::where('status', 'confirmed')
                ->whereDate('reservation_date', '>=', Carbon::today())
                ->orderBy('reservation_date')
                ->paginate(10);
        }

        return view('admin.bookings.index', compact('bookings'));
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
        return view('admin.bookings.show', compact('booking'));
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


    /**
     * Display statistics of the resource
     */
    public function statistics(){

        $statistics = Booking::selectRaw('YEAR(reservation_date) as year, MONTH(reservation_date) as month, COUNT(*) as bookings_count, SUM(total_price) as total_booking_price')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $years = Booking::selectRaw('YEAR(reservation_date) as year')
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year');

        return view('admin.bookings.statistics', compact('statistics', 'years'));
    }
}