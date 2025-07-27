<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function index($city)
    {
        $apiKey = config('services.openweather.key');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}");

        
        return $response->successful() ? $response->json() : null;
    }
}
