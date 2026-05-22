<?php
namespace App\Http\Controllers;

use App\Exports\ActivityLogsExport;
use App\Models\ActivityLog;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->get();
        return view('admin.logs.index', compact('logs'));
    }

    public function export()
    {
        return Excel::download(new ActivityLogsExport, 'activity_logs_' . now()->format('Ymd_His') . '.xlsx');
    }

    // ✅ Clear Logs (Except Super Admin's)
    public function clear(Request $request)
    {
        if (auth()->user()?->hasRole('super-admin')) {
            ActivityLog::truncate();
        } 

        return redirect()->back()->with('success', 'Activity logs cleared successfully.');
    }

    public function destroy($id)
    {
        $log = ActivityLog::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Activity log deleted successfully.');
        
    }

    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json([
                'created_at' => $log->created_at->format('m-d-Y, h:i A'),
                'user' => $log->user,
                'description' => $log->description,
                'role' => $log->role,
                'ip_address' => $log->ip_address
            ]);
        }
        
        return view('admin.logs.view', compact('log'));
    }
}
