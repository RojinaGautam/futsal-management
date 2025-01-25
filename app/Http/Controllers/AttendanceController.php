<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Academy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index()
    {
        // Fetch all academy members
        $academyMembers = Academy::all();
        
        // Get today's date
        $today = Carbon::now()->format('Y-m-d');
        
        return view('backend.attendance.index', [
            'academyMembers' => $academyMembers,
            'today' => $today
        ]);
    }

    public function fetchAttendance(Request $request)
    {
        $date = $request->input('date');
        
        // Fetch attendance for the given date along with academy member data
        $attendance = Attendance::where('attendance_date', $date)
                                ->with('academyMember') // Assuming 'academyMember' is the relationship name
                                ->orderBy('academy_member_id')
                                ->get();
    
                                // dd($attendance);
        // If attendance is empty, return all academy members with their IDs and names
        if ($attendance->isEmpty()) {
            $academyMembers = Academy::orderBy('id')->get(); // Order academy members by their ID
            $attendanceData = $academyMembers->map(function($academyMember) {
                return [
                    'academy_member_id' => $academyMember->id,
                    'status' => 0, // Default to absent if no attendance data
                    'student_name' => $academyMember->student_name
                ];
            });
        } else {
            // If attendance exists, format the attendance data
            $attendanceData = $attendance->map(function($item) {
                return [
                    'academy_member_id' => $item->academy_member_id,
                    'status' => $item->status,
                    'student_name' => $item->academyMember->student_name
                ];
            });
        }
    
        return response()->json([
            'attendance' => $attendanceData
        ]);
    }
    
    

    public function submitAttendance(Request $request)
    {
        $date = $request->input('date');
        $presentIds = $request->input('present_ids', []);

        try {
            DB::beginTransaction();

            // Remove existing attendance for this date
            Attendance::where('attendance_date', $date)->delete();

            // Create new attendance records
            foreach ($presentIds as $memberId) {
                Attendance::create([
                    'academy_member_id' => $memberId,
                    'attendance_date' => $date,
                    'status' => 1 // Present
                ]);
            }

            // Get all member IDs
            $allMemberIds = Academy::pluck('id');

            // Create absent records for members not in present list
            $absentIds = array_diff($allMemberIds->toArray(), $presentIds);
            foreach ($absentIds as $memberId) {
                Attendance::create([
                    'academy_member_id' => $memberId,
                    'attendance_date' => $date,
                    'status' => 0 // Absent
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Attendance submitted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error submitting attendance: ' . $e->getMessage()
            ], 500);
        }
    }
}