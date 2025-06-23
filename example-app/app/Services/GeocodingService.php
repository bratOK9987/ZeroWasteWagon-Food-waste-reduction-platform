<?php

namespace App\Services;

class GeocodingService
{
    public function geocodeAddress($address)
    {
        $userAgent = "YourEmailAddress@example.com";
        $url = "https://nominatim.openstreetmap.org/search?format=json&limit=1&q=" . urlencode($address);
        $context = stream_context_create(['http' => ['header' => "User-Agent: $userAgent"]]);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);

        return $data ? ['lat' => $data[0]['lat'], 'lon' => $data[0]['lon']] : null;
    }
}
