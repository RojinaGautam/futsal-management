<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function index()
    {
        return view('backend.academy.index');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Store the image in 'storage/app/public/images/academy/'
            $image->storeAs('images/academy', $imageName, 'public');
            
            // Save the file path (accessible via /storage/images/academy/)
            $data['image'] = 'images/academy/' . $imageName;

        }
        
        Academy::create($data);
        
        return response()->json(['success' => 'Academy member added successfully.']);
        
    }

    // Add this to your controller that handles the academy.data route
    public function getAcademyData(Request $request)
    {
        $query = Academy::query();

        // Apply name filter if provided
        if ($request->has('nameFilter') && !empty($request->nameFilter)) {
            $query->where('student_name', 'LIKE', '%' . $request->nameFilter . '%');
        }

        // Apply due amount filter if provided
        if ($request->has('dueFilter') && !empty($request->dueFilter)) {
            switch ($request->dueFilter) {
                case '0':
                    $query->where('total_due_left', 0);
                    break;
                case '1-1000':
                    $query->whereBetween('total_due_left', [1, 1000]);
                    break;
                case '1001-5000':
                    $query->whereBetween('total_due_left', [1001, 5000]);
                    break;
                case '5001+':
                    $query->where('total_due_left', '>', 5000);
                    break;
            }
        }

        // Apply date filters if provided
        if ($request->has('startDate') && !empty($request->startDate)) {
            $query->whereDate('joined_date', '>=', $request->startDate);
        }

        if ($request->has('endDate') && !empty($request->endDate)) {
            $query->whereDate('joined_date', '<=', $request->endDate);
        }

        // Get the filtered results
        $academyMembers = $query->get();

        // Process the data as needed
        foreach ($academyMembers as $member) {
            // Format image URL if needed
            if ($member->image) {
                $member->image = asset('storage/' . $member->image);
            }
            
            // Add any other data processing needed
        }

        return response()->json($academyMembers);
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
            'payment_history' => $paymentHistory,
            'image' => $academyMember->image
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'monthly_price' => 'required|numeric',
            'age' => 'required|integer',
            'phone_no' => 'required|string|max:15',
            'email' => 'required|email',
            'total_due_left' => 'required|numeric',
            'joined_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $academyMember = Academy::findOrFail($id);
        
        $data = [
            'student_name' => $request->student_name,
            'monthly_price' => $request->monthly_price,
            'age' => $request->age,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'total_due_left' => $request->total_due_left,
            'joined_date' => $request->joined_date,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($academyMember->image && file_exists(public_path($academyMember->image))) {
                unlink(public_path($academyMember->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/academy'), $imageName);
            $data['image'] = 'images/academy/' . $imageName;
        }

        $academyMember->update($data);

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
