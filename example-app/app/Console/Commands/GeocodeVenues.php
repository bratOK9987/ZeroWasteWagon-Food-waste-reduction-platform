<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partner;

class GeocodeVenues extends Command
{
    protected $signature = 'geocode:venues';
    protected $description = 'Geocode venues using Nominatim';

    public function handle()
    {
        $partners = Partner::whereNull('latitude')->orWhereNull('longitude')->get();

        foreach ($partners as $partner) {
            $location = $this->geocodeAddress($partner->address);
            if ($location) {
                $partner->latitude = $location['lat'];
                $partner->longitude = $location['lon'];
                $partner->save();
                $this->info("Updated {$partner->venue_name} with lat {$location['lat']} and lon {$location['lon']}");
            } else {
                $this->error("Failed to geocode {$partner->venue_name}");
            }
        }
    }

    private function geocodeAddress($address)
    {
        $url = "https://nominatim.openstreetmap.org/search?format=json&limit=1&q=" . urlencode($address);
        $context = stream_context_create(['http' => ['header' => "User-Agent: tadas.joksas126@gmail.com"]]);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return $data[0] ?? false;
    }
}
