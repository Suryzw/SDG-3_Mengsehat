<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function getCityFromCoordinates(Request $request)
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');

        if (!$lat || !$lon) {
            return response()->json(['city' => null], 400);
        }

        $apiKey = config('services.openweathermap.api_key');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric'
        ]);

        if ($response->successful()) {
            $city = $response->json()['name'] ?? null;
            return response()->json(['city' => $city]);
        }

        return response()->json(['city' => null], 500);
    }
}
