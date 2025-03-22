<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Itinerary extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tour_id',
        'day',
        'start_at',
        'lunch_time',
        'end_at',
        'activities',
    ];

    // Relations

    /**
     * Get the tour that owns the itinerary.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }




     // /**
    //  * Set the start_at attribute.
    //  *
    //  * This mutator ensures that the 'start_at' attribute is stored in the
    //  * correct 'H:i' time format. It takes a time string as input, parses it
    //  * using the 'H:i' format, and then re-formats it to ensure consistency.
    //  *
    //  * @param string $value The time value to be set for the 'start_at' attribute.
    //  * @return void
    //  */
    // public function setStartAtAttribute($value)
    // {
    //      dd($value);
    //     $this->attributes['start_at'] = \Carbon\Carbon::createFromFormat('H:i', $value)->format('H:i');
    // }

    // /**
    //  * Set the lunch time attribute.
    //  *
    //  * This mutator ensures that the provided lunch time value is formatted
    //  * correctly as 'H:i' (hours and minutes) before being stored in the
    //  * 'lunch_time' attribute.
    //  *
    //  * @param string $value The lunch time value in 'H:i' format.
    //  * @return void
    //  */
    // public function setLunchTimeAttribute($value)
    // {
    //     $this->attributes['lunch_time'] = \Carbon\Carbon::createFromFormat('H:i', $value)->format('H:i');
    // }

    // /**
    //  * Set the end_at attribute.
    //  *
    //  * This mutator ensures that the 'end_at' attribute is stored in the
    //  * correct 'H:i' time format. It takes a time string as input, parses it
    //  * using the 'H:i' format, and then re-formats it to ensure consistency.
    //  *
    //  * @param string $value The time value to be set for the 'end_at' attribute.
    //  * @return void
    //  */
    // public function setEndAtAttribute($value)
    // {
    //     $this->attributes['end_at'] = \Carbon\Carbon::createFromFormat('H:i', $value)->format('H:i');
    // }
}