<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\BankAccount;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function incomeExpense(Request $request)
    {
        $query         = Bill::where('status', 'paid');
        $expensesQuery = Expense::with('bankAccount', 'expensesCategory');

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $startDate = Carbon::parse($dates[0])->startOfDay();
                $endDate   = Carbon::parse($dates[1])->endOfDay();

                $query->whereBetween('created_at', [$startDate, $endDate]);
                $expensesQuery->whereBetween('date', [$startDate, $endDate]);
            }
        }

        if ($request->filled('type')) {
            if ($request->type === 'credit') {
                $expensesQuery = null;
            } else if ($request->type === 'debit') {
                $query = null;
            }
        }

        // Add category filter for expenses (only when type is debit or not specified)
        if ($request->filled('category_id') && ($request->type === 'debit' || !$request->filled('type'))) {
            $expensesQuery->where('category_id', $request->category_id);
        }

        $income   = $query ? $query->get() : collect();
        $expenses = $expensesQuery ? $expensesQuery->get() : collect();

        // Combine and sort all transactions by date
        $transactions = collect();

        // Add income transactions
        foreach ($income as $bill) {
            $transactions->push([
                'date'         => Carbon::parse($bill->created_at),
                'description'  => 'Bill Payment - ' . $bill->invoice_number,
                'credit'       => $bill->amount,
                'debit'        => 0,
                'total_amount' => $bill->amount,
            ]);
        }

        // Add expense transactions
        foreach ($expenses as $expense) {
            $transactions->push([
                'date'         => Carbon::parse($expense->date),
                'description'  => $expense->description,
                'credit'       => 0,
                'debit'        => $expense->amount,
                'total_amount' => $expense->amount,
            ]);
        }

        // Sort by date
        $transactions = $transactions->sortBy('date');

        // Get expense categories for the filter dropdown
        $expenseCategories = ExpenseCategory::where('status', 'active')->get();


        // $account = BankAccount::where('user_id', auth.user_id )->first();
        // $account = BankAccount::where('user_id', auth()->user_id)->first();

        $account = BankAccount::where('user_id', auth()->user()->id)->first();

        // dd($account);

        if ($request->has('export') && $request->export === 'csv') {
            return $this->exportIncomeExpenseToCsv($transactions);
        }

        return view('admin.reports.income-expense', compact('transactions', 'expenseCategories', 'account'));
    }

    private function exportIncomeExpenseToCsv($transactions)
    {
        $fileName = 'income-expense-report-' . date('Y-m-d') . '.csv';
        $headers  = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = [
            'Date',
            'Description',
            'Credit',
            'Debit',
            'Total Amount',
        ];

        $callback = function () use ($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $transaction) {
                $row = [
                    $transaction['date']->format('d M Y'),
                    $transaction['description'],
                    $transaction['credit'],
                    $transaction['debit'],
                    $transaction['total_amount'],
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        log_activity('Report', 'export', "Income Expense report exported to CSV");

        return response()->stream($callback, 200, $headers);
    }

    public function lead(Request $request)
    {
        $query = Lead::excludeLeadClients()->with(['states', 'cities', 'countries', 'districts', 'user', 'lineages', 'talukas', 'villages']);

        if ($request->filled('agent_name')) {
            $query->where('added_by', $request->agent_name);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('taluka')) {
            $query->where('taluka', $request->taluka);
        }

        if ($request->filled('village')) {
            $query->where('village', $request->village);
        }

        // Apply date range filter
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::parse($dates[0])->startOfDay();
                $endDate   = \Carbon\Carbon::parse($dates[1])->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $countries = Country::all();
        // $agents    = User::role('agent')->get();
        $agents    = User::all();

        if ($request->has('export') && $request->export === 'csv') {
            $lead = $query->get();
            return $this->exportLeadsToCsv($lead);
        }

        return view('admin.reports.total-lead', compact('countries', 'agents'));
    }

    public function getLeadReportData(Request $request)
    {
        $query = Lead::excludeLeadClients()
            ->with(['user', 'states', 'cities', 'countries', 'districts', 'lineages', 'talukas', 'villages'])
            ->leftJoin('talukas', 'leads.taluka', '=', 'talukas.id')
            ->leftJoin('villages', 'leads.village', '=', 'villages.id')
            ->select('leads.*');

        if ($request->filled('agent_name')) {
            $query->where('leads.added_by', $request->agent_name);
        }

        if ($request->filled('country')) {
            $query->where('leads.country', $request->country);
        }

        if ($request->filled('state')) {
            $query->where('leads.state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('leads.district', $request->district);
        }

        if ($request->filled('city')) {
            $query->where('leads.city', $request->city);
        }

        if ($request->filled('taluka')) {
            $query->where('leads.taluka', $request->taluka);
        }

        if ($request->filled('village')) {
            $query->where('leads.village', $request->village);
        }

        // Apply date range filter
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::parse($dates[0])->startOfDay();
                $endDate   = \Carbon\Carbon::parse($dates[1])->endOfDay();
                $query->whereBetween('leads.created_at', [$startDate, $endDate]);
            }
        }

        return DataTables::of($query)
            ->addColumn('ref_id', fn($item) => 'REF00' . $item->id)
            ->filterColumn('ref_id', function($query, $keyword) {
                // Remove 'REF00' prefix if present for searching
                $searchId = str_replace(['REF00', 'ref00', 'REF', 'ref'], '', $keyword);
                if (is_numeric($searchId)) {
                    $query->where('leads.id', $searchId);
                } else {
                    // Also allow searching with full ref_id format
                    $query->whereRaw("CONCAT('REF00', leads.id) LIKE ?", ["%{$keyword}%"]);
                }
            })
            ->orderColumn('ref_id', function($query, $order) {
                $query->orderBy('leads.id', $order);
            })
            ->addColumn('client_name', function($item) {
                return trim($item->first_name . ' ' . $item->middle_name . ' ' . $item->last_name);
            })
            ->filterColumn('client_name', function($query, $keyword) {
                $query->whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$keyword}%"]);
            })
            ->orderColumn('client_name', function($query, $order) {
                $query->orderByRaw("CONCAT_WS(' ', first_name, middle_name, last_name) {$order}");
            })
            ->addColumn('caste', function($item) {
                return $item->lineages ? $item->lineages->caste : '';
            })
            ->filterColumn('caste', function($query, $keyword) {
                $query->whereHas('lineages', function($q) use ($keyword) {
                    $q->where('caste', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('caste', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT lineages.caste FROM lineages WHERE lineages.lead_id = leads.id LIMIT 1)"),
                    $order
                );
            })
            ->addColumn('created_date', fn($item) => $item->created_at->format('d M Y'))
            ->orderColumn('created_date', function($query, $order) {
                            $query->orderBy('leads.created_at', $order);})
                            
            ->addColumn('phone', function($item) {
                return $item->phone ?? '';
            })
            ->filterColumn('phone', function($query, $keyword) {
                $query->where('leads.phone', 'like', "%{$keyword}%");
            })
            ->orderColumn('phone', function($query, $order) {
                $query->orderBy('leads.phone', $order);
            })
            ->addColumn('email', function($item) {
                return $item->email ?? '';
            })
            ->filterColumn('email', function($query, $keyword) {
                $query->where('leads.email', 'like', "%{$keyword}%");
            })
            ->orderColumn('email', function($query, $order) {
                $query->orderBy('leads.email', $order);
            })
            ->addColumn('country_name', function($item) {
                return $item->countries ? $item->countries->name : '';
            })
            ->filterColumn('country_name', function($query, $keyword) {
                $query->whereHas('countries', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('country_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT countries.name FROM countries WHERE countries.id = leads.country)"),
                    $order
                );
            })
            ->addColumn('state_name', function($item) {
                return $item->states ? $item->states->name : '';
            })
            ->filterColumn('state_name', function($query, $keyword) {
                $query->whereHas('states', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('state_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT states.name FROM states WHERE states.id = leads.state)"),
                    $order
                );
            })
            ->addColumn('district_name', function($item) {
                return $item->districts ? $item->districts->name : '';
            })
            ->filterColumn('district_name', function($query, $keyword) {
                $query->whereHas('districts', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('district_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT districts.name FROM districts WHERE districts.id = leads.district)"),
                    $order
                );
            })
            ->addColumn('city_name', function($item) {
                return $item->cities ? $item->cities->name : '';
            })
            ->filterColumn('city_name', function($query, $keyword) {
                $query->whereHas('cities', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('city_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT cities.name FROM cities WHERE cities.id = leads.city)"),
                    $order
                );
            })
            ->addColumn('taluka', function($item) {
                return $item->talukas ? $item->talukas->name : '';
            })
            ->filterColumn('taluka', function($query, $keyword) {
                $query->whereHas('talukas', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('taluka', function($query, $order) {
                $query->orderBy('talukas.name', $order);
            })
            ->addColumn('village', function($item) {
                return $item->villages ? $item->villages->name : '';
            })
            ->filterColumn('village', function($query, $keyword) {
                $query->whereHas('villages', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('village', function($query, $order) {
                $query->orderBy('villages.name', $order);
            })
            ->addColumn('status', function ($item) {
                $status = strtolower($item->status);
                $bgClass = match ($status) {
                    'high' => 'high-lead',
                    'low' => 'low-lead',
                    'done' => 'done-lead',
                    'close' => 'close-lead',
                    default => 'default-lead',
                };
            
                return '<button class="btn btn-sm ' . $bgClass . ' status-btn status-lead-btn" data-value="' . $item->id . '">
                            ' . ucfirst($item->status) . '
                        </button>';
            })
            ->rawColumns(['status'])
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('leads.status', $order);
            })
            ->make(true);
    }

    private function exportLeadsToCsv($leads)
    {
        $fileName = 'leads-report-' . date('Y-m-d') . '.csv';
        $headers  = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = [
            'Ref. Id',
            'Agent Name',
            'Client Name',
            'Date',
            'Phone No.',
            'Email Id',
            'Country',
            'State',
            'District',
            'City',
            'Taluka',
            'Village',
            'Status',
        ];

        $callback = function () use ($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leads as $lead) {
                $row = [
                    'REF00' . $lead->id,
                    $lead->user->name ?? '',
                    $lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name,
                    $lead->created_at->format('d M Y'),
                    $lead->phone,
                    $lead->email,
                    $lead->countries->name ?? '',
                    $lead->states->name ?? '',
                    $lead->districts->name ?? '',
                    $lead->cities->name ?? '',
                    $lead->taluka,
                    $lead->village,
                    $lead->status,
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        log_activity('Report', 'export', "Leads report exported to CSV");

        return response()->stream($callback, 200, $headers);
    }

    public function client(Request $request)
    {
        $query = Client::with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts', 'lead.lineages']);
        // For server-side datatable, we don't need to get all clients here
        // The filtering will be handled in the datatable method
        $countries = Country::all();
        $agents    = User::all();
        $role = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();

        $researchers = collect();

        if ($role) {
            $researchers = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }

        if ($request->has('export') && $request->export === 'csv') {
            $clients = $query->get();
            return $this->exportClientsToCsv($clients);
        }

        return view('admin.reports.total-client', compact('researchers', 'countries', 'agents'));
    }

    public function getClientReportData(Request $request)
    {
        $query = Client::with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts', 'lead.lineages', 'user']);

        $query->whereHas('lead', function ($q) use ($request) {
            if ($request->filled('country')) {
                $q->where('country', $request->country);
            }

            if ($request->filled('agent_name')) {
                $q->where('added_by', $request->agent_name);
            }

            if ($request->filled('state')) {
                $q->where('state', $request->state);
            }

            if ($request->filled('district')) {
                $q->where('district', $request->district);
            }

            if ($request->filled('city')) {
                $q->where('city', $request->city);
            }

            if ($request->filled('taluka')) {
                $q->where('taluka', 'like', '%' . $request->taluka . '%');
            }

            if ($request->filled('village')) {
                $q->where('village', 'like', '%' . $request->village . '%');
            }

            // Apply date range filter
            if ($request->filled('date_range')) {
                $dates = explode(' to ', $request->date_range);
                if (count($dates) === 2) {
                    $startDate = \Carbon\Carbon::parse($dates[0])->startOfDay();
                    $endDate   = \Carbon\Carbon::parse($dates[1])->endOfDay();
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
        });

        return DataTables::of($query)
            ->addColumn('ref_id', function ($client) {
                return 'REF00' . $client->id;
            })
            ->filterColumn('ref_id', function($query, $keyword) {
                // Remove 'REF00' prefix if present for searching
                $searchId = str_replace(['REF00', 'ref00', 'REF', 'ref'], '', $keyword);
                if (is_numeric($searchId)) {
                    $query->where('clients.id', $searchId);
                } else {
                    // Also allow searching with full ref_id format
                    $query->whereRaw("CONCAT('REF00', clients.id) LIKE ?", ["%{$keyword}%"]);
                }
            })
             ->orderColumn('ref_id', function($query, $order) {
                $query->orderBy('clients.id', $order);
            })
            
            ->addColumn('kulvrisk_id', function ($client) {
                return $client->kulvrisk_id;
            })
             ->orderColumn('kulvrisk_id', function($query, $order) {
                $query->orderBy('clients.kulvrisk_id', $order);
            })
            // ->addColumn('client_name', function ($client) {
            //     return ($client->lead->first_name ?? '') . ' ' . ($client->lead->middle_name ?? '') . ' ' . ($client->lead->last_name ?? '');
            // })
            ->addColumn('client_name', function($client) {
                return trim($client->lead->first_name . ' ' . $client->lead->middle_name . ' ' . $client->lead->last_name);
            })
            ->filterColumn('client_name', function($query, $keyword) {
                $query->whereHas('lead', function($q) use ($keyword) {
                    $q->whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$keyword}%"]);
                });
            })
           ->orderColumn('client_name', function($query, $order) {
                // Check if join already exists to avoid duplicate join
                $joins = $query->getQuery()->joins;
                if (is_null($joins) || !collect($joins)->pluck('table')->contains('leads')) {
                    $query->leftJoin('leads', 'clients.lead_id', '=', 'leads.id');
                }
                $query->orderByRaw("CONCAT_WS(' ', leads.first_name, leads.middle_name, leads.last_name) {$order}");
            })
            
            // ->addColumn('caste', function ($client) {
            //     return $client->lead->lineages->caste ?? '';
            // })
            ->addColumn('caste', function($client) {
                return $client->lead->lineages ? $client->lead->lineages->caste : '';
            })
            ->filterColumn('caste', function($query, $keyword) {
                $query->whereHas('lead.lineages', function($q) use ($keyword) {
                    $q->where('caste', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('caste', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT lineages.caste FROM lineages WHERE lineages.lead_id = clients.lead_id LIMIT 1)"),
                    $order
                );
            })
            
            ->addColumn('researcher_name', function ($client) {
                $assign_researchers = getResearchersWithNames(json_decode($client->researcher_ids ?? '[]', true))['researchers'];
                $html = '<div class="avatar-group avatar-list-stack">';
                foreach ($assign_researchers as $researcher) {
                    $html .= '<div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="' . $researcher->name . '">';
                    $html .= get_initials($researcher->name);
                    $html .= '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->filterColumn('researcher_name', function($query, $keyword) {
                $researcherIds = \App\Models\User::where('name', 'like', "%{$keyword}%")->pluck('id')->map(function($id) {
                    return (string) $id;
                })->toArray();
                
                if (!empty($researcherIds)) {
                    foreach ($researcherIds as $researcherId) {
                        $query->orWhereRaw('JSON_CONTAINS(clients.researcher_ids, ?)', [json_encode($researcherId)]);
                    }
                }
            })
            ->orderColumn('researcher_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT users.name FROM users WHERE clients.researcher_ids LIKE CONCAT('%\"', users.id, '\"%') LIMIT 1)"),
                    $order
                );
            })
            
            ->addColumn('user.name', function ($client) {
                return $client->user->name ?? '';
            })
            ->filterColumn('user.name', function($query, $keyword) {
                $query->whereHas('user', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('user.name', function($query, $order) {
                $query->leftJoin('users as agent_users', 'clients.agent_id', '=', 'agent_users.id')
                      ->orderBy('agent_users.name', $order);
            })
            
            ->addColumn('project_name', function ($client) {
                $projectData = getProjectsWithNames('parent', json_decode($client->project_ids ?? '[]', true));
                return $projectData['names'] ?? '';
            })
            ->filterColumn('project_name', function($query, $keyword) {
                $projectIds = \App\Models\Project::where('name', 'like', "%{$keyword}%")->pluck('id')->map(function($id) {
                    return (string) $id;
                })->toArray();
                
                if (!empty($projectIds)) {
                    foreach ($projectIds as $projectId) {
                        $query->orWhereRaw('JSON_CONTAINS(clients.project_ids, ?)', [json_encode($projectId)]);
                    }
                }
            })
            ->orderColumn('project_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT projects.name FROM projects WHERE clients.project_ids LIKE CONCAT('%\"', projects.id, '\"%') LIMIT 1)"),
                    $order
                );
            })
            ->addColumn('date', function ($client) {
                return $client->created_at->format('d M Y');
            })
            ->orderColumn('date', function($query, $order) {
                 $query->orderBy('clients.created_at', $order);})

            
            ->addColumn('email', function ($client) {
                return $client->lead->email ?? '';
            })
            ->filterColumn('email', function($query, $keyword) {
                $query->whereHas('lead', function($q) use ($keyword) {
                    $q->where('email', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('email', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT leads.email FROM leads WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            ->addColumn('country', function ($client) {
                return $client->lead->countries->name ?? '';
            })
            ->filterColumn('country', function($query, $keyword) {
                $query->whereHas('lead.countries', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('country', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT countries.name FROM countries INNER JOIN leads ON leads.country = countries.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            ->addColumn('state', function ($client) {
                return $client->lead->states->name ?? '';
            })
            ->filterColumn('state', function($query, $keyword) {
                $query->whereHas('lead.states', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('state', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT states.name FROM states INNER JOIN leads ON leads.state = states.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            ->addColumn('district', function ($client) {
                return $client->lead->districts->name ?? '';
            })
            ->filterColumn('district', function($query, $keyword) {
                $query->whereHas('lead.districts', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('district', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT districts.name FROM districts INNER JOIN leads ON leads.district = districts.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            ->addColumn('city', function ($client) {
                return $client->lead->cities->name ?? '';
            })
            ->filterColumn('city', function($query, $keyword) {
                $query->whereHas('lead.cities', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('city', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT cities.name FROM cities INNER JOIN leads ON leads.city = cities.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            ->addColumn('taluka', function ($client) {
                return $client->lead->talukas ? $client->lead->talukas->name : '';
            })
            ->filterColumn('taluka', function($query, $keyword) {
                $query->whereHas('lead.talukas', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('taluka', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT talukas.name FROM talukas INNER JOIN leads ON leads.taluka = talukas.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            ->addColumn('village', function ($client) {
                return $client->lead->villages ? $client->lead->villages->name : '';
            })
            ->filterColumn('village', function($query, $keyword) {
                $query->whereHas('lead.villages', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('village', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT villages.name FROM villages INNER JOIN leads ON leads.village = villages.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            ->rawColumns(['researcher_name'])
            ->make(true);
    }

    private function exportClientsToCsv($clients)
    {
        $fileName = 'clients-report-' . date('Y-m-d') . '.csv';
        $headers  = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = [
            'Ref. Id',
            'Kulvriksh Id',
            'Client Name',
            'Researcher Name',
            'Agent Name',
            'Project Name',
            'Date',
            'Email Id',
            'Country',
            'State',
            'District',
            'City',
            'Taluka',
            'Village',
        ];

        $callback = function () use ($clients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($clients as $client) {
                $assign_researchers = getResearchersWithNames(json_decode($client->researcher_ids ?? '[]', true))['researchers'];
                $projectData        = getProjectsWithNames('parent', json_decode($client->project_ids ?? '[]', true));

                $researcherNames = collect($assign_researchers)->pluck('name')->implode(', ');

                $row = [
                    'REF00' . $client->id,
                    $client->kulvrisk_id,
                    $client->lead->first_name . ' ' . $client->lead->middle_name . ' ' . $client->lead->last_name,
                    $researcherNames,
                    $client->user->name ?? '',
                    $projectData['names'],
                    $client->created_at->format('d M Y'),
                    $client->lead->email ?? '',
                    $client->lead->countries->name ?? '',
                    $client->lead->states->name ?? '',
                    $client->lead->districts->name ?? '',
                    $client->lead->cities->name ?? '',
                    $client->lead->taluka ?? '',
                    $client->lead->village ?? '',
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        log_activity('Report', 'export', "Clients report exported to CSV");

        return response()->stream($callback, 200, $headers);
    }

    public function researcher(Request $request)
    {
        $query = Client::whereNotNull('researcher_ids')
            ->with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts'])
            ->where('is_researchar_report', false);

        // Apply client filter
        if ($request->filled('client_id')) {
            $query->where('id', $request->client_id);
        }

        // Apply researcher filter
        if ($request->filled('researcher_id')) {
            $query->whereRaw("JSON_CONTAINS(researcher_ids, ?)", [json_encode($request->researcher_id)]);
        }

        // Apply date range filter
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::parse($dates[0])->startOfDay();
                $endDate   = \Carbon\Carbon::parse($dates[1])->endOfDay();
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '>=', $startDate)
                            ->where('end_date', '<=', $endDate);
                    });
                });
            }
        }

        $researchers = $query->get();

        $role = Role::whereRaw('LOWER(name) = ?', ['researcher'])->first();

        $researchersName = collect();

        if ($role) {
            $researchersName = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }

        if ($request->has('export') && $request->export === 'csv') {
            return $this->exportResearchersToCsv($researchers);
        }

        return view('admin.reports.total-researcher', compact('researchers', 'researchersName'));
    }

    private function exportResearchersToCsv($researchers)
    {
        $fileName = 'researchers-report-' . date('Y-m-d') . '.csv';
        $headers  = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = [
            'Kulvriksh Id',
            'Client Name',
            'Researcher Name',
            'Project Name',
            'Start Date',
            'End Date',
            'Overdue (Days)',
        ];

        $callback = function () use ($researchers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($researchers as $researcher) {
                $assign_researchers = getResearchersWithNames(json_decode($researcher->researcher_ids ?? '[]', true))['researchers'];
                $projectData        = getProjectsWithNames('parent', json_decode($researcher->project_ids ?? '[]', true));

                $researcherNames = collect($assign_researchers)->pluck('name')->implode(', ');

                // Calculate overdue days
                $overdueDays = '';
                if ($researcher->end_date) {
                    $endDate = \Carbon\Carbon::parse($researcher->end_date);
                    $today   = \Carbon\Carbon::now();

                    if ($endDate->isPast()) {
                        $overdueDays = abs((int) $today->diffInDays($endDate));
                    } else {
                        $overdueDays = 0;
                    }
                }

                $row = [
                    $researcher->kulvrisk_id,
                    $researcher->lead->first_name . ' ' . $researcher->lead->middle_name . ' ' . $researcher->lead->last_name,
                    $researcherNames,
                    $projectData['names'],
                    $researcher->start_date ?? '',
                    $researcher->end_date ?? '',
                    $overdueDays !== '' ? $overdueDays . ' days' : '',
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        log_activity('Report', 'export', "Researchers report exported to CSV");

        return response()->stream($callback, 200, $headers);
    }
}