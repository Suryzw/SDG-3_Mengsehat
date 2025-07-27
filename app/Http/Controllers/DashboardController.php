<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PointRedemption;
use App\Models\User;
use App\Models\WasteSubmission;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::where('role', 'user')->count();
        $submissionCount = WasteSubmission::count();
        $redemptionCount = PointRedemption::count();
        $totalPoints = WasteSubmission::sum('total_point');

        return view('admin.dashboard', compact(
            'userCount', 'submissionCount', 'redemptionCount', 'totalPoints'
        ));
    }
}
