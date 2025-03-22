<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        return view('backend.parking.index'); // Adjust the path as necessary
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'monthly_price' => 'required|numeric', // Validate monthly_price
            'total_due' => 'required|numeric', // Validate total_due
        ]);

        Parking::create($request->all());

        return response()->json(['success' => 'Parking record added successfully.']);
    }

    public function getParkingData()
    {
        return Parking::all(); // You can customize this to return paginated data or specific fields
    }

    public function show($id)
    {
        $parking = Parking::findOrFail($id);
        return response()->json($parking);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'monthly_price' => 'required|numeric', // Validate monthly_price
            'total_due' => 'required|numeric', // Validate total_due
        ]);

        $parking = Parking::findOrFail($id);
        $parking->update($request->all());

        return response()->json(['success' => 'Parking record updated successfully.']);
    }

    public function destroy($id)
    {
        $parking = Parking::findOrFail($id);
        $parking->delete();

        return response()->json(['success' => 'Parking record deleted successfully.']);
    }

    public function updatePayment(Request $request, $id)
    {
        $parking = Parking::findOrFail($id);

        // Validate the request
        $request->validate([
            'payment_amount' => 'required|numeric',
        ]);

        // Calculate the new total due
        $newTotalDue = $parking->total_due - $request->payment_amount;

        // Ensure the new total due is not negative
        if ($newTotalDue < 0) {
            return response()->json(['error' => 'Payment amount exceeds total due.'], 400);
        }

        // Update the total due
        $parking->total_due = $newTotalDue;

        // Save the changes
        $parking->save();

        return response()->json(['new_total_due' => $newTotalDue, 'success' => 'Payment processed successfully!']);
    }
}