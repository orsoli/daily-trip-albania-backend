<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrUpdateDestinationRequest;
use App\Models\Accommodation;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\Region;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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
        $regions = Region::all();
        $accommodations = Accommodation::all();


        return view('admin.destinations.create', compact('regions', 'accommodations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateDestinationRequest $request)
    {
        $destinationData = $request->validated();

        $destinationData['slug'] = Str::slug($destinationData['name']);
        $destinationData['default_currency_id'] = Currency::where('is_default', true)->first()->id;

        // Upload the thumbnail image to Cloudinary if it's provided
        if ($request->hasFile('thumbnail')) {
            // Get the uploaded file
            $file = $request->file('thumbnail');
            // Upload the file to Cloudinary with a transformation (resize and crop)
            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'destinations_thumbnails',
                'transformation' => [
                    [
                        'width' => 400,
                        'height' => 300,
                        'crop' => 'fill',
                        'quality' => 'auto', // Automatically adjust quality
                        'format' => 'webp' // Force WebP format
                    ]
                ]
            ]);

            $destinationData['thumbnail'] = $uploadedFile->getSecurePath();
        }

        $newDestination = Destination::create($destinationData);

        // Connect the newly created destination with accommodations
        if ($request->has('accommodations')) {
            $accommodations = Accommodation::find($request->accommodations);
            $newDestination->accommodations()->saveMany($accommodations);
        }

        // Upload gallery images to Cloudinary if provided
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                // Upload each image to Cloudinary
                $uploadedFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'destinations_gallery', // Specify the folder where gallery images will be stored
                    'transformation' => [
                    [
                        'width' => 1200,
                        'height' => 800,
                        'crop' => 'limit',
                        'quality' => 'auto', // Automatically adjust quality
                        'format' => 'webp' // Force WebP format
                    ]
                ]

                ]);

                // Get the secure URL of the uploaded gallery image
                $imageUrl = $uploadedFile->getSecurePath();

                // Add each uploaded image URL to the gallery table associated with the destination
                $newDestination->gallery()->create([
                    'url' => $imageUrl,
                    'destination_id' => $newDestination->id,
                    'caption' => $image->getClientOriginalName(),
                ]);
            }
        }

        session()->flash('success', $newDestination->name . ' ' . __('static.success_created'));

        return redirect()->route('destinations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        return view('admin.destinations.show', compact('destination', 'apiKey'));
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