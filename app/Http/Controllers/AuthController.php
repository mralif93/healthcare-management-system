<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'staff_id' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if user is active
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'staff_id' => 'Your account is inactive. Please contact the administrator.',
                ]);
            }

            $request->session()->regenerate();

            // Redirect based on role using named routes
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isDoctor()) {
                return redirect()->route('doctor.dashboard');
            } elseif ($user->isStaff()) {
                return redirect()->route('staff.dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'staff_id' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)]);
    }
}