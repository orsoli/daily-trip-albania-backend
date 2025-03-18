<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GeolocationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GOOGLE_MAPS_API_KEY');
    }

    public function getCoordinates($destinationName, $city, $country)
    {
        $query = urlencode("$destinationName, $country, $city");
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$query}&key={$this->apiKey}";

        try {
            $response = $this->client->get($url);
            $data = json_decode($response->getBody(), true);

            if (!empty($data['results'])) {
                return $data['results'][0]['geometry']['location']; // ['lat' => ..., 'lng' => ...]
            }
        } catch (\Exception $e) {
            Log::error('Geolocation API error: ' . $e->getMessage());
            return null;
        }

        return null;
    }
}