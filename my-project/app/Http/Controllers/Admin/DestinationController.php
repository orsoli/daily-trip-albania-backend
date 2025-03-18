<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrUpdateDestinationRequest;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\Region;
use App\Services\CloudinaryService;
use App\Services\GeolocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                ->orderBy('deleted_at', 'asc')
                ->paginate(10)
                ->appends(['trashed' => true]);

        } elseif ($request->has('with_trashed')) {

            $destinations = Destination::withTrashed()
                ->orderBy('created_at', 'asc')
                ->paginate(10)
                ->appends(['with_trashed' => true]);

        } else {

            $destinations = Destination::orderBy('created_at', 'asc')->paginate(10);

        }

        return view('admin.destinations.index', compact('columns', 'destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::orderBy('name', 'asc')->get();


        return view('admin.destinations.create', compact('regions'));
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
            $mediaService = new CloudinaryService();
            $uploadedFile = $mediaService->upload($file, 'destinations_thumbnails', [
                    'width' => 400,
                    'height' => 300,
                    'crop' => 'fill',
                    'quality' => 'auto',
                    'format' => 'webp'
                ]);

            if($uploadedFile){
                $destinationData['thumbnail'] = $uploadedFile['url'];
            }else{
                Log::error('Thumbnail upload failed');
                session()->flash('error', __('static.failed_media_upload'));
                return redirect()->back()->withInput();
            }
        }

        // Get coordinates from Google Maps API
        $geoService = new GeolocationService();
        $coordinates = $geoService->getCoordinates($request->name, $request->city, $request->country);

        if($coordinates){
            $destinationData['latitude'] = $coordinates['lat'] ?? null;
            $destinationData['longitude'] = $coordinates['lng'] ?? null;
        }


        $newDestination = Destination::create($destinationData);

        // Upload gallery images to Cloudinary if provided
        if ($request->hasFile('gallery_images')) {
            $files = $request->file('gallery_images');
            foreach ( $files as $file) {
                // Upload each file to Cloudinary
                $mediaServices = new CloudinaryService();
                $uploadedFile = $mediaServices->upload($file, 'destinations_gallery', [
                        'width' => 500,
                        'height' => 500,
                        'crop' => 'limit',
                        'quality' => 'auto',
                        'format' => 'webp'
                    ]);

                if($uploadedFile){
                    // Add each uploaded image URL to the gallery table associated with the destination
                    $newDestination->gallery()->create([
                        'url' => $uploadedFile['url'],
                        'destination_id' => $newDestination->id,
                        'caption' => $uploadedFile['caption'],
                    ]);
                }else{
                    Log::error('Gallery image upload failed');
                    session()->flash('error', __('static.failed_media_upload'));
                    return redirect()->back()->withInput();
                }
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
        $regions = Region::orderBy('name', 'asc')->get();

        return view('admin.destinations.edit', compact('destination', 'regions'));
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
            // Get the uploaded file
            $file = $request->file('thumbnail');

            // Delete the previous thumbnail from Cloudinary
            if ($destination->thumbnail) {
                // Parse only the public_id from the full URL
                $parsedUrl = pathinfo(parse_url($destination->thumbnail, PHP_URL_PATH), PATHINFO_FILENAME);
                $publicId = 'destinations_thumbnails/' . $parsedUrl;

                $mediaService = new CloudinaryService();
                $mediaService->destroy($publicId);
            }

            // Upload the new thumbnail to Cloudinary with transformations
            $mediaServices = new CloudinaryService();
            $uploadedFile = $mediaServices->upload($file, 'destinations_thumbnails', [
                    'width' => 400,
                    'height' => 300,
                    'crop' => 'fill',
                    'quality' => 'auto',
                    'format' => 'webp'
                ]);

            if($uploadedFile){
                $destinationData['thumbnail'] = $uploadedFile['url'];
            }else{
                Log::error('Thumbnail upload failed');
                session()->flash('error', __('static.failed_media_upload'));
                return redirect()->back()->withInput();
            }

        }

        if($request->country !== $destination->country || $request->city !== $destination->city){
            // Get coordinates from Google Maps API
            $geoService = new GeolocationService();
            $coordinates = $geoService->getCoordinates($request->name, $request->city, $request->country);
            $destinationData['latitude'] = $coordinates['lat'] ?? null;
            $destinationData['longitude'] = $coordinates['lng'] ?? null;
        }

        // Update the destination with the modified data
        $destination->update($destinationData);

        // Delete selected gallery images if the user requested
        if ($request->has('delete_gallery_images')) {

            $files = $request->delete_gallery_images;

            foreach ($files as $fileId) {
                $file = $destination->gallery()->find($fileId);
                if ($file) {
                    // Extract public_id from full URL
                    $parsedUrl = pathinfo(parse_url($file->url, PHP_URL_PATH), PATHINFO_FILENAME);
                    $publicId = 'destinations_gallery/' . $parsedUrl;


                    // Delete from Cloudinary
                    $mediaService = new CloudinaryService();
                    $mediaService->destroy($publicId);

                    // Remove from the database
                    $file->forceDelete();
                }
            }
        }

        // Upload new gallery images if provided
        if ($request->hasFile('gallery_images')) {
            $files = $request->file('gallery_images');
            foreach ( $files as $file) {
                // Upload each file to Cloudinary
                $mediaServices = new CloudinaryService();
                $uploadedFile = $mediaServices->upload($file, 'destinations_gallery', [
                        'width' => 500,
                        'height' => 500,
                        'crop' => 'limit',
                        'quality' => 'auto',
                        'format' => 'webp'
                    ]);

                if($uploadedFile){
                    // Add each uploaded image URL to the gallery table associated with the destination
                    $destination->gallery()->create([
                        'url' => $uploadedFile['url'],
                        'destination_id' => $destination->id,
                        'caption' => $uploadedFile['caption'],
                    ]);
                }else{
                    Log::error('Gallery image upload failed');
                    session()->flash('error', __('static.failed_media_upload'));
                    return redirect()->back()->withInput();
                }
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

}