<?php

namespace App\Http\Controllers;

use App\Models\WeatherRecommendation;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index()
    {
        $recommendations = WeatherRecommendation::all();
        return view('admin.weather-recommendation', compact('recommendations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'weather_name' => 'required|string',
            'recommendation' => 'required|string',
        ]);

        WeatherRecommendation::create([
            'weather_name' => $request->weather_name,
            'recommendation' => $request->recommendation,
        ]);

        return redirect()->back()->with('success', 'Rekomendasi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'weather_name' => 'required',
            'recommendation' => 'required',
        ]);

        $category = WeatherRecommendation::findOrFail($id);
        $category->update($request->only(['weather_name', 'recommendation']));
        return redirect()->back()->with('success', 'Recommendation has been updated!');
    }

    public function destroy($id)
    {
        WeatherRecommendation::destroy($id);
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
