<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditLogger;
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

        // Look up the user first so we can track and enforce lockout per-account.
        $user = User::where('staff_id', $credentials['staff_id'])->first();

        // ── Lockout check ──────────────────────────────────────────────────────
        if ($user && $user->isLockedOut()) {
            $seconds = (int)now()->diffInSeconds($user->locked_until, false);
            $minutes = (int)ceil($seconds / 60);
            $timeLabel = $minutes > 1 ? "{$minutes} minutes" : "1 minute";

            return back()->withErrors([
                'staff_id' => "Account locked due to too many failed attempts. Please try again in {$timeLabel}.",
            ])->with('lockout', true);
        }

        // ── Attempt authentication ─────────────────────────────────────────────
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Reset lockout counters on successful login
            $user->update(['login_attempts' => 0, 'locked_until' => null]);

            // Check if user is active
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'staff_id' => 'Your account is inactive. Please contact the administrator.',
                ]);
            }

            $request->session()->regenerate();

            AuditLogger::login($user);

            // Redirect based on role using named routes
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            elseif ($user->isDoctor()) {
                return redirect()->route('doctor.dashboard');
            }
            elseif ($user->isStaff()) {
                return redirect()->route('staff.dashboard');
            }

            return redirect()->intended('/');
        }

        // ── Failed attempt ─────────────────────────────────────────────────────
        if ($user) {
            $attempts = $user->login_attempts + 1;

            if ($attempts >= 3) {
                // Lock the account for 10 minutes and reset the counter
                $user->update([
                    'login_attempts' => 0,
                    'locked_until' => now()->addMinutes(10),
                ]);

                AuditLogger::log(
                    \App\Models\AuditLog::ACTION_SECURITY,
                    "Account locked for user '{$user->name}' (Staff ID: {$user->staff_id}) after 3 consecutive failed login attempts. Locked until " . now()->addMinutes(10)->format('g:i A, d M Y') . '.',
                    $user,
                    null,
                ['locked_until' => now()->addMinutes(10)->toDateTimeString(), 'login_attempts' => 0],
                    $user->id
                );

                return back()->withErrors([
                    'staff_id' => 'Account locked due to too many failed attempts. Please try again in 10 minutes.',
                ])->with('lockout', true);
            }

            $remaining = 3 - $attempts;
            $user->update(['login_attempts' => $attempts]);

            AuditLogger::log(
                \App\Models\AuditLog::ACTION_SECURITY,
                "Failed login attempt #{$attempts} for user '{$user->name}' (Staff ID: {$user->staff_id}). {$remaining} attempt(s) remaining before lockout.",
                $user,
                null,
            ['login_attempts' => $attempts],
                $user->id
            );

            return back()->withErrors([
                'staff_id' => "Invalid credentials. {$remaining} attempt(s) remaining before account lockout.",
            ]);
        }

        // Unknown staff_id — log without a user reference
        AuditLogger::log(
            \App\Models\AuditLog::ACTION_SECURITY,
            "Failed login attempt for unknown Staff ID '{$credentials['staff_id']}'."
        );

        return back()->withErrors([
            'staff_id' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            AuditLogger::logout($user);
        }
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