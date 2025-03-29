<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * The dashboard redirect path after login.
     */
    protected const DASHBOARD_PATH = '/admin';

    /**
     * Show the login form or redirect if the user is already authenticated.
     */
    public function showLoginForm(Request $request)
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // If the user is authenticated, redirect to the dashboard
            return redirect()->intended(self::DASHBOARD_PATH);
        }

        // Show the login form if no valid token is found
        return view('backend.login');
    }

    /**
     * Handle the login request.
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user is locked
        if ($user && $user->failed_attempts >= 5) {
            return redirect()->back()->withErrors(['error' => 'User is locked due to too many failed attempts.']);
        }

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Reset failed attempts
            if ($user) {
                $user->failed_attempts = 0;
                $user->save();
            }

            // Redirect to the admin page
            return redirect()->intended(self::DASHBOARD_PATH);
        } else {
            // Increment failed attempts
            if ($user) {
                $user->failed_attempts++;
                $user->save();
            }
            return redirect()->back()->withErrors(['error' => 'Invalid email or password.']);
        }
    }

    /**
     * Log the user out.
     */
    public function logout()
    {

        Auth::logout(); 

        return redirect('/login')->with('status', 'You have been logged out successfully.');
    }
}