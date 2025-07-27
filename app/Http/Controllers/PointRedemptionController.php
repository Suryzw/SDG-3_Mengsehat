<?php

namespace App\Http\Controllers;

use App\Models\PointRedemption;
use Illuminate\Http\Request;

class PointRedemptionController extends Controller
{
    public function index()
    {
        $redemptions = PointRedemption::with('user')->latest()->get();
        return view('admin.redemptions', compact('redemptions'));
    }

    public function approve($id)
    {
        $redemption = PointRedemption::findOrFail($id);
        $redemption->status = 'approved';
        $redemption->save();

        return redirect()->back()->with('success', 'Penukaran berhasil disetujui!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'item_name' => 'required',
            'points_spent' => 'required|integer',
        ]);

        PointRedemption::create([
            'user_id' => $request->user_id,
            'item_name' => $request->item_name,
            'points_spent' => $request->points_spent,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Penukaran poin berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $redemption = PointRedemption::findOrFail($id);
        $redemption->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status penukaran diperbarui.');
    }
}

