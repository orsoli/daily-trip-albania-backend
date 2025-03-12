<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
                $columns = [
            __('static.image'),
            __('static.name'),
            __('static.country'),
            __('static.city'),
            __('static.price'),
            __('static.currency'),
            __('static.visibility'),
            __('static.action')

        ];


        if ($request->has('trashed')) {

            $destinations = Destination::onlyTrashed()
                ->paginate(10)
                ->appends(['trashed' => true]);

        } elseif ($request->has('with_trashed')) {

            $destinations = Destination::withTrashed()
                ->paginate(10)
                ->appends(['with_trashed' => true]);

        } else {

            $destinations = Destination::paginate(10);

        }

        return view('admin.destinations.index', compact('columns', 'destinations'));
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
    public function show(Destination $destination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        //
    }
}