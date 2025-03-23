<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper as Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\storeOrUpdateTourRequest;
use App\Models\Accommodation;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\Region;
use App\Models\Service;
use App\Models\Tour;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            __('static.visibility'),
            __('static.action')

        ];


        if ($request->has('trashed')) {

            $tours = Tour::onlyTrashed()
                ->orderBy('deleted_at', 'asc')
                ->paginate(10)
                ->appends(['trashed' => true]);

        } elseif ($request->has('with_trashed')) {

            $tours = Tour::withTrashed()
                ->orderBy('created_at', 'asc')
                ->paginate(10)
                ->appends(['with_trashed' => true]);

        } else {

            $tours = Tour::orderBy('created_at', 'asc')
                ->paginate(10);

        }

        return view('admin.tours.index', compact('columns', 'tours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $destinations = Destination::orderBy('name', 'asc')->get();
        $services = Service::orderBy('name', 'asc')->get();
        $accommodations = Accommodation::orderBy('property_name', 'asc')->get();
        $guides = User::whereHas('role', function ($query) {
                                $query->where('slug', 'guide');
                            })->orderBy('first_name', 'asc')->get();


        return view('admin.tours.create', compact('regions', 'categories', 'destinations', 'services', 'accommodations', 'guides'));
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
        $tourData['created_by'] = auth()->user()->email;

        // Upload the thumbnail image to Cloudinary if it's provided
        if ($request->hasFile('thumbnail')) {
            // Get the uploaded file
            $file = $request->file('thumbnail');

            // Upload the file to Cloudinary with a transformation (resize and crop)
            $mediaService = new CloudinaryService();
            $uploadedFile = $mediaService->upload($file, 'tours_thumbnails', [
                    'width' => 400,
                    'height' => 300,
                    'crop' => 'fill',
                    'quality' => 'auto',
                    'format' => 'webp'
                ]);

            if($uploadedFile){
                $tourData['thumbnail'] = $uploadedFile['url'];
            }else{
                Log::error('Thumbnail upload failed');
                session()->flash('error', __('static.failed_media_upload'));
                return redirect()->back()->withInput();
            }
        }

        $newTour = Tour::create($tourData);

        // Connect the newly created tour with its categories, destinations, and services
        $newTour->categories()->sync($request->categories ?? []);
        $newTour->destinations()->sync($request->destinations ?? []);
        $newTour->services()->sync($request->services ?? []);

        // Handle itineraries if provided
        if($request->itineraries){
            // Create itineraries for this tour
            foreach($request->itineraries as $itinerary){

                $newTour->itineraries()->create([
                    'tour_id' => $newTour->id,
                    'day' => $itinerary['day'],
                    'start_at' => $itinerary['start_at'],
                    'lunch_time' => $itinerary['lunch_time'],
                    'end_at' => $itinerary['end_at'],
                    'activities' => $itinerary['activities'],
                ]);
            }
        };

        // Upload gallery images to Cloudinary if provided
        if ($request->hasFile('gallery_images')) {
            $files = $request->file('gallery_images');
            foreach ( $files as $file) {
                // Upload each file to Cloudinary
                $mediaServices = new CloudinaryService();
                $uploadedFile = $mediaServices->upload($file, 'tours_gallery', [
                        'width' => 500,
                        'height' => 500,
                        'crop' => 'limit',
                        'quality' => 'auto',
                        'format' => 'webp'
                    ]);

                if($uploadedFile){
                    // Add each uploaded image URL to the gallery table associated with the tour
                    $newTour->gallery()->create([
                        'url' => $uploadedFile['url'],
                        'tour_id' => $newTour->id,
                        'caption' => $uploadedFile['caption'],
                    ]);
                }else{
                    Log::error('Gallery image upload failed');
                    session()->flash('error', __('static.failed_media_upload'));
                    return redirect()->back()->withInput();
                }
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
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        return view('admin.tours.show', compact('tour', 'apiKey'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tour $tour)
    {

        $regions = Region::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $destinations = Destination::orderBy('name', 'asc')->get();
        $services = Service::orderBy('name', 'asc')->get();
        $accommodations = Accommodation::orderBy('property_name', 'asc')->get();
        $guides = User::whereHas('role', function ($query) {
                                $query->where('slug', 'guide');
                            })->orderBy('first_name', 'asc')->get();

        return view('admin.tours.edit', compact('tour', 'guides', 'regions', 'categories', 'destinations', 'services', 'accommodations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(storeOrUpdateTourRequest $request, Tour $tour)
    {

        // Validate the request data
        $tourData = $request->validated();

        // Only update the slug if the title has changed
        if ($tourData['title'] !== $tour->title) {
            $tourData['slug'] = Str::slug($tourData['title']);
        }

        // Store the name of the user who updated the tour
        $tourData['updated_by'] = auth()->user()->email;

        // If a new thumbnail is uploaded, delete the old one and upload the new one
        if ($request->hasFile('thumbnail')) {
            // Get the uploaded file
            $file = $request->file('thumbnail');

            // Delete the previous thumbnail from Cloudinary
            if ($tour->thumbnail) {
                // Parse only the public_id from the full URL
                $parsedUrl = pathinfo(parse_url($tour->thumbnail, PHP_URL_PATH), PATHINFO_FILENAME);
                $publicId = 'tours_thumbnails/' . $parsedUrl;

                $mediaService = new CloudinaryService();
                $mediaService->destroy($publicId);
            }

            // Upload the new thumbnail to Cloudinary with transformations
            $mediaServices = new CloudinaryService();
            $uploadedFile = $mediaServices->upload($file, 'tours_thumbnails', [
                    'width' => 400,
                    'height' => 300,
                    'crop' => 'fill',
                    'quality' => 'auto',
                    'format' => 'webp'
                ]);

            if($uploadedFile){
                $tourData['thumbnail'] = $uploadedFile['url'];
            }else{
                Log::error('Thumbnail upload failed');
                session()->flash('error', __('static.failed_media_upload'));
                return redirect()->back()->withInput();
            }

        }

        // Update the tour with the modified data
        $tour->update($tourData);

        // Sync categories only if they are different
        if ($tour->categories->pluck('id')->sort()->values()->toArray() !== ($request->categories ?? [])) {
            $tour->categories()->sync($request->categories ?? []);
        }
        // Sync destinations only if they are different
        if ($tour->destinations->pluck('id')->sort()->values()->toArray() !== ($request->destinations ?? [])) {
            $tour->destinations()->sync($request->destinations ?? []);
        }

        // Sync services only if they are different
        if ($tour->services->pluck('id')->sort()->values()->toArray() !== ($request->services ?? [])) {
            $tour->services()->sync($request->services ?? []);
        }




        //!----------Itineraries -----------------

        // Get request and tour itineraries data
        $requestItineraries = $request->itineraries ?? [];
        $existItineraries = $tour->itineraries()
            ->select('id', 'day', 'start_at', 'lunch_time', 'end_at', 'activities')
            ->get()
            ->map(function ($itinerary) {
                return [
                    'id' => $itinerary->id,
                    'day' => $itinerary->day,
                    'start_at' => Helper::formatTime($itinerary->start_at),
                    'lunch_time' => Helper::formatTime($itinerary->lunch_time),
                    'end_at' => Helper::formatTime($itinerary->end_at),
                    'activities' => $itinerary->activities,
                ];
            })
            ->keyBy('id')
            ->toArray();

        // Convert request itineraries to collection and key by day
        $requestItineraries = collect($requestItineraries)->keyBy('id')->toArray();

        // Check if there are changes
        if ($existItineraries !== $requestItineraries) {

            // **Update existing itineraries**
            foreach ($requestItineraries as $id => $requestItinerary) {
                if (isset($existItineraries[$id]) && $requestItinerary !== $existItineraries[$id]) {
                    $tour->itineraries()->where('id', $id)->update($requestItinerary);
                }
            }

            // **Delete removed itineraries**
            $deletedIds = array_diff_key($existItineraries, $requestItineraries);
            if (!empty($deletedIds)) {
                $tour->itineraries()->whereIn('id', array_keys($deletedIds))->forceDelete();
            }

            // **Add new itineraries**
            $newItineraries = array_diff_key($requestItineraries, $existItineraries);
            if (!empty($newItineraries)) {
                $tour->itineraries()->createMany($newItineraries);
            }
        }

        //!--------------- itineraries End ----------------



        // Delete selected gallery images if the user requested
        if ($request->has('delete_gallery_images')) {

            $files = $request->delete_gallery_images;

            foreach ($files as $fileId) {
                $file = $tour->gallery()->find($fileId);
                if ($file) {
                    // Extract public_id from full URL
                    $parsedUrl = pathinfo(parse_url($file->url, PHP_URL_PATH), PATHINFO_FILENAME);
                    $publicId = 'tours_gallery/' . $parsedUrl;

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
                $uploadedFile = $mediaServices->upload($file, 'tours_gallery', [
                        'width' => 500,
                        'height' => 500,
                        'crop' => 'limit',
                        'quality' => 'auto',
                        'format' => 'webp'
                    ]);

                if($uploadedFile){
                    // Add each uploaded image URL to the gallery table associated with the tour$tour
                    $tour->gallery()->create([
                        'url' => $uploadedFile['url'],
                        'tour$tour_id' => $tour->id,
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
        session()->flash('success', $tour->title . ' ' . __('static.success_update'));

        return redirect()->route('tours.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        $tour['deleted_by'] = auth()->user()->email;
        $tour['is_active'] = false;
        $tour->update();

        $tour->delete();

        session()->flash('success', $tour->title . __('static.success_delete'));

        return redirect()->route('tours.index');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $tour = Tour::onlyTrashed()->findOrFail($id);

        $tour['deleted_by'] = 'restored by' . ' ' . auth()->user()->email;

        $tour->restore();

        session()->flash('success', $tour->title . ' ' . __('static.success_restore'));

        return redirect()->route('tours.index',['trashed' => true]);
    }

    /**
     * Permanently Delete the specified resource from DB.
     */
    public function forceDelete($id)
    {
        $tour = Tour::onlyTrashed()->findOrFail($id);

        // If a new thumbnail is uploaded, delete the old one and upload the new one
        if ($tour->thumbnail) {
            // Parse only the public_id from the full URL
            $parsedUrl = pathinfo(parse_url($tour->thumbnail, PHP_URL_PATH), PATHINFO_FILENAME);
            $publicId = 'tours_thumbnails/' . $parsedUrl;

            $mediaService = new CloudinaryService();
            $mediaService->destroy($publicId);
        }

        // Get only trashed galleries
        $files = $tour->gallery()->onlyTrashed()->get();

        // Delete selected gallery images if the user requested
        if ($files->isNotEmpty()) {
            foreach ($files as $file) {
                if ($file) {
                    // Extract public_id from full URL
                    $parsedUrl = pathinfo(parse_url($file->url, PHP_URL_PATH), PATHINFO_FILENAME);
                    $publicId = 'tours_gallery/' . $parsedUrl;

                    // Delete from Cloudinary
                    $mediaService = new CloudinaryService();
                    $mediaService->destroy($publicId);

                    // Remove from the database
                    $file->forceDelete();
                }
            }
        }

        $tour->forceDelete();

        session()->flash('success', $tour->title . ' ' . __('static.success_permanently_delete'));

        return redirect()->route('tours.index', ['trashed' => true]);
    }
}