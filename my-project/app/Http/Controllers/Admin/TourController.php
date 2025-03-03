<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\storeOrUpdateTourRequest;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Region;
use App\Models\Service;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;

class TourController extends Controller
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
            __('static.title'),
            __('static.categories'),
            __('static.price'),
            __('static.currency'),
            __('static.region'),
            __('static.guide'),
            __('static.is_active'),
            __('static.action')

        ];


        if ($request->has('trashed')) {

            $tours = Tour::onlyTrashed()
                ->paginate(10)
                ->appends(['trashed' => true]);

        } elseif ($request->has('with_trashed')) {

            $tours = Tour::withTrashed()
                ->paginate(10)
                ->appends(['with_trashed' => true]);

        } else {

            $tours = Tour::paginate(10);

        }

        return view('admin.tours.index', compact('columns', 'tours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        $categories = Category::all();
        $destinations = Destination::all();
        $services = Service::all();
        $guides = User::whereHas('role', function ($query) {
                                $query->where('slug', 'guide');
                            })->get();


        return view('admin.tours.create', compact('regions', 'categories', 'destinations', 'services', 'guides'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeOrUpdateTourRequest $request)
    {
        $tour = Tour::create($request->validated());



        $tour->categories()->sync($request->categories);
        $tour->destinations()->sync($request->destinations);
        $tour->services()->sync($request->services);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        return view('admin.tours.show', compact('tour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tour $tour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        //
    }
}