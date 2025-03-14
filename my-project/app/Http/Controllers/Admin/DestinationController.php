<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrUpdateDestinationRequest;
use App\Models\Accommodation;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\Region;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use GuzzleHttp\Client;
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

        // Get coordinates from Google Maps API
        $coordinates = $this->getCoordinates($request->country, $request->city);

        $destinationData['latitude'] = $coordinates['lat'] ?? null;
        $destinationData['longitude'] = $coordinates['lng'] ?? null;


        $newDestination = Destination::create($destinationData);

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
        $regions = Region::all();
        $accommodations = Accommodation::all();

        return view('admin.destinations.edit', compact('destination', 'regions', 'accommodations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateDestinationRequest $request, Destination $destination)
    {
        // Validate the request data
        $destinationData = $request->validated();

        // Only update the slug if the name has changed
        if ($destinationData['name'] !== $destination->name) {
            $destinationData['slug'] = Str::slug($destinationData['name']);
        }

        // If a new thumbnail is uploaded, remove the old one and upload the new one
        if ($request->hasFile('thumbnail')) {
            // Parse only the public_id from the full URL
            $publicId = pathinfo(parse_url($destination->thumbnail, PHP_URL_PATH), PATHINFO_FILENAME);
            // Delete the previous thumbnail from Cloudinary
            if ($destination->thumbnail) {
                Cloudinary::destroy('destinations_thumbnails/' . $publicId);
            }

            // Upload the new thumbnail to Cloudinary with transformations
            $file = $request->file('thumbnail');
            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'destinations_thumbnails',
                'transformation' => [
                    [
                        'width'   => 400,
                        'height'  => 300,
                        'crop'    => 'fill',
                        'quality' => 'auto', // Automatically adjust quality
                        'format' => 'webp' // Force WebP format
                    ]
                ]
            ]);

            // Store the new thumbnail URL
            $destinationData['thumbnail'] = $uploadedFile->getSecurePath();
        }

        // Get coordinates from Google Maps API
        $coordinates = $this->getCoordinates($request->country, $request->city);

        $destinationData['latitude'] = $coordinates['lat'] ?? null;
        $destinationData['longitude'] = $coordinates['lng'] ?? null;

        // Update the destination with the modified data
        $destination->update($destinationData);


        // Delete selected gallery images if the user requested
        if ($request->has('delete_gallery_images')) {
            foreach ($request->delete_gallery_images as $imageId) {
                $image = $destination->gallery()->find($imageId);
                if ($image) {
                    // Extract public_id from full URL
                    $publicId = pathinfo(parse_url($image->url, PHP_URL_PATH), PATHINFO_FILENAME);
                    // Delete from Cloudinary
                    Cloudinary::destroy('destinations_gallery/' . $publicId);

                    // Remove from the database
                    $image->forceDelete();
                }
            }
        }

        // Upload new gallery images if provided
        if ($request->hasFile('gallery_images') && count($request->file('gallery_images')) > 0) {
            foreach ($request->file('gallery_images') as $image) {
                // Upload image to Cloudinary
                $uploadedFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'destinations_gallery',
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

                // Store the uploaded image in the database
                $destination->gallery()->create([
                    'url' => $uploadedFile->getSecurePath(),
                    'destination_id' => $destination->id,
                    'caption' => $image->getClientOriginalName(),
                ]);
            }
        }

        // Flash success message
        session()->flash('success', $destination->name . ' ' . __('static.success_update'));

        return redirect()->route('destinations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        //
    }



    /**
     * Retrieves the geographical coordinates (latitude and longitude) for a given country and city.
     *
     * @param string $country The name of the country.
     * @param string $city The name of the city.
     * @return array|null An associative array with 'lat' and 'lng' keys if coordinates are found, or null if not found or an error occurs.
     */
    private function getCoordinates($country, $city)
    {
        $client = new Client();
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $query = urlencode("$city, $country");
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$query}&key={$apiKey}";

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            if (!empty($data['results'])) {
                return $data['results'][0]['geometry']['location']; // ['lat' => ..., 'lng' => ...]
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }
}
