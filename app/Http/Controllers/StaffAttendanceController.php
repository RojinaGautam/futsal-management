<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    public function getAttendanceStatus($userId, $date)
    {
        $attendance = StaffAttendance::where('user_id', $userId)
            ->where('date', $date)
            ->first();

        return response()->json($attendance);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        $attendance = StaffAttendance::updateOrCreate(
            ['user_id' => $request->user_id, 'date' => $request->date],
            ['check_in' => now()]
        );

        return response()->json(['message' => 'Checked in successfully!']);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        $attendance = StaffAttendance::where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->first();

        if ($attendance) {
            $attendance->check_out = now();
            $attendance->save();
            return response()->json(['message' => 'Checked out successfully!']);
        }

        return response()->json(['message' => 'No check-in record found for today.'], 404);
    }
}
