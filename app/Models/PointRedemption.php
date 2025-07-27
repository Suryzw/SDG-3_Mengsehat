<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PointRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'item_name', 'points_spent', 'status',
    ];

    // Relasi: Penukaran milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
