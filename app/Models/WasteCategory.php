<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WasteCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'point_per_kg',
    ];

    // Relasi: Kategori memiliki banyak setoran
    public function wasteSubmissions()
    {
        return $this->hasMany(WasteSubmission::class);
    }
}

