<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteSubmission;
use Illuminate\Http\Request;

class WasteSubmissionController extends Controller
{
    public function index()
    {
        $submissions = WasteSubmission::all();
        $users = User::where('role', 'user')->get();
        $categories = WasteCategory::all();

        return view('admin.waste-submission', compact( 'users','submissions', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'waste_category_id' => 'required|exists:waste_categories,id',
            'weight' => 'required|numeric',
        ]);

        $category = WasteCategory::find($request->waste_category_id);
        $pointPerKg = $category->point_per_kg ?? 0;

        $totalPoints = $request->weight * $pointPerKg;

        // $user = User::findOrFail($request->user_id);
       
        // // Tambahkan total poin ke poin user yang sudah ada
        // $user->points += $totalPoints;
        // $user->save();
        
        WasteSubmission::create([
            'user_id' => $request->user_id,
            'waste_category_id' => $request->waste_category_id,
            'weight' => $request->weight,
            'status' => 'pending',
            'total_point' => $totalPoints
        ]);


        return redirect()->route('submission.form')->with('success', 'Setoran berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $submission = WasteSubmission::findOrFail($id);

        if ($request->action === 'approve') {
            $submission->status = 'accepted';
            $submission->save();

            $submission->user->increment('points', $submission->total_point);

            return redirect()->back()->with('success', 'Setoran berhasil diverifikasi!');
        } elseif ($request->action === 'reject') {
            $submission->status = 'rejected';
            $submission->save();

            return redirect()->back()->with('info', 'Setoran telah ditolak.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:pending,verified,rejected',
    //     ]);

    //     $submission = WasteSubmission::findOrFail($id);
    //     $submission->update(['status' => $request->status]);

    //     return redirect()->back()->with('success', 'Status setoran berhasil diperbarui!');
    // }

    public function destroy($id)
    {
        $submission = WasteSubmission::findOrFail($id);
        $submission->delete();

        return redirect()->back()->with('success', 'Setoran berhasil dihapus!');
    }

    public function submission()
    {
        $user = auth()->user();
        $categories = WasteCategory::all();
        $submissions = WasteSubmission::where('user_id', $user->id)->get(); // Semua kategori tersedia

        // Jika ingin cari kategori berdasarkan ID (opsional)
        

        return view('users.submission', compact('user', 'categories','submissions'));
    }
}
