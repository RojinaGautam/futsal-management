<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $roles = Role::all(); 
        return view('backend.users.index', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone_number' => 'nullable|string|max:15',
            'role' => 'required|string|exists:roles,name', // Validate that the role exists
            'monthly_salary' => 'nullable|numeric|min:0', // Validate monthly salary
            'payment_date' => 'nullable|date', // Validate payment date
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
        ]);

        // Assign the selected role to the user
        $user->assignRole($request->role);

        // If the user is staff, create a salary record
        if ($request->role === 'staff' && $request->filled('monthly_salary') && $request->filled('payment_date')) {
            $user->salaries()->create([
                'monthly_salary' => $request->monthly_salary,
                'amount' => 0, // Set amount to 0 by default
                'payment_date' => $request->payment_date,
            ]);
        }

        return response()->json(['message' => 'User created successfully!']);
    }

    /**
     * Fetch user data for DataTables.
     */
    public function getUsers()
    {
        $users = User::where('id', '!=', Auth::id())
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin'); 
            })
            ->with(['roles', 'salaries']) // Eager load roles and salaries
            ->get()
            ->map(function ($user) {
                $user->amount = $user->latestSalaryAmount(); // Add amount to user object
                return $user;
            });

        return response()->json($users);
    }

    /**
     * Show a specific user.
     */
    public function show($id)
    {
        $user = User::with(['roles', 'salaries'])->findOrFail($id); // Eager load roles and salaries
        return response()->json($user);
    }

    /**
     * Update a specific user.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
            'phone_number' => 'nullable|string|max:15',
            'role' => 'required|string|exists:roles,name',
            'password' => 'nullable|string|min:6', 
            'monthly_salary' => 'nullable|numeric|min:0', // Validate monthly salary
            'payment_date' => 'nullable|date', // Validate payment date
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Update the user's role
        $user->syncRoles($request->role); // Sync the role

        // Update salary if the user is staff
        if ($request->role === 'staff') {
            $salary = $user->salaries()->first(); // Get the first salary record

            if ($salary) {
                // Update existing salary record
                $salary->monthly_salary = $request->monthly_salary;
                $salary->payment_date = $request->payment_date;
                $salary->save();
            } else {
                // Create a new salary record if none exists
                $user->salaries()->create([
                    'monthly_salary' => $request->monthly_salary,
                    'amount' => 0, // Set amount to 0 by default
                    'payment_date' => $request->payment_date,
                ]);
            }
        }

        return response()->json(['message' => 'User updated successfully!']);
    }

    /**
     * Remove a specific user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'User deleted successfully.']);
    }

    // Method to unlock the user
    public function unlock(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->id);
        $user->failed_attempts = 0; // Reset failed attempts
        $user->save();

        return response()->json(['message' => 'User unlocked successfully!']);
    }
}
