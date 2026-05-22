<?php
namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BankAccount;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];
        $bankingAlert = BankAccount::where('user_id', $user->id)->count() == 0;

        // Check if user has SMTP configured
        $smtpAlert = ! $user->hasSmtpConfigured();

        // Common date filter for all dashboards
        $dateFilter = null;
        if (request()->filled('date_range')) {
            $dates = explode(' to ', request()->date_range);
            if (count($dates) === 2) {
                $dateFilter = [
                    'start' => Carbon::parse($dates[0])->startOfDay(),
                    'end'   => Carbon::parse($dates[1])->endOfDay(),
                ];
            }
        }

        if (roleType() == 'agent') {
            // Fetch leads assigned to this agent
            $query = Lead::excludeLeadClients()
                ->with('user')
                ->where('added_by', $user->id); // Filter by login agent ID

            // Apply date filter if exists
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }

            $leads = $query->take(10)->get();

            // Summary stats for this agent only
            // $totalLead        = Lead::excludeLeadClients()->where('added_by', $user->id)->count();
            // $totalConvertLead = Lead::isClient()->where('added_by', $user->id)->count();
            // $totalLowLead     = Lead::excludeLeadClients()->where('added_by', $user->id)->where('status', 'low')->count();
            // $totalHighLead    = Lead::excludeLeadClients()->where('added_by', $user->id)->where('status', 'high')->count();
            // $totalDoneLead    = Lead::excludeLeadClients()->where('added_by', $user->id)->where('status', 'done')->count();

            // Summary stats for this agent with date filter
            $totalLeadQuery             = Lead::excludeLeadClients();
            $totalConvertLeadQuery      = Client::query();
            $totalLowLeadQuery          = Lead::excludeLeadClients()->where('status', 'low');
            $totalHighLeadQuery         = Lead::excludeLeadClients()->where('status', 'high');
            $totalDoneLeadQuery         = Lead::excludeLeadClients()->where('status', 'done');
            $totalJointConvertLeadQuery = Client::whereNotNull('lead_id')
                ->whereHas('lead', function ($q) {
                    $q->whereColumn('added_by', '!=', 'clients.converted_agent_id');
                });

            // Apply date filter to all summary queries
            if ($dateFilter) {
                $totalLeadQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                $totalConvertLeadQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                $totalLowLeadQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                $totalHighLeadQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                $totalDoneLeadQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                $totalJointConvertLeadQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }

            $totalLead             = $totalLeadQuery->where('added_by', $user->id)->count();
            $totalConvertLead      = $totalConvertLeadQuery->whereHas('lead', function ($q) use ($user) {
                $q->where('added_by', $user->id);
            })->count();
            $totalLowLead          = $totalLowLeadQuery->where('added_by', $user->id)->count();
            $totalHighLead         = $totalHighLeadQuery->where('added_by', $user->id)->count();
            $totalDoneLead         = $totalDoneLeadQuery->where('added_by', $user->id)->count();
            $totalJointConvertLead = $totalJointConvertLeadQuery->count();

            return view('admin.dashboard-agent', compact(
                'leads',
                'totalLead',
                'totalConvertLead',
                'totalLowLead',
                'totalHighLead',
                'totalDoneLead',
                'totalJointConvertLead',
                'smtpAlert',
                'bankingAlert'
            ));
        } elseif (roleType() == 'researcher') {
            // Fetch research data for this researcher
            $researcherId = $user->id;

            $query = Client::whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])
                ->whereRaw('JSON_CONTAINS(researcher_ids, ?)', [json_encode((string) $researcherId)])
                ->with(['lead']);

            // Apply date filter if exists
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }

            $clients = $query->get();

            // Summary stats with date filter
            $totalResearchQuery = Client::whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])
                ->whereRaw('JSON_CONTAINS(researcher_ids, ?)', [json_encode((string) $researcherId)]);
            $runningResearchQuery = Client::whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])
                ->whereRaw('JSON_CONTAINS(researcher_ids, ?)', [json_encode((string) $researcherId)])
                ->where('research_status', 'running');
            $completeResearchQuery = Client::whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])
                ->whereRaw('JSON_CONTAINS(researcher_ids, ?)', [json_encode((string) $researcherId)])
                ->where('research_status', 'completed');

            // Apply date filter to all summary queries
            if ($dateFilter) {
                $totalResearchQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                $runningResearchQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                $completeResearchQuery->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }

            $totalResearch    = $totalResearchQuery->count();
            $runningResearch  = $runningResearchQuery->count();
            $completeResearch = $completeResearchQuery->count();

            // new add
            $jointResearch = Client::whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])
                ->whereRaw('JSON_CONTAINS(researcher_ids, ?)', [json_encode((string) $researcherId)])
                ->whereRaw('JSON_LENGTH(researcher_ids) > 1')
                ->count();

            return view('admin.dashboard-researcher', compact(
                'clients',
                'totalResearch',
                'runningResearch',
                'completeResearch',
                'jointResearch',
                'smtpAlert',
                'bankingAlert'
            ));
        } elseif (Auth::user()->is_admin == 1) {
            $query = User::where('is_admin', false);
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }
            $data['agent'] = $query->count();

            $query = Lead::excludeLeadClients();
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }
            $data['lead'] = $query->count();

            $query = Lead::where('is_lead_to_client', true);
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }
            $data['leadClient'] = $query->count();

            $query = Client::whereHas('lead', function ($q) {
                $q->whereNotNull('lead_id');
            });
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }
            $data['client'] = $query->count();

            $query = Client::whereNotNull('researcher_ids')
                ->where('researcher_ids', '!=', '[]')
                ->with('lead')
                ->latest()
                ->take(10);
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }
            $data['latestResearchers'] = $query->get();

            $query = Expense::query();
            if ($dateFilter) {
                $startDate = $dateFilter['start'];
                $endDate   = $dateFilter['end'];
            } else {
                $startDate = Carbon::now()->startOfMonth()->startOfDay(); // 1st of current month 00:00:00
                $endDate   = Carbon::now()->endOfMonth()->endOfDay();     // Last day of current month 23:59:59
            }
            $query->whereBetween('date', [$startDate, $endDate]);
            $data['expense'] = $query->sum('amount');

            $query = Bill::whereHas('client', function ($q) {
                $q->whereNotNull('lead_id');
            });
            if ($dateFilter) {
                $startDate = $dateFilter['start'];
                $endDate   = $dateFilter['end'];
            } else {
                $startDate = Carbon::now()->startOfMonth()->startOfDay(); // 1st of current month 00:00:00
                $endDate   = Carbon::now()->endOfMonth()->endOfDay();     // Last day of current month 23:59:59
            }
            $query->whereBetween('created_at', [$startDate, $endDate]);
            // $data['income'] = $query->sum('amount');
            $data['income'] = $query->get()->sum(function ($item) {
                return $item->amount * 1.18;
            });

            $query = Bill::whereHas('client', function ($q) {
                $q->whereNotNull('lead_id');
            });
            if ($dateFilter) {
                $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }
            $unpaidQuery    = $query;
            $data['paid']   = $query->where('status', 'paid')->count();
            $data['unpaid'] = $unpaidQuery->where('status', 'unpaid')->count();

            // Get all bills for current year
            $year  = now()->year;
            $bills = Bill::whereHas('client', function ($q) {
                $q->whereNotNull('lead_id');
            })->whereYear('created_at', $year)
                ->where('status', 'paid')
                ->get();

            // Get all expenses for current year
            $expenses = Expense::whereYear('date', $year)->get();
            // Initialize arrays with 0 for 12 months
            $income  = array_fill(1, 12, 0);
            $expense = array_fill(1, 12, 0);
            // Calculate monthly income
            foreach ($bills as $bill) {
                $month = Carbon::parse($bill->created_at)->month;
                $income[$month] += $bill->amount;
            }
            // Calculate monthly expense
            foreach ($expenses as $exp) {
                $month = Carbon::parse($exp->date)->month;
                $expense[$month] += $exp->amount;
            }
            // Convert to zero-based index for JavaScript
            // $data['incomeData']  = array_values($income);
            $data['incomeData'] = array_map(function ($amount) {
                return $amount * 1.18;
            }, array_values($income));

            $data['expenseData'] = array_values($expense);

            $research_query = Client::whereHas('lead', function ($q) {
                $q->whereNotNull('lead_id');
            })->whereNotNull(['researcher_ids', 'agent_id', 'lead_id']);
            if ($dateFilter) {
                $research_query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
            }
            $running   = clone $research_query;
            $completed = clone $research_query;

            $data['running_status']   = $running->where('research_status', 'running')->count();
            $data['completed_status'] = $completed->where('research_status', 'completed')->count();

            return view('admin.dashboard', compact('data', 'smtpAlert', 'bankingAlert'));
        } else {

            return view('admin.guest-dashboard', compact('bankingAlert'));
        }
    }

}
