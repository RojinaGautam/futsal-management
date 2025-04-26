<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $attendanceData = StaffAttendance::with('user')->get(); // Eager load the user relationship

        return view('backend.index', compact('attendanceData'));
    }
}
