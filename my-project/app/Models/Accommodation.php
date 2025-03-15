<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Accommodation extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_name',
        'slug',
        'thumbnail',
        'type',
        'price',
        'default_currency_id',
        'description',
        'country',
        'city',
        'latitude',
        'longitude',
    ];

    // Relations

    /**
     * Get the tour that owns the accommodation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tour(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    /**
     * Get the default currency that owns the accommodation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }

    /**
     * Get the gallery accociated whith the accomodation.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}