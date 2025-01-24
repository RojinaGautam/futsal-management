<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Academy;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $academyMembers = Academy::all();
        return view('backend.attendance.index', compact('academyMembers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'boolean',
        ]);

        foreach ($request->attendance as $memberId => $status) {
            Attendance::updateOrCreate(
                [
                    'academy_member_id' => $memberId,
                    'attendance_date' => $request->attendance_date,
                ],
                ['status' => $status]
            );
        }

        return response()->json(['success' => 'Attendance marked successfully.']);
    }
}