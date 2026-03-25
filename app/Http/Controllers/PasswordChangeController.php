<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    /**
     * Handle the forced first-time password change.
     */
    public function update(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            return back()->withErrors($validator);
        }

        $user = $request->user();

        $user->update([
            'password'             => Hash::make($request->password),
            'must_change_password' => false,
            'password_changed_at'  => now(),
        ]);

        AuditLogger::log(
            AuditLog::ACTION_SECURITY,
            "User '{$user->name}' (Staff ID: {$user->staff_id}) successfully changed their password via the forced-change prompt. 6-month expiry timer restarted.",
            $user,
            null,
            ['must_change_password' => false, 'password_changed_at' => now()->toDateTimeString()]
        );

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('password_changed', true);
    }
}
