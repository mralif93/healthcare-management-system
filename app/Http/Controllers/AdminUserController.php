<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Handle role filtering if coming from specific routes
        if ($request->routeIs('admin.staff.*')) {
            $query->where('role', 'staff');
        } elseif ($request->routeIs('admin.doctors.*')) {
            $query->where('role', 'doctor');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('staff_id', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:8|confirmed',
            'role'           => ['required', Rule::in(['admin', 'doctor', 'staff'])],
            'staff_id'       => 'nullable|string|unique:users',
            'specialization' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'status'         => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $validated['password']            = Hash::make($validated['password']);
        $validated['must_change_password'] = true;

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'           => ['required', Rule::in(['admin', 'doctor', 'staff'])],
            'staff_id'       => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'specialization' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'status'         => ['required', Rule::in(['active', 'inactive'])],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Reset the user's password to the default and force them to change it on next login.
     */
    public function resetPassword(User $user)
    {
        $defaultPassword = config('auth.default_password', 'Password@123');

        $user->update([
            'password'             => Hash::make($defaultPassword),
            'must_change_password' => true,
            'password_changed_at'  => null,
        ]);

        AuditLogger::log(
            AuditLog::ACTION_SECURITY,
            "Admin reset password to default for user '{$user->name}' (Staff ID: {$user->staff_id}). User will be prompted to change password on next login.",
            $user,
            null,
            ['must_change_password' => true, 'password_changed_at' => null]
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Password reset to default. User will be prompted to change it on next login.');
    }

    /**
     * Toggle the must_change_password flag for a user (admin override).
     */
    public function togglePasswordChange(User $user)
    {
        $oldFlag = $user->must_change_password;
        $user->update(['must_change_password' => ! $oldFlag]);
        $status = $user->must_change_password ? 'enabled' : 'disabled';

        AuditLogger::log(
            AuditLog::ACTION_SECURITY,
            "Admin {$status} force-password-change requirement for user '{$user->name}' (Staff ID: {$user->staff_id}).",
            $user,
            ['must_change_password' => $oldFlag],
            ['must_change_password' => $user->must_change_password]
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Force password change has been {$status} for this user.");
    }

    /**
     * Toggle the password_expiry_exempt flag — admin override to exclude a
     * user from the automatic 6-month periodic expiry check.
     */
    public function toggleExpiryExempt(User $user)
    {
        $oldFlag = $user->password_expiry_exempt;
        $user->update(['password_expiry_exempt' => ! $oldFlag]);
        $status = $user->password_expiry_exempt ? 'exempted from' : 'subject to';

        AuditLogger::log(
            AuditLog::ACTION_SECURITY,
            "Admin set user '{$user->name}' (Staff ID: {$user->staff_id}) as {$status} the 6-month periodic password expiry policy.",
            $user,
            ['password_expiry_exempt' => $oldFlag],
            ['password_expiry_exempt' => $user->password_expiry_exempt]
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', "User is now {$status} the 6-month periodic password expiry.");
    }

    /**
     * Unlock a user account that was locked due to too many failed login attempts.
     */
    public function unlockAccount(User $user)
    {
        $lockedUntil = $user->locked_until;
        $user->update(['login_attempts' => 0, 'locked_until' => null]);

        AuditLogger::log(
            AuditLog::ACTION_SECURITY,
            "Admin manually unlocked account for user '{$user->name}' (Staff ID: {$user->staff_id}). Lock was set until " . ($lockedUntil ? $lockedUntil->format('g:i A, d M Y') : 'N/A') . '.',
            $user,
            ['locked_until' => $lockedUntil?->toDateTimeString(), 'login_attempts' => 0],
            ['locked_until' => null, 'login_attempts' => 0]
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Account has been unlocked. The user can now log in again.');
    }
}
