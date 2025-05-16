<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['guide'] = [
            'first_name' => $this->guide->first_name,
            'last_name'  => $this->guide->last_name,
        ];

        $data['currency'] = new CurrencyResource($this->currency);

        $data['region'] = new RegionResource($this->region);

        $data['accommodation'] = new AccommodationResource($this->accommodation);

        $data['categories'] = CategoryResource::collection($this->categories);

        $data['gallery'] = GalleryResource::collection($this->gallery);

        $data['services'] = ServiceResource::collection($this->services);

        $data['destinations'] = $this->destinations->map(function ($destination){
            return [
                'id' => $destination->id,
                'name' => $destination->name,
                'slug' => $destination->slug,
                'thumbnail' => $destination->thumbnail,
                'latitude' => $destination->latitude,
                'longitude' => $destination->longitude,

            ];
        });

        $data['itineraries'] = ItineraryResource::collection($this->itineraries);

        $data['bookings_count'] = $this->bookings->count();

        unset(
            $data['guide_id'],
            $data['default_currency_id'],
            $data['region_id'],
            $data['accommodation_id'],
            $data['created_at'],
            $data['created_by'],
            $data['updated_at'],
            $data['updated_by'],
            $data['deleted_at'],
            $data['deleted_by']
        );

        return $data;
    }
}
