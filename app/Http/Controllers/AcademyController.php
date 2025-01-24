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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName; // Save the image name in the database
        }

        Academy::create($data);

        return response()->json(['success' => 'Academy member added successfully.']);
    }

    public function getAcademyData()
    {
        return Academy::all(); // You can customize this to return paginated data or specific fields
    }

    public function show($id)
    {
        $academyMember = Academy::findOrFail($id);
        return response()->json($academyMember);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_name' => 'string|max:255',
            'monthly_price' => 'numeric',
            'age' => 'integer',
            'phone_no' => 'string|max:15',
            'email' => 'email',
            'total_due_left' => 'numeric',
            'joined_date' => 'date',
        ]);

        $academyMember = Academy::findOrFail($id);
        $academyMember->update($request->all());

        return response()->json(['success' => 'Academy member updated successfully.']);
    }

    public function destroy($id)
    {
        $academyMember = Academy::findOrFail($id);
        $academyMember->delete();

        return response()->json(['success' => 'Academy member deleted successfully.']);
    }
}
