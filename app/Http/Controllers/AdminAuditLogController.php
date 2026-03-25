<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search term
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('description', 'like', "%{$term}%")
                    ->orWhere('ip_address', 'like', "%{$term}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$term}%"));
            });
        }

        $logs = $query->paginate(25)->withQueryString();
        $users = User::orderBy('name')->get(['id', 'name', 'role']);

        $actions = [
            AuditLog::ACTION_LOGIN,
            AuditLog::ACTION_LOGOUT,
            AuditLog::ACTION_CREATE,
            AuditLog::ACTION_UPDATE,
            AuditLog::ACTION_DELETE,
            AuditLog::ACTION_VIEW,
            AuditLog::ACTION_SECURITY,
        ];

        // Summary stats
        $stats = [
            'total' => AuditLog::count(),
            'today' => AuditLog::whereDate('created_at', today())->count(),
            'logins' => AuditLog::where('action', 'login')->whereDate('created_at', today())->count(),
            'changes' => AuditLog::whereIn('action', ['create', 'update', 'delete'])->whereDate('created_at', today())->count(),
        ];

        return view('admin.audit-logs.index', compact('logs', 'users', 'actions', 'stats'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');
        return view('admin.audit-logs.show', compact('auditLog'));
    }
}