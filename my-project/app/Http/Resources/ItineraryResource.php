<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);

        unset(
            $data['tour_id'],
            $data['created_at'],
            $data['updated_at'],
            $data['deleted_at'],
        );

        return $data;
    }
}