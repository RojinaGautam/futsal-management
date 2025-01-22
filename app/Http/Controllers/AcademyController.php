<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function index()
    {
        return view('backend.academy.index'); // Adjust the path as necessary
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'monthly_price' => 'required|numeric',
            'age' => 'required|integer',
            'phone_no' => 'required|string|max:15',
            'email' => 'required|email|unique:academy',
            'total_due_left' => 'required|numeric',
            'joined_date' => 'required|date',
        ]);

        Academy::create($request->all());

        return response()->json(['success' => 'Academy member added successfully.']);
    }

    public function getAcademyData()
    {
        return Academy::all(); // You can customize this to return paginated data or specific fields
    }
}
