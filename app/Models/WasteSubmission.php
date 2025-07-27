<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WasteSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'waste_category_id', 'weight', 'status', 'total_point',
    ];

    // Relasi: Setoran milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Setoran milik satu kategori sampah
    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class);
    }
}
