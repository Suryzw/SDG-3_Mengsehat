<?php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeatherRecommendation;
use App\Services\OpenWeatherMapService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['user', 'admin'])->get();
        return view('admin.users', compact('users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|',
            'role' => 'required', // jika ada pilihan role
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id) // Abaikan email milik user yang sedang diupdate
        ],
            'role' => 'required',
            'points' => 'nullable|numeric'
        ]);

        $users = User::findOrFail($id);
        $users->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'points' => $request->points
        ]);
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }


    //Khusus User
    protected $weatherService;

    // Injeksi dependensi melalui konstruktor
    public function __construct(OpenWeatherMapService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function dashboard(Request $request)
    {
        // Tangani input kota dari user (POST/GET)
        if ($request->has('city')) {
            $city = $request->input('city');
            session(['user_city' => $city]); // simpan di session
        } else {
            $city = session('user_city','Jakarta'); // default jika tidak ada input
        }

        // Gunakan cache berdasarkan nama kota, expire 10 menit
        $weatherData = Cache::remember("weather_{$city}", now()->addMinutes(10), function () use ($city) {
            return $this->weatherService->getCurrentWeather($city);
        });

        $forecastData = Cache::remember("forecast_{$city}", now()->addMinutes(10), function () use ($city) {
            return $this->weatherService->getForecast($city);
        });

        $weatherName = $weatherData['weather'][0]['main']; // contoh: 'Rain', 'Clear', 'Clouds', dst

        // cari rekomendasi berdasarkan nama cuaca
        $recommendations = WeatherRecommendation::where('weather_name', $weatherName)->get();
        $today = Carbon::now()->format('Y-m-d');

        $todayForecast = collect($forecastData['list'])->filter(function ($item) use ($today) {
            return Carbon::parse($item['dt_txt'])->format('Y-m-d') === $today;
        })->values(); // ->values() reset index array

        $timestamp = $weatherData['dt'];
        $timezoneOffset = $weatherData['timezone']; // misal +25200 (GMT+7)

        // Waktu lokal (menyesuaikan offset timezone dari API)
        $weatherData['datetime'] = Carbon::createFromTimestamp($timestamp + $timezoneOffset)
            ->format('H:i');
        $weatherData['date'] = Carbon::createFromTimestamp($timestamp + $timezoneOffset)
            ->format('l, d M Y');

        $countryCode = $weatherData['sys']['country'] ?? ' ID';
        $countryName = Countries::getName($countryCode, 'en');

        // Variabel lain yang mungkin Anda miliki di dashboard Anda
        $user = auth()->user(); // Contoh: mendapatkan user yang sedang login
        // ... variabel-variabel lainnya

        return view('users.dashboard', compact(
            'user',
            'weatherData',
            'forecastData',
            'countryName', // Kirim juga data forecast jika digunakan
            'city',
            'todayForecast', 'recommendations'
        ));
    }

    
    // public function dashboard()
    // {
    //     $user = auth()->user();
    // //     $submissionCount = $user->wasteSubmissions()->count();
    // //     // Hari ini
    // //     $dailySubmission = $user->wasteSubmissions()
    // //         ->whereDate('created_at', Carbon::today())
    // //         ->count();

    // //     // Minggu ini
    // //     $weeklySubmission = $user->wasteSubmissions()
    // //         ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    // //         ->count();

    // //     // Bulan ini
    // //     $monthlySubmission = $user->wasteSubmissions()
    // //         ->whereMonth('created_at', Carbon::now()->month)
    // //         ->whereYear('created_at', Carbon::now()->year)
    // //         ->count();
        
    // //     $wastePerCategory = DB::table('waste_submissions')
    // //     ->join('waste_categories', 'waste_submissions.waste_category_id', '=', 'waste_categories.id')
    // //     ->select('waste_categories.name as category_name', DB::raw('count(*) as total'))
    // //     ->where('waste_submissions.user_id', $user->id)
    // //     ->groupBy('waste_categories.name')
    // //     ->get();

    // // // Untuk chart.js (array terpisah)
    // //     $categoryNames = $wastePerCategory->pluck('category_name');
    // //     $categoryCounts = $wastePerCategory->pluck('total');

    
    //     return view('users.dashboard', compact('user',
    //                                              'submissionCount',  
    //                                                         'dailySubmission',  
    //                                                         'weeklySubmission', 
    //                                                         'monthlySubmission',
    //                                                         'categoryNames', 
    //                                                         'categoryCounts'));
    // }
}


