<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Tour extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guide_id',
        'default_currency_id',
        'category_id',
        'region_id',
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
}
