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

    public function getParkingData(Request $request)
    {
        $query = Parking::query();
    
        // Apply name filter if provided
        if ($request->has('nameFilter') && !empty($request->nameFilter)) {
            $query->where('name', 'LIKE', '%' . $request->nameFilter . '%');
        }
    
        // Apply address filter if provided
        if ($request->has('addressFilter') && !empty($request->addressFilter)) {
            $query->where('address', 'LIKE', '%' . $request->addressFilter . '%');
        }
    
        if ($request->dueFilter == '0') {
            $query->where('total_due', 0);
        }
        // Apply due amount filter if provided
        if ($request->has('dueFilter') && !empty($request->dueFilter)) {
            switch ($request->dueFilter) {
                case '0':
                    $query->where('total_due', 0);
                    break;
                case '1-1000':
                    $query->whereBetween('total_due', [1, 1000]);
                    break;
                case '1001-5000':
                    $query->whereBetween('total_due', [1001, 5000]);
                    break;
                case '5001+':
                    $query->where('total_due', '>', 5000);
                    break;
            }
        }
    
        // Apply price range filter if provided
        if ($request->has('priceFilter') && !empty($request->priceFilter)) {
            switch ($request->priceFilter) {
                case '0-500':
                    $query->whereBetween('monthly_price', [0, 500]);
                    break;
                case '501-1000':
                    $query->whereBetween('monthly_price', [501, 1000]);
                    break;
                case '1001+':
                    $query->where('monthly_price', '>', 1000);
                    break;
            }
        }
    
        // Apply date filters if needed (if you have any date fields like created_at)
        if ($request->has('startDate') && !empty($request->startDate)) {
            $query->whereDate('created_at', '>=', $request->startDate);
        }
    
        if ($request->has('endDate') && !empty($request->endDate)) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }
    
        // Get the filtered results
        $parkingEntries = $query->get();
        
        // Process any data if needed before returning
        
        return response()->json($parkingEntries);
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