<?php

namespace App\Models;

use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Tour extends Model
{
    use HasFactory, Notifiable, SoftDeletes, MediaAlly;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guide_id',
        'default_currency_id',
        'region_id',
        'accommodation_id',
        'title',
        'slug',
        'thumbnail',
        'description',
        'is_active',
        'price',
        'duration',
        'difficulty',
        'popularity',
        'is_featured',
        'wheelchair_accessible',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


     /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relations

    /**
     * Get the user that owns the tour
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guide(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the currency that owns the tour.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }

    /**
     * Get the categories associated with the tour.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_tour');
    }

    /**
     * Get the region that owns the tour.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the accommodations associated with the tour.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    /**
     * Get the gallery accociated whith the tour.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }


    /**
     * Get the itineraries associated with the tour.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itineraries(): hasMany
    {
        return $this->hasMany(Itinerary::class);
    }

    /**
     * Define the many-to-many relationship with the Destination model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'destination_tour');
    }

    /**
     * Define the many-to-many relationship with the Service model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class , 'tour_service');
    }

    /**
     * Define the one-to-many relationship with the Booking model.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }


    /**
     * The "booted" method of the model.
     * This method is used to handle model events such as deleting, restoring, and force deleting.
     * It ensures that related galleries are also soft deleted, restored, or permanently deleted
     * when the corresponding tour is deleted, restored, or force deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($tour) {
            // Soft delete related galleries
            $tour->gallery()->delete();
            $tour->itineraries()->delete();

        });

        static::restoring(function ($tour) {
            // Restore related galleries when restoring a tour
            $tour->gallery()->restore();
            $tour->itineraries()->restore();
        });

        static::forceDeleted(function ($tour) {
            // Permanently delete related galleries when tour is force deleted
            $tour->gallery()->forceDelete();
            $tour->itineraries()->forceDelete();
        });
    }

}
