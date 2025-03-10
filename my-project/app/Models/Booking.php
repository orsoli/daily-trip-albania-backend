<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tour_id',
        'accommodation_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'reservation_date',
        'num_people',
        'total_price',
        'status',
        'payment_method',
        'notes',

    ];

    // Relations

    /**
     * Define the many-to-one relationship with the Tour model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Define the many-to-one relationship with the Accommodation model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    /**
     * Define the many-to-many relationship with the Destination model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'booking_destination');
    }
}