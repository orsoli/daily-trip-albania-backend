<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Destination extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'region_id',
        'name',
        'slug',
        'thumbnail',
        'price',
        'default_currency_id',
        'country',
        'city',
        'description',
        'nearest_airport',
        'latitude',
        'longitude',
        'is_visible'
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
     * Get the region that owns the destination.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the currency that owns the destination.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }

    /**
     * Get the gallery accociated with the destination.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Define a many-to-many relationship with the Tour model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class);
    }

    /**
     * Define the many-to-many relationship with the Booking model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_destinaiton');
    }
}
