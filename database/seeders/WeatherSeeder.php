<?php
namespace Database\Seeders;

use App\Models\WeatherRecommendation;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder{
     public function run()
    {
        $data = [
            // Thunderstorm
            ['weather_name' => 'Thunderstorm', 'recommendation' => 'Tetap di dalam rumah dan hindari penggunaan alat elektronik.'],
            ['weather_name' => 'Thunderstorm', 'recommendation' => 'Pastikan peralatan darurat seperti senter tersedia.'],

            // Drizzle
            ['weather_name' => 'Drizzle', 'recommendation' => 'Gunakan jaket tahan air saat keluar rumah.'],
            ['weather_name' => 'Drizzle', 'recommendation' => 'Bawa payung untuk berjaga-jaga.'],

            // Rain
            ['weather_name' => 'Rain', 'recommendation' => 'Gunakan jas hujan atau payung.'],
            ['weather_name' => 'Rain', 'recommendation' => 'Hindari berkendara terlalu cepat karena jalanan licin.'],
            ['weather_name' => 'Rain', 'recommendation' => 'Periksa kondisi saluran air rumah untuk menghindari banjir.'],

            // Snow
            ['weather_name' => 'Snow', 'recommendation' => 'Kenakan pakaian tebal dan hangat saat keluar.'],
            ['weather_name' => 'Snow', 'recommendation' => 'Hindari bepergian jika tidak darurat.'],

            // Atmosphere (kabut, debu, asap)
            ['weather_name' => 'Atmosphere', 'recommendation' => 'Gunakan masker saat berada di luar ruangan.'],
            ['weather_name' => 'Atmosphere', 'recommendation' => 'Kurangi aktivitas luar ruangan.'],

            // Clear
            ['weather_name' => 'Clear', 'recommendation' => 'Waktu yang baik untuk berolahraga di luar.'],
            ['weather_name' => 'Clear', 'recommendation' => 'Gunakan tabir surya jika berada di bawah matahari.'],
            ['weather_name' => 'Clear', 'recommendation' => 'Minum air putih yang cukup agar tidak dehidrasi.'],

            // Clouds
            ['weather_name' => 'Clouds', 'recommendation' => 'Siapkan payung jika sewaktu-waktu hujan turun.'],
            ['weather_name' => 'Clouds', 'recommendation' => 'Waktu yang tepat untuk berjalan santai tanpa panas matahari.'],
        ];

        foreach ($data as $row) {
            WeatherRecommendation::create($row);
        }
    }

}
