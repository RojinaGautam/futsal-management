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

    public function show($id)
    {
        $academyMember = Academy::findOrFail($id);

        // Decode the payment history JSON to an array
        $paymentHistory = json_decode($academyMember->payment_history, true);

        return response()->json([
            'id' => $academyMember->id,
            'student_name' => $academyMember->student_name,
            'monthly_price' => $academyMember->monthly_price,
            'age' => $academyMember->age,
            'phone_no' => $academyMember->phone_no,
            'email' => $academyMember->email,
            'total_due_left' => $academyMember->total_due_left,
            'joined_date' => $academyMember->joined_date,
            'payment_history' => $paymentHistory, // Include payment history
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        // dd($request);
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'monthly_price' => 'required|numeric',
            'age' => 'required|integer',
            'phone_no' => 'required|string|max:15',
            'email' => 'required|email',
            'total_due_left' => 'required|numeric',
            'joined_date' => 'required|date',
        ]);

        // Find the academy member by ID
        $academyMember = Academy::findOrFail($id);

        // Update the member with validated data
        $academyMember->update($validatedData);

        return response()->json(['success' => 'Academy member updated successfully.']);
    }

    public function destroy($id)
    {
        $academyMember = Academy::findOrFail($id);
        $academyMember->delete();

        return response()->json(['success' => 'Academy member deleted successfully.']);
    }

    public function updatePayment(Request $request, $id)
    {
        $academy = Academy::findOrFail($id);

        // Validate the request
        $request->validate([
            'payment_amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        // Calculate the new total due left
        $newTotalDueLeft = $academy->total_due_left - $request->payment_amount;

        // Ensure the new total due left is not negative
        if ($newTotalDueLeft < 0) {
            return response()->json(['error' => 'Payment amount exceeds total due left.'], 400);
        }

        // Update the total due left
        $academy->total_due_left = $newTotalDueLeft;

        // Add payment history
        $paymentHistory = $academy->payment_history ? json_decode($academy->payment_history, true) : [];
        $paymentHistory[] = [
            'amount' => $request->payment_amount,
            'date' => $request->payment_date,
        ];
        $academy->payment_history = json_encode($paymentHistory);

        // Save the changes
        $academy->save();

        return response()->json(['success' => 'Payment updated successfully!']);
    }
}
