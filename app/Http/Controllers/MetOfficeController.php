<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MetOfficeController extends Controller
{
    /**
     * Fetch weather data from MetOffice API and store response in cache.
     *
     * @return bool
     */
    public function cache()
    {
        $apiKey = env('METOFFICE_API_KEY');
        $dundees = config('dundees');
        $random = $dundees[array_rand($dundees)];
        $endpoint = env('METOFFICE_API_ENDPOINT') . "daily?latitude={$random['latitude']}&longitude={$random['longitude']}";

        echo "Fetching weather for: " . $random['country'] . PHP_EOL;

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "apikey: $apiKey"
            ],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            echo "Error fetching weather data: HTTP $httpCode\n";
            return false;
        }

        Cache::put('weather_response', json_decode($response, true), now()->addHour(6));

        return true;
    }
}
