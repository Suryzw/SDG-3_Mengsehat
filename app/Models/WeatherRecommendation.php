<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherRecommendation extends Model
{
    //
    protected $fillable = ['weather_name', 'recommendation'];
}
