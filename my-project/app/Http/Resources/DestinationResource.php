<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);

        $data['region'] = new RegionResource($this->region);

        $data['currency'] = new CurrencyResource($this->currency);

        $data['gallery'] = GalleryResource::collection($this->gallery);

        $data['tours'] = $this->tours->map(function($tour){
            return [
                'id' => $tour->id,
                'title' => $tour->title,
                'slug' => $tour->slug,
                'thumbnail' => $tour->thumbnail,
                'description' => $tour->description,
                'rating' => $tour->rating,
                'view_count' => $tour->view_count,
            ];
        });

        unset(
            $data['region_id'],
            $data['default_currency_id'],
            $data['created_at'],
            $data['updated_at'],
            $data['deleted_at'],
            $data['pivot'],
        );

        return $data;
    }
}
