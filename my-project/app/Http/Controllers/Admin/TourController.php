<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\storeOrUpdateTourRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\Region;
use App\Models\Service;
use App\Models\Tour;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
       // Validate the request data
        $tourData = $request->validated();

        $tourData['slug'] = Str::slug($tourData['title']);
        $tourData['default_currency_id'] = Currency::where('is_default', true)->first()->id;
        $tourData['created_by'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        // Upload the thumbnail image to Cloudinary if it's provided
        if ($request->hasFile('thumbnail')) {
            // Get the uploaded file
            $file = $request->file('thumbnail');
            // Upload the file to Cloudinary with a transformation (resize and crop)
            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'tours_thumbnails',
                'transformation' => [
                    [
                        'width' => 400,
                        'height' => 500,
                        'crop' => 'fill'
                    ]
                ]
            ]);

            $tourData['thumbnail'] = $uploadedFile->getSecurePath();
        }

        $newTour = Tour::create($tourData);

        // Connect the newly created tour with its categories, destinations, and services
        $newTour->categories()->sync($request->categories ?? []);
        $newTour->destinations()->sync($request->destinations ?? []);
        $newTour->services()->sync($request->services ?? []);

        // Upload gallery images to Cloudinary if provided
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                // Upload each image to Cloudinary
                $uploadedFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'tours_gallery' // Specify the folder where gallery images will be stored
                ]);

                // Get the secure URL of the uploaded gallery image
                $imageUrl = $uploadedFile->getSecurePath();

                // Add each uploaded image URL to the gallery table associated with the tour
                $newTour->gallery()->create([
                    'url' => $imageUrl,
                    'tour_id' => $newTour->id,
                    'caption' => $image->getClientOriginalName(),
                ]);
            }
        }

        session()->flash('success', $newTour->title . ' ' . __('static.success_created'));

        return redirect()->route('tours.index');

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
        $regions = Region::all();
        $categories = Category::all();
        $destinations = Destination::all();
        $services = Service::all();
        $guides = User::whereHas('role', function ($query) {
                                $query->where('slug', 'guide');
                            })->get();

        return view('admin.tours.edit', compact('tour', 'guides', 'regions', 'categories', 'destinations', 'services'));
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
