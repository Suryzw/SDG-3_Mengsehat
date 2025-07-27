<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Untuk logging error

class OpenWeatherMapService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openweathermap.api_key');
        $this->baseUrl = config('services.openweathermap.base_url');
    }

    /**
     * Mengambil data cuaca saat ini berdasarkan nama kota.
     *
     * @param string $city
     * @param string $units (opsional: 'metric', 'imperial', 'standard')
     * @return array|null
     */
    public function getCurrentWeather(string $city, string $units = 'metric'): ?array
    {
        try {
            // Lakukan permintaan HTTP GET ke API OpenWeatherMap
            $response = Http::get("{$this->baseUrl}/weather", [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => $units, // Misalnya 'metric' untuk Celsius
            ]);

            // Periksa apakah respons berhasil (status code 2xx)
            $response->throw(); // Melemparkan exception jika status kode adalah 4xx atau 5xx

            // Mengembalikan respons dalam bentuk array PHP
            return $response->json();

        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Tangani kesalahan permintaan HTTP (misalnya, kota tidak ditemukan, API Key salah)
            Log::error("OpenWeatherMap API Error for city '{$city}': " . $e->getMessage());
            return null; // Mengembalikan null jika terjadi kesalahan
        } catch (\Exception $e) {
            // Tangani kesalahan lainnya (misalnya, masalah koneksi)
            Log::error("General Error fetching weather data for '{$city}': " . $e->getMessage());
            return null;
        }
    }

    /**
     * Mengambil data prakiraan cuaca 5 hari / 3 jam.
     *
     * @param string $city
     * @param string $units (opsional: 'metric', 'imperial', 'standard')
     * @return array|null
     */
    public function getForecast(string $city, string $units = 'metric'): ?array
    {
        try {
            $response = Http::get("{$this->baseUrl}/forecast", [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => $units,
                'cnt' => 8
            ]);

            $response->throw();

            return $response->json();

        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error("OpenWeatherMap Forecast API Error for city '{$city}': " . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error("General Error fetching forecast data for '{$city}': " . $e->getMessage());
            return null;
        }
    }
}