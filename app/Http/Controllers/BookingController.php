<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        return view('backend.bookings.index');
    }

    public function getData(Request $request)
    {
        $query = Booking::query();
        
        if ($request->has('filter_date')) {
            $query->whereDate('booking_date', $request->filter_date);
        }
        
        $query->where('del_flg', false);
        
        $bookings = $query->get();
        
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'total_amount_paid' => 'required|numeric|min:0'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
    
        // Check for existing booking with the same date and time
        $existingBooking = Booking::where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->where('del_flg', false)
            ->first();
    
        if ($existingBooking) {
            return response()->json(['message' => 'This time slot is already booked for the selected date.'], 422);
        }
    
        $booking = Booking::create($request->all());
    
        return response()->json([
            'success' => 'Booking created successfully!',
            'booking' => $booking
        ]);
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'total_amount_paid' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return response()->json([
            'success' => 'Booking updated successfully!',
            'booking' => $booking
        ]);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['del_flg' => true]);

        return response()->json([
            'success' => 'Booking deleted successfully!'
        ]);
    }

    public function updatePayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_amount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $booking = Booking::findOrFail($id);
        $booking->total_amount_paid += $request->payment_amount;
        $booking->save();

        return response()->json([
            'success' => 'Payment updated successfully!',
            'new_total_amount_paid' => $booking->total_amount_paid
        ]);
    }

}