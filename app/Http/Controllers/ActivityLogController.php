<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('logs.index', compact('logs'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('user');
        return view('logs.show', compact('log'));
    }

    public function filter(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);

        return view('logs.index', compact('logs'));
    }

    public function destroy(ActivityLog $log)
    {
        $log->delete();
        return redirect()->route('logs.index')->with('success', 'Log deleted successfully!');
    }

    public function clearOldLogs()
    {
        // Delete logs older than 90 days
        $deletedCount = ActivityLog::where('created_at', '<', now()->subDays(90))->delete();

        return redirect()->route('logs.index')->with('success', "{$deletedCount} old logs deleted successfully!");
    }
}
