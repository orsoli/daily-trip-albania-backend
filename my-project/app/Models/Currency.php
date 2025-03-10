<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Currency extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
        'is_default'
    ];

    // Relations

    /**
     * Get the tours accociated with the carrecy.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    /**
     * Get the destinations accociated with the carrecy.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }

    /**
     * Get the accommodations accociated with the carrecy.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accommodations(): HasMany
    {
        return $this->hasMany(Accommodation::class);
    }

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array<string, string>
    //  */
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($currency) {
    //         if ($currency->is_default) {
    //             // Çaktivizo monedhën e mëparshme të paracaktuar
    //             static::where('is_default', true)->update(['is_default' => false]);
    //         }
    //     });
    // }

}