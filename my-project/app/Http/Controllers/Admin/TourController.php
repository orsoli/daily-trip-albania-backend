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
            __('static.visibility'),
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
        $tourData['created_by'] = auth()->user()->email;

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
                        'height' => 300,
                        'crop' => 'fill',
                        'quality' => 'auto', // Automatically adjust quality
                        'format' => 'webp' // Force WebP format
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
                    'folder' => 'tours_gallery', // Specify the folder where gallery images will be stored
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

        // If a new thumbnail is uploaded, remove the old one and upload the new one
        if ($request->hasFile('thumbnail')) {
            // Parse only the public_id from the full URL
            $publicId = pathinfo(parse_url($tour->thumbnail, PHP_URL_PATH), PATHINFO_FILENAME);
            // Delete the previous thumbnail from Cloudinary
            if ($tour->thumbnail) {
                Cloudinary::destroy('tours_thumbnails/' . $publicId);
            }

            // Upload the new thumbnail to Cloudinary with transformations
            $file = $request->file('thumbnail');
            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'tours_thumbnails',
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
            $tourData['thumbnail'] = $uploadedFile->getSecurePath();
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

        // Delete selected gallery images if the user requested
        if ($request->has('delete_gallery_images')) {
            foreach ($request->delete_gallery_images as $imageId) {
                $image = $tour->gallery()->find($imageId);
                if ($image) {
                    // Extract public_id from full URL
                    $publicId = pathinfo(parse_url($image->url, PHP_URL_PATH), PATHINFO_FILENAME);
                    // Delete from Cloudinary
                    Cloudinary::destroy('tours_gallery/' . $publicId);

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
                    'folder' => 'tours_gallery',
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
                $tour->gallery()->create([
                    'url' => $uploadedFile->getSecurePath(),
                    'tour_id' => $tour->id,
                    'caption' => $image->getClientOriginalName(),
                ]);
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

        // Delete the thumbnail from Cloudinary if it exists
        if ($tour->thumbnail) {
            // Parse only the public_id from the full URL
            $publicId = pathinfo(parse_url($tour->thumbnail, PHP_URL_PATH), PATHINFO_FILENAME);
            // Delete the previous thumbnail from Cloudinary
            if ($tour->thumbnail) {
                Cloudinary::destroy('tours_thumbnails/' . $publicId);
            }
        }

        // Get only trashed galleries
        $galleries = $tour->gallery()->onlyTrashed()->get();
        // Delete selected gallery images if the user requested
        if ($galleries->isNotEmpty()) {
            foreach ($galleries as $image) {
                // Extract public_id from full URL
                $publicId = pathinfo(parse_url($image->url, PHP_URL_PATH), PATHINFO_FILENAME);
                // Delete from Cloudinary
                Cloudinary::destroy('tours_gallery/' . $publicId);
             }
        }

        $tour->forceDelete();

        session()->flash('success', $tour->title . ' ' . __('static.success_permanently_delete'));

        return redirect()->route('tours.index', ['trashed' => true]);
    }
}
