<?php
namespace App\Exports;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLogsExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        $query = ActivityLog::with('user')->latest();

        // If not super admin, only fetch own logs
        if (Auth::user()->role !== 'super-admin') {
            $query->where('user_id', Auth::id());
        }

        return $query->get()->map(function ($log) {
            return [
                'Date & Time' => $log->created_at->format('d-m-Y h:i A'),
                'User'        => $log->user->name ?? 'Unknown',
                'Role'        => $log->role ?? '-',
                'Module'      => $log->module ?? '-',
                'Action'      => ucfirst($log->action ?? '-'),
                'Description' => $log->description ?? '-',
            ];
        });
    }
    public function headings(): array
    {
        return ['Date & Time', 'User', 'Role', 'Module', 'Action', 'Description'];
    }

}
