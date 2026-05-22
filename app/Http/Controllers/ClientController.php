<?php
namespace App\Http\Controllers;

use App\Helpers\LeadHelper;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\District;
use App\Models\Lead;
use App\Models\LeadAttachment;
use App\Models\LeadNote;
use App\Models\Project;
use App\Models\State;
use App\Models\Taluka;
use App\Models\Village;
use App\Models\User;
use App\Models\BillService;
use App\Models\ClientService;
use Auth;
use Illuminate\Http\Request;
use PDF;
use Spatie\Permission\Models\Role;
use App\Models\Bill;
use App\Models\ResearcherReport;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::all();
        $agents    = User::all();
        $clients   = Client::select('id', 'kulvrisk_id', 'researcher_ids')->get();

        $role = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();

        $researchers = collect();

        if ($role) {
            $researchers = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }
        return view('admin.clients.index', compact('researchers', 'countries', 'agents', 'clients'));
    }

    public function getClientsData(Request $request)
    {
        // ✅ Start with base query - NO JOINS
        $query = Client::query()
            ->select('clients.*')
            ->with(['lead.states', 'lead.cities', 'lead.countries', 'lead.districts', 'lead.talukas', 'lead.villages', 'lead.lineages', 'user']);
            
        // Apply researcher filter
        if (roleType() == 'researcher') {
            $query->whereRaw('JSON_CONTAINS(clients.researcher_ids, ?)', [json_encode((string) auth()->id())]);
        }
    
        // Apply filters using whereHas
        $query->whereHas('lead', function ($q) use ($request) {
            if ($request->filled('country')) {
                $q->where('country', $request->country);
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
                $q->where('taluka', $request->taluka);
            }
    
            if ($request->filled('village')) {
                $q->where('village', $request->village);
            }
        });
    
        if ($request->filled('agent_name')) {
            $query->where('added_by', $request->agent_name);
        }
        
        return DataTables::of($query)
            ->addColumn('ref_id', fn($client) => 'REF00' . $client->id)
            ->filterColumn('ref_id', function($query, $keyword) {
                $searchId = str_replace(['REF00', 'ref00', 'REF', 'ref'], '', $keyword);
                if (is_numeric($searchId)) {
                    $query->where('clients.id', $searchId);
                } else {
                    $query->whereRaw("CONCAT('REF00', clients.id) LIKE ?", ["%{$keyword}%"]);
                }
            })
            ->orderColumn('ref_id', function($query, $order) {
                $query->orderBy('clients.id', $order);
            })
            
            ->addColumn('client_name', function($client) {
                return trim($client->lead->first_name . ' ' . $client->lead->middle_name . ' ' . $client->lead->last_name);
            })
            ->filterColumn('client_name', function($query, $keyword) {
                $query->whereHas('lead', function($q) use ($keyword) {
                    $q->whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$keyword}%"]);
                });
            })
            ->orderColumn('client_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT CONCAT_WS(' ', leads.first_name, leads.middle_name, leads.last_name) FROM leads WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
    
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
            
            ->addColumn('researcher_name', function($client) {
                $assign_researchers = getResearchersWithNames(json_decode($client->researcher_ids ?? '[]', true))['researchers'];
                
                $html = '<div class="avatar-group avatar-list-stack">';
                foreach ($assign_researchers->take(3) as $researcher) {
                    $html .= '<div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="' . $researcher->name . '">';
                    $html .= get_initials($researcher->name);
                    $html .= '</div>';
                }
                
                if ($assign_researchers->count() > 3) {
                    $html .= '<div class="avatar avatar-xs rounded-circle d-inline-flex align-items-center justify-content-center more" style="width: 32px; height: 32px; font-size: 12px;">';
                    $html .= '+' . ($assign_researchers->count() - 3);
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
                    $query->where(function($q) use ($researcherIds) {
                        foreach ($researcherIds as $researcherId) {
                            $q->orWhereRaw('JSON_CONTAINS(clients.researcher_ids, ?)', [json_encode($researcherId)]);
                        }
                    });
                }
            })
            ->orderColumn('researcher_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT users.name FROM users WHERE clients.researcher_ids LIKE CONCAT('%\"', users.id, '\"%') LIMIT 1)"),
                    $order
                );
            })
            
            ->addColumn('project_name', function($client) {
                $projectData = getProjectsWithNames('parent', json_decode($client->project_ids ?? '[]', true));
                return $projectData['names'] ?? '';
            })
            ->filterColumn('project_name', function($query, $keyword) {
                $projectIds = \App\Models\Project::where('name', 'like', "%{$keyword}%")->pluck('id')->map(function($id) {
                    return (string) $id;
                })->toArray();
                
                if (!empty($projectIds)) {
                    $query->where(function($q) use ($projectIds) {
                        foreach ($projectIds as $projectId) {
                            $q->orWhereRaw('JSON_CONTAINS(clients.project_ids, ?)', [json_encode($projectId)]);
                        }
                    });
                }
            })
            ->orderColumn('project_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT projects.name FROM projects WHERE clients.project_ids LIKE CONCAT('%\"', projects.id, '\"%') LIMIT 1)"),
                    $order
                );
            })
            
            ->addColumn('date', fn($client) => $client->created_at->format('d M Y'))
            ->orderColumn('date', function($query, $order) {
                $query->orderBy('clients.created_at', $order);
            })
                            
            ->addColumn('email', function($client) {
                return $client->lead ? $client->lead->email : '';
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
            
            ->addColumn('phone', function($client) {
                return $client->lead ? $client->lead->phone : '';
            })
            ->filterColumn('phone', function($query, $keyword) {
                $query->whereHas('lead', function($q) use ($keyword) {
                    $q->where('phone', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('phone', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT leads.phone FROM leads WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            
            ->addColumn('country', function($client) {
                return $client->lead && $client->lead->countries ? $client->lead->countries->name : '';
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
            
            ->addColumn('state', function($client) {
                return $client->lead && $client->lead->states ? $client->lead->states->name : '';
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
            
            ->addColumn('district', function($client) {
                return $client->lead && $client->lead->districts ? $client->lead->districts->name : '';
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
            
            ->addColumn('city', function($client) {
                return $client->lead && $client->lead->cities ? $client->lead->cities->name : '';
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
            
            ->addColumn('taluka_name', function($item) {
                return $item->lead->talukas ? $item->lead->talukas->name : '';
            })
            ->filterColumn('taluka_name', function($query, $keyword) {
                $query->whereHas('lead.talukas', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('taluka_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT talukas.name FROM talukas INNER JOIN leads ON leads.taluka = talukas.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            
            ->addColumn('village_name', function($item) {
                return $item->lead->villages ? $item->lead->villages->name : '';
            })
            ->filterColumn('village_name', function($query, $keyword) {
                $query->whereHas('lead.villages', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->orderColumn('village_name', function($query, $order) {
                $query->orderBy(
                    \DB::raw("(SELECT villages.name FROM villages INNER JOIN leads ON leads.village = villages.id WHERE leads.id = clients.lead_id)"),
                    $order
                );
            })
            
            ->addColumn('action', function ($client) {
                $buttons = '';
                $buttons .= '<div class="d-flex gap-2">';
    
                if (auth()->user()->can('assign_researcher')) {
                    $buttons .= '<a href="' . url('admin/clients/assing-resarcher/') . '" class="convert-icon-btn btn-sm btn-action rounded-pill mr-1" data-bs-toggle="modal" data-bs-target="#standard-modal' . $client->id . '" title="assign-researcher"><i class="ri-user-add-line"></i></a>';
                }
    
                if (auth()->user()->can('view_client')) {
                    $buttons .= '<a href="' . url('admin/clients/view/' . $client->id) . '" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>';
                }
    
                if (auth()->user()->can('edit_client')) {
                    $buttons .= '<a href="' . url('admin/clients/edit/' . $client->id) . '" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a>';
                }
    
                if (auth()->user()->can('delete_client')) {
                    $buttons .= '<form action="' . url('admin/clients/delete/' . $client->id) . '" method="POST" id="deleteForm_' . $client->id . '" style="display:inline;">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="button" class="delete-icon-btn btn-sm btn-action mr-1" onclick="deleteAccount(this, ' . $client->id . ')"><i class="ri-delete-bin-6-line"></i></button>' .
                        '</form>';
                }
    
                $buttons .= '</div>';
    
                return $buttons;
            })
            ->rawColumns(['researcher_name', 'action'])
            ->make(true);
    }

    public function create()
    {
        $country     = Country::all();
        $projects    = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();
        $role        = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();

        $researchers = collect();

        if ($role) {
            $researchers = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }
        return view('admin.clients.add', compact('country', 'projects', 'subprojects', 'researchers'));
    }

    // public function store(Request $request)
    // {

    //     $validated = $request->validate([
    //         // Client
    //         'kulvrisk_id'    => 'required|max:10|unique:clients,kulvrisk_id',
    //         'payment_mode'   => 'required|string',
    //         'project'        => 'required|array',
    //         'sub_project'    => 'required|array',
    //         'start_date'     => 'nullable|date',
    //         'end_date'       => 'nullable|date|after_or_equal:start_date',
    //         'image'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
    //         'description'    => 'nullable|string',
    //         // lead
    //         'first_name'     => 'required|string|max:255',
    //         'middle_name'    => 'nullable|string|max:255',
    //         'last_name'      => 'required|string|max:255',
    //         'dob'            => 'nullable|date',
    //         'marriage_date'  => 'nullable|date',
    //         // 'phone'          => 'required|unique:leads,phone',
    //         // 'email'          => 'required|email:rfc,dns|unique:leads,email',
    //         'phone'               => 'required|unique:leads,phone,NULL,id,deleted_at,NULL',
    //         'email' => 'nullable|email:rfc,dns|unique:leads,email,NULL,id,deleted_at,NULL',
    //         'country'        => 'required',
    //         'state'          => 'required',
    //         'district'       => 'required',
    //         'city'           => 'nullable',
    //         'taluka'         => 'nullable|string|max:100',
    //         'village'        => 'nullable|string|max:100',
    //         'notes_address'  => 'nullable|string',
    //         'researcher_ids' => 'required|array|min:1',
    //     ]);

    //     // Ensure project and sub_project arrays match
    //     if (count($request->project) !== count($request->sub_project)) {
    //         return back()->withErrors(['sub_project' => 'Each project must have a sub-project']);
    //     }

    //     if ($request->hasFile('image_path')) {
    //         $image     = $request->file('image_path');
    //         $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('assets/admin/clients/images'), $imageName);
    //         $imagePath = 'assets/admin/clients/images/' . $imageName;
    //     }

    //     $lead = Lead::create([
    //         'added_by'            => auth()->id(),
    //         'first_name'          => $request->input('first_name'),
    //         'middle_name'         => $request->input('middle_name'),
    //         'last_name'           => $request->input('last_name'),
    //         'birth_date'          => $request->input('dob'),
    //         'marriage_date'       => $request->input('marriage_date'),
    //         'phonecode'           => $request->input('phonecode'),
    //         'phone'               => $request->input('phone'),
    //         'alternate_mobile_number' => $request->input('alternate_mobile_number'),
    //         'email'               => $request->input('email'),
    //         'country'             => $request->input('country'),
    //         'state'               => $request->input('state'),
    //         'district'            => $request->input('district'),
    //         'city'                => $request->input('city'),
    //         'taluka'              => $request->input('taluka'),
    //         'village'             => $request->input('village'),
    //         'notes'               => $request->input('notes_address'),
    //         'lead_ancestor_notes' => $request->input('lead_ancestor_notes'),
    //         'wife_ancestor_notes' => $request->input('wife_ancestor_notes'),
    //         "is_lead_to_client"   => true,
    //     ]);

    //     $client = Client::create([
    //         'kulvrisk_id'     => $request->kulvrisk_id,
    //         'lead_id'         => $lead->id,
    //         'researcher_ids'  => json_encode($request->researcher_ids),
    //         'agent_id'        => Auth::user()->id,
    //         'project_ids'     => json_encode($request->project),
    //         'sub_project_ids' => json_encode($request->sub_project),
    //         'payment_mode'    => $request->payment_mode,
    //         'start_date'      => $request->start_date,
    //         'end_date'        => $request->end_date,
    //         'image_path'      => $imagePath ?? '',
    //         'description'     => $request->description ?? '',
    //     ]);

    //     LeadHelper::saveFamilyMembers($lead->id, 'lead', $request->input('family', []), $request->ancestor_notes);
    //     LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggf', 'great-grandfather');
    //     LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggm', 'great-grandmother');

    //     LeadHelper::saveFamilyMembers($lead->id, 'wife', $request->input('wife_family', []), $request->ancestor_notes);
    //     LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggf', 'great-grandfather');
    //     LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggm', 'great-grandmother');

    //     LeadHelper::saveSiblings($lead->id, 'lead', $request, 'sibling');
    //     LeadHelper::saveSiblings($lead->id, 'wife', $request, 'wife_sibling');

    //     LeadHelper::saveLineages($lead->id, $request);
    //     LeadHelper::saveWifeDetails($lead->id, $request);
    //     LeadHelper::saveChildren($lead->id, $request);
    //     LeadHelper::saveLeadNotes($lead->id, $request);

    //     log_activity('Client', 'create', "New client created: {$lead->first_name} {$lead->last_name}");

    //     return redirect('admin/clients')->with('success', 'Client created successfully.');
    // }
    //mansi add new
      public function store(Request $request)
    {

        $validated = $request->validate([
            // Client
            'kulvrisk_id'    => 'required|max:10|unique:clients,kulvrisk_id',
            'payment_mode' => 'required|string|in:neft,dbf,cheque,upi,credit,debit,cash,razorpay,stripe,op,pp',
            'project'        => 'nullable|array',
            'sub_project'    => 'nullable|array',
            'service_name'          => 'nullable|array',
            'service_name.*'        => 'nullable|string|max:255',
            'service_description'   => 'nullable|array',
            'service_description.*' => 'nullable|string|max:500',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'image'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'description'    => 'nullable|string',
            // lead
            'first_name'     => 'required|string|max:255',
            'middle_name'    => 'nullable|string|max:255',
            'last_name'      => 'required|string|max:255',
            'dob'            => 'nullable|date',
            'marriage_date'  => 'nullable|date',
            // 'phone'          => 'required|unique:leads,phone',
            // 'email'          => 'required|email:rfc,dns|unique:leads,email',
            'phone'               => 'required|unique:leads,phone,NULL,id,deleted_at,NULL',
            'email' => 'nullable|email:rfc,dns|unique:leads,email,NULL,id,deleted_at,NULL',
            'country'        => 'required',
            'state'          => 'required',
            'district'       => 'required',
            'city'           => 'nullable',
            'taluka'         => 'nullable|string|max:100',
            'village'        => 'nullable|string|max:100',
            'notes_address'  => 'nullable|string',
            'researcher_ids' => 'required|array|min:1',
        ]);

        // Ensure project and sub_project arrays match
        // if (count($request->project) !== count($request->sub_project)) {
        //     return back()->withErrors(['sub_project' => 'Each project must have a sub-project']);
        // }

        if ($request->hasFile('image_path')) {
            $image     = $request->file('image_path');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admin/clients/images'), $imageName);
            $imagePath = 'assets/admin/clients/images/' . $imageName;
        }

        $lead = Lead::create([
            'added_by'            => auth()->id(),
            'first_name'          => $request->input('first_name'),
            'middle_name'         => $request->input('middle_name'),
            'last_name'           => $request->input('last_name'),
            'birth_date'          => $request->input('dob'),
            'marriage_date'       => $request->input('marriage_date'),
            'phonecode'           => $request->input('phonecode'),
            'phone'               => $request->input('phone'),
            'alternate_mobile_number' => $request->input('alternate_mobile_number'),
            'email'               => $request->input('email'),
            'country'             => $request->input('country'),
            'state'               => $request->input('state'),
            'district'            => $request->input('district'),
            'city'                => $request->input('city'),
            'taluka'              => $request->input('taluka'),
            'village'             => $request->input('village'),
            'notes'               => $request->input('notes_address'),
            'lead_ancestor_notes' => $request->input('lead_ancestor_notes'),
            'wife_ancestor_notes' => $request->input('wife_ancestor_notes'),
            "is_lead_to_client"   => true,
        ]);

        $client = Client::create([
            'kulvrisk_id'     => $request->kulvrisk_id,
            'lead_id'         => $lead->id,
            'researcher_ids'  => json_encode($request->researcher_ids),
            'agent_id'        => Auth::user()->id,
            'project_ids'     => json_encode($request->project),
            'sub_project_ids' => json_encode($request->sub_project),
            'payment_mode'    => $request->payment_mode,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'image_path'      => $imagePath ?? '',
            'description'     => $request->description ?? '',
        ]);
        $projectIds    = array_map(fn($v) => ($v === '' || $v === null) ? null : (int)$v, $request->project ?? []);
        $subProjectIds = array_map(fn($v) => ($v === '' || $v === null) ? null : (int)$v, $request->sub_project ?? []);
        $serviceNames  = $request->service_name ?? [];
        $serviceDescs  = $request->service_description ?? [];

        $maxBlocks = max(
            count($projectIds),
            count($subProjectIds),
            count($serviceNames),
            count($serviceDescs), 
            1
        );

        for ($i = 0; $i < $maxBlocks; $i++) {
            $projectId    = isset($projectIds[$i])    ? (int)$projectIds[$i]    : 0;
            $subProjectId = isset($subProjectIds[$i]) ? (int)$subProjectIds[$i] : 0;
            $hasProject   = $projectId > 0 && $subProjectId > 0;

            $serviceName = trim($serviceNames[$i] ?? '');
            $serviceDesc = trim($serviceDescs[$i] ?? '');
            $hasService  = $serviceName !== '' || $serviceDesc !== '';

            if ($hasProject) {
                ClientService::create([
                    'client_id'      => $client->id,
                    'block_index'    => $i,
                    'project_id'     => $projectId,
                    'sub_project_id' => $subProjectId,
                    'service_name'   => null,
                    'description'    => null,
                    'quantity'       => 1,
                    'amount'         => 0,
                    'type'           => 'project',
                ]);
            }

            if ($hasService) {
                ClientService::create([
                    'client_id'      => $client->id,
                    'block_index'    => $i,
                    'project_id'     => null,
                    'sub_project_id' => null,
                    'service_name'   => $serviceName !== '' ? $serviceName : null,
                    'description'    => $serviceDesc  !== '' ? $serviceDesc  : null,
                    'quantity'       => 1,
                    'amount'         => 0,
                    'type'           => 'service',
                ]);
            }
        }

        LeadHelper::saveFamilyMembers($lead->id, 'lead', $request->input('family', []), $request->ancestor_notes);
        LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggf', 'great-grandfather');
        LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggm', 'great-grandmother');

        LeadHelper::saveFamilyMembers($lead->id, 'wife', $request->input('wife_family', []), $request->ancestor_notes);
        LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggf', 'great-grandfather');
        LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggm', 'great-grandmother');

        LeadHelper::saveSiblings($lead->id, 'lead', $request, 'sibling');
        LeadHelper::saveSiblings($lead->id, 'wife', $request, 'wife_sibling');

        LeadHelper::saveLineages($lead->id, $request);
        LeadHelper::saveWifeDetails($lead->id, $request);
        LeadHelper::saveChildren($lead->id, $request);
        LeadHelper::saveLeadNotes($lead->id, $request);

        log_activity('Client', 'create', "New client created: {$lead->first_name} {$lead->last_name}");

        return redirect('admin/clients')->with('success', 'Client created successfully.');
    }

    public function show(Request $request, $id)
    {
        $projects    = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();
        $data        = Client::where('id', $id)->with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts'])->first();

        if ($request->has('preview') && $request->preview == 'true') {
            return view('admin.preview.client-preview', compact('data', 'projects', 'subprojects'));
        }
        // dd($data);
        return view('admin.clients.view', compact('data', 'projects', 'subprojects'));
    }

    // public function edit($id)
    // {

    //     $data    = Client::with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts', 'lead.talukas', 'lead.villages'])->where('id', $id)->first();
    //     $country = Country::all();
    //     $selectedWifeCountryId  = $data->lead->wifeDetail->country ?? null;
    //     $selectedCountryId  = $data->lead->country ?? null;
    //     $selectedStateId    = $data->lead->state ?? null;
    //     $selectedCityId    = $data->lead->city ?? null;   //add new for taluka
    //     $selectedTalukaId    = $data->lead->taluka ?? null;   //add new for village
    //     $selectedDistrictId = $data->lead->district ?? null;
    //     $selectedWifeStateId = $data->lead->wifeDetail->state ?? null;
    //     $selectedWifeCityId = $data->lead->wifeDetail->city ?? null;
    //     $selectedWifeTalukaId = $data->lead->wifeDetail->taluka ?? null;
        
    //     $country   = Country::all(); // fine (not too big)
    //     $states    = State::where('country_id', $selectedCountryId)->get();
    //     $wifeStates    = State::where('country_id', $selectedWifeCountryId)->get();
    //     $districts = District::where('state_id', $selectedStateId)->get();
    //     $cities    = City::where('state_id', $selectedStateId)->get();
    //     $talukas    = Taluka::where('city_id', $selectedCityId)->get(); //added new for tauka
    //     $villages    = Village::where('taluka_id', $selectedTalukaId)->get(); //added new for village
    //     $wifeCities    = City::where('state_id', $selectedWifeStateId)->get();
    //     $wifeDistricts = District::where('state_id', $selectedWifeStateId)->get();
    //     $wifeTalukas = Taluka::where('city_id', $selectedWifeCityId)->get();
    //     $wifeVillages = Village::where('taluka_id', $selectedWifeTalukaId)->get();


    //     $projects = Project::parent()->status('active')->get();
    //     $projectIds = json_decode($data->project_ids ?? '[]', true);
    //     $projectIds = is_array($projectIds) ? $projectIds : [];
    //     $subprojects = Project::subproject()
    //         ->whereIn('project_id', $projectIds)
    //         ->status('active')
    //         ->get();

    //     //$projects    = Project::parent()->status('active')->get();
    //     //$subprojects = Project::subproject()->whereIn('project_id', json_decode($data->project_ids, true))->status('active')->get();
    //     $role        = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();
    //     $researchers = collect();

    //     if ($role) {
    //         $researchers = User::whereHas('roles', function ($query) use ($role) {
    //             $query->where('role_type', $role->role_type);
    //         })->get();
    //     }
      
    //     return view('admin.clients.edit', compact('data', 'country', 'states', 'projects', 'cities', 'talukas', 'villages', 'districts', 'subprojects', 'researchers', 'wifeStates', 'wifeCities', 'wifeDistricts', 'wifeTalukas','wifeVillages'));


    // }
    //mansi add new 
    public function edit($id)
    {
        $data = Client::with([
            'lead', 'lead.states', 'lead.cities', 'lead.countries', 
            'lead.districts', 'lead.talukas', 'lead.villages'
        ])->where('id', $id)->first();

        $country = Country::all();
        $selectedWifeCountryId = $data->lead->wifeDetail->country ?? null;
        $selectedCountryId     = $data->lead->country ?? null;
        $selectedStateId       = $data->lead->state ?? null;
        $selectedCityId        = $data->lead->city ?? null;
        $selectedTalukaId      = $data->lead->taluka ?? null;
        $selectedDistrictId    = $data->lead->district ?? null;
        $selectedWifeStateId   = $data->lead->wifeDetail->state ?? null;
        $selectedWifeCityId    = $data->lead->wifeDetail->city ?? null;
        $selectedWifeTalukaId  = $data->lead->wifeDetail->taluka ?? null;

        $country       = Country::all();
        $states        = State::where('country_id', $selectedCountryId)->get();
        $wifeStates    = State::where('country_id', $selectedWifeCountryId)->get();
        $districts     = District::where('state_id', $selectedStateId)->get();
        $cities        = City::where('state_id', $selectedStateId)->get();
        $talukas       = Taluka::where('city_id', $selectedCityId)->get();
        $villages      = Village::where('taluka_id', $selectedTalukaId)->get();
        $wifeCities    = City::where('state_id', $selectedWifeStateId)->get();
        $wifeDistricts = District::where('state_id', $selectedWifeStateId)->get();
        $wifeTalukas   = Taluka::where('city_id', $selectedWifeCityId)->get();
        $wifeVillages  = Village::where('taluka_id', $selectedWifeTalukaId)->get();

        $projects    = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();

        $role        = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();
        $researchers = collect();

        if ($role) {
            $researchers = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }

        // ✅ ClientServices  projectPairs fetch
        $clientServices = $data->clientServices()->orderBy('block_index')->get();
        $projectPairs   = [];

        if ($clientServices->isNotEmpty()) {
            $grouped = $clientServices->groupBy('block_index');
            foreach ($grouped->sortKeys() as $blockIndex => $items) {
                $projectItem = $items->where('type', 'project')->first();
                $serviceItem = $items->where('type', 'service')->first();
                $projectPairs[] = [
                    'project_id'          => $projectItem?->project_id ?? null,
                    'sub_project_id'      => $projectItem?->sub_project_id ?? null,
                    'service_name'        => $serviceItem?->service_name ?? '',
                    'service_description' => $serviceItem?->description ?? '',
                ];
            }
        }

        if (empty($projectPairs)) {
            $projectPairs = [[
                'project_id'          => null,
                'sub_project_id'      => null,
                'service_name'        => '',
                'service_description' => '',
            ]];
        }

        return view('admin.clients.edit', compact(
            'data', 'country', 'states', 'projects', 'cities',
            'talukas', 'villages', 'districts', 'subprojects',
            'researchers', 'wifeStates', 'wifeCities', 'wifeDistricts',
            'wifeTalukas', 'wifeVillages',
            'projectPairs' 
        ));
    }

    // public function update(Request $request, $id)
    // {

    //     $client = Client::findOrFail($id);
    //     $lead   = Lead::findOrFail($client->lead_id);

    //     $request->validate([
    //         // Client

    //         'kulvrisk_id'    => 'required|max:10|unique:clients,kulvrisk_id,' . $id,
    //         'payment_mode'   => 'required|string',
    //         'project'        => 'required|array',
    //         'sub_project'    => 'required|array',
    //         'start_date'     => 'nullable|date',
    //         'end_date'       => 'nullable|date|after_or_equal:start_date',
    //         'image'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
    //         'description'    => 'nullable|string',
    //         // lead
    //         'first_name'     => 'required|string|max:255',
    //         'middle_name'    => 'nullable|string|max:255',
    //         'last_name'      => 'required|string|max:255',
    //         'dob'            => 'nullable|date',
    //         'marriage_date'  => 'nullable|date',
    //         // 'phone'          => 'required|unique:leads,phone,' . $lead->id,
    //         // 'email'          => 'required|email:rfc,dns|unique:leads,email,' . $lead->id,
    //          'phone' => 'required|unique:leads,phone,' . $lead->id . ',id,deleted_at,NULL',
    //         'email' => 'required|email:rfc,dns|unique:leads,email,' . $lead->id . ',id,deleted_at,NULL',
    //         'country'        => 'required',
    //         'state'          => 'required',
    //         'district'       => 'required',
    //         'city'           => 'nullable',
    //         'taluka'         => 'nullable|string|max:100',
    //         'village'        => 'nullable|string|max:100',
    //         'notes_address'  => 'nullable|string',
    //         'researcher_ids' => 'required',
    //     ]);

    //     // Ensure project and sub_project arrays match
    //     if (count($request->project) !== count($request->sub_project)) {
    //         return back()->withErrors(['sub_project' => 'Each project must have a sub-project']);
    //     }

    //     $validated = $request->only([
    //         'first_name', 'middle_name', 'last_name',
    //         'dob', 'marriage_date', 'phone', 'email',
    //         'country', 'state', 'district', 'city',
    //         'taluka', 'village', 'notes_address', 'lead_ancestor_notes', 'wife_ancestor_notes',
    //     ]);

    //     if ($request->hasFile('image_path')) {
    //         // Delete old image if exists
    //         if ($client->image_path && file_exists(public_path($client->image_path))) {
    //             unlink(public_path($client->image_path));
    //         }

    //         // Upload new image
    //         $image     = $request->file('image_path');
    //         $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('assets/admin/clients/images'), $imageName);
    //         $imagePath = 'assets/admin/clients/images/' . $imageName;

    //         // Update the database
    //         $client->update([
    //             'image_path' => $imagePath,
    //         ]);
    //     }

    //     $lead->update([
    //         'first_name'          => $validated['first_name'] ?? null,
    //         'middle_name'         => $validated['middle_name'] ?? null,
    //         'last_name'           => $validated['last_name'] ?? null,
    //         'birth_date'          => $validated['dob'] ?? null,
    //         'marriage_date'       => $validated['marriage_date'] ?? null,
    //         'phonecode'           => $request->input('phonecode') ?? null,
    //         'phone'               => $validated['phone'] ?? null,
    //         'alternate_mobile_number'=> $request->input('alternate_mobile_number') ?? null,
    //         'email'               => $validated['email'] ?? null,
    //         'country'             => $validated['country'] ?? null,
    //         'state'               => $validated['state'] ?? null,
    //         'district'            => $validated['district'] ?? null,
    //         'city'                => $validated['city'] ?? null,
    //         'taluka'              => $validated['taluka'] ?? null,
    //         'village'             => $validated['village'] ?? null,
    //         'notes'               => $validated['notes_address'] ?? null,
    //         'lead_ancestor_notes' => $validated['lead_ancestor_notes'] ?? null,
    //         'wife_ancestor_notes' => $validated['wife_ancestor_notes'] ?? null,
    //     ]);

    //     // Save to database
    //     $client->update([
    //         'kulvrisk_id'     => $request->kulvrisk_id,
    //         // 'lead_id'         => $lead->id,
    //         'researcher_ids'  => json_encode($request->researcher_ids),
    //         // 'agent_id'        => Auth::user()->id,
    //         'project_ids'     => json_encode($request->project),
    //         'sub_project_ids' => json_encode($request->sub_project),
    //         'payment_mode'    => $request->payment_mode,
    //         'start_date'      => $request->start_date,
    //         'end_date'        => $request->end_date,
    //         'image_path'      => $imagePath ?? $client->image_path,
    //         'description'     => $request->description ?? '',
    //     ]);

    //     LeadHelper::saveFamilyMembers($lead->id, 'lead', $request->input('family', []), $request->ancestor_notes);
    //     LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggf', 'great-grandfather');
    //     LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggm', 'great-grandmother');

    //     LeadHelper::saveFamilyMembers($lead->id, 'wife', $request->input('wife_family', []), $request->ancestor_notes);
    //     LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggf', 'great-grandfather');
    //     LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggm', 'great-grandmother');

    //     LeadHelper::saveSiblings($lead->id, 'lead', $request, 'sibling');
    //     LeadHelper::saveSiblings($lead->id, 'wife', $request, 'wife_sibling');

    //     LeadHelper::saveLineages($lead->id, $request);
    //     LeadHelper::saveWifeDetails($lead->id, $request);
    //     LeadHelper::saveChildren($lead->id, $request);
    //     // LeadHelper::saveLeadNotes($lead->id, $request);

    //     if ($request->hasFile('image')) {
    //         $image     = $request->file('image');
    //         $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('clients/images'), $imageName);
    //         $imagePath = 'clients/images/' . $imageName;
    //     }

    //     log_activity('Client', 'update', "Client updated: {$lead->first_name} {$lead->last_name}");

    //     return redirect()->back()->with('success', 'Client updated successfully.');
    // }
    
    //mansi add new 
     public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $lead   = Lead::findOrFail($client->lead_id);

        $request->validate([
            'kulvrisk_id'    => 'required|max:10|unique:clients,kulvrisk_id,' . $id,
            'payment_mode' => 'required|string|in:neft,dbf,cheque,upi,credit,debit,cash,razorpay,stripe,op,pp',
            'project'        => 'nullable|array',
            'sub_project'    => 'nullable|array',
            'service_name'          => 'nullable|array',
            'service_name.*'        => 'nullable|string|max:255',
            'service_description'   => 'nullable|array',
            'service_description.*' => 'nullable|string|max:500',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'image'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            // 'description'    => 'nullable|string',
            'first_name'     => 'required|string|max:255',
            'middle_name'    => 'nullable|string|max:255',
            'last_name'      => 'required|string|max:255',
            'dob'            => 'nullable|date',
            'marriage_date'  => 'nullable|date',
            'phone'          => 'required|unique:leads,phone,' . $lead->id . ',id,deleted_at,NULL',
            'email'          => 'required|email:rfc,dns|unique:leads,email,' . $lead->id . ',id,deleted_at,NULL',
            'country'        => 'required',
            'state'          => 'required',
            'district'       => 'required',
            'city'           => 'nullable',
            'taluka'         => 'nullable|string|max:100',
            'village'        => 'nullable|string|max:100',
            'notes_address'  => 'nullable|string',
            'researcher_ids' => 'required',
        ]);
        $serviceDescs = $request->service_description ?? [];

        // if (count($request->project) !== count($request->sub_project)) {
        //     return back()->withErrors(['sub_project' => 'Each project must have a sub-project']);
        // }

        $validated = $request->only([
            'first_name', 'middle_name', 'last_name',
            'dob', 'marriage_date', 'phone', 'email',
            'country', 'state', 'district', 'city',
            'taluka', 'village', 'notes_address', 
            'lead_ancestor_notes', 'wife_ancestor_notes',
        ]);

        if ($request->hasFile('image_path')) {
            if ($client->image_path && file_exists(public_path($client->image_path))) {
                unlink(public_path($client->image_path));
            }
            $image     = $request->file('image_path');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admin/clients/images'), $imageName);
            $imagePath = 'assets/admin/clients/images/' . $imageName;
            $client->update(['image_path' => $imagePath]);
        }

        $lead->update([
            'first_name'             => $validated['first_name'] ?? null,
            'middle_name'            => $validated['middle_name'] ?? null,
            'last_name'              => $validated['last_name'] ?? null,
            'birth_date'             => $validated['dob'] ?? null,
            'marriage_date'          => $validated['marriage_date'] ?? null,
            'phonecode'              => $request->input('phonecode') ?? null,
            'phone'                  => $validated['phone'] ?? null,
            'alternate_mobile_number'=> $request->input('alternate_mobile_number') ?? null,
            'email'                  => $validated['email'] ?? null,
            'country'                => $validated['country'] ?? null,
            'state'                  => $validated['state'] ?? null,
            'district'               => $validated['district'] ?? null,
            'city'                   => $validated['city'] ?? null,
            'taluka'                 => $validated['taluka'] ?? null,
            'village'                => $validated['village'] ?? null,
            'notes'                  => $validated['notes_address'] ?? null,
            'lead_ancestor_notes'    => $validated['lead_ancestor_notes'] ?? null,
            'wife_ancestor_notes'    => $validated['wife_ancestor_notes'] ?? null,
        ]);

        $client->update([
            'kulvrisk_id'     => $request->kulvrisk_id,
            'researcher_ids'  => json_encode($request->researcher_ids),
            'project_ids'     => json_encode($request->project),
            'sub_project_ids' => json_encode($request->sub_project),
            'payment_mode'    => $request->payment_mode,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'image_path'      => $imagePath ?? $client->image_path,
            'description'     => $request->description ?? '',
        ]);

        // ✅ ClientServices update
        $client->clientServices()->delete();

        $projectIds    = array_map(fn($v) => ($v === '' || $v === null) ? null : (int)$v, $request->project ?? []);
        $subProjectIds = array_map(fn($v) => ($v === '' || $v === null) ? null : (int)$v, $request->sub_project ?? []);
        $serviceNames  = $request->service_name ?? [];
        $serviceDescs  = $request->service_description  ?? [];

        $maxBlocks = max(count($projectIds), count($subProjectIds), count($serviceNames),   count($serviceDescs),  1);

        for ($i = 0; $i < $maxBlocks; $i++) {
            $projectId    = isset($projectIds[$i])    ? (int)$projectIds[$i]    : 0;
            $subProjectId = isset($subProjectIds[$i]) ? (int)$subProjectIds[$i] : 0;
            $hasProject   = $projectId > 0 && $subProjectId > 0;

            $serviceName = trim($serviceNames[$i] ?? '');
            $serviceDesc = trim($serviceDescs[$i] ?? '');
            $hasService  = $serviceName !== '' || $serviceDesc !== '';

            if ($hasProject) {
                ClientService::create([
                    'client_id'      => $client->id,
                    'block_index'    => $i,
                    'project_id'     => $projectId,
                    'sub_project_id' => $subProjectId,
                    'service_name'   => null,
                    'description'    => null,
                    'quantity'       => 1,
                    'amount'         => 0,
                    'type'           => 'project',
                ]);
            }

            if ($hasService) {
                ClientService::create([
                    'client_id'      => $client->id,
                    'block_index'    => $i,
                    'project_id'     => null,
                    'sub_project_id' => null,
                    'service_name'   => $serviceName !== '' ? $serviceName : null,
                    'description'    => $serviceDesc  !== '' ? $serviceDesc  : null,
                    'quantity'       => 1,
                    'amount'         => 0,
                    'type'           => 'service',
                ]);
            }
        }

        LeadHelper::saveFamilyMembers($lead->id, 'lead', $request->input('family', []), $request->ancestor_notes);
        LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggf', 'great-grandfather');
        LeadHelper::saveGreatGrandParents($lead->id, 'lead', $request, 'ggm', 'great-grandmother');
        LeadHelper::saveFamilyMembers($lead->id, 'wife', $request->input('wife_family', []), $request->ancestor_notes);
        LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggf', 'great-grandfather');
        LeadHelper::saveGreatGrandParents($lead->id, 'wife', $request, 'wife_ggm', 'great-grandmother');
        LeadHelper::saveSiblings($lead->id, 'lead', $request, 'sibling');
        LeadHelper::saveSiblings($lead->id, 'wife', $request, 'wife_sibling');
        LeadHelper::saveLineages($lead->id, $request);
        LeadHelper::saveWifeDetails($lead->id, $request);
        LeadHelper::saveChildren($lead->id, $request);

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clients/images'), $imageName);
            $imagePath = 'clients/images/' . $imageName;
        }

        log_activity('Client', 'update', "Client updated: {$lead->first_name} {$lead->last_name}");

        return redirect()->back()->with('success', 'Client updated successfully.');
    }


    public function destory($id)
    {
        $bill = Bill::where('client_id', $id)->first();
        $report = ResearcherReport::where('client_id', $id)->first();
        if ($bill || $report) {
            return redirect()->back()->with('error', 'Client cannot be deleted because it has a bill or report.');
        }
        $client = Client::findOrFail($id);
        $lead   = Lead::findOrFail($client->lead_id);

        // Soft delete related models first
        $lead->families()->delete();
        $lead->siblings()->delete();
        $lead->lineages()->delete();
        $lead->wifeDetail()->delete();
        $lead->children()->delete();
        $lead->leadNote()->delete();
        // Then soft delete the lead
        $lead->delete();
        $client->delete();

        log_activity('Client', 'delete', "Client deleted: {$lead->first_name} {$lead->last_name}");

        return redirect('admin/clients')->with('success', 'Client deleted successfully.');

    }

    public function attachment($lead_id)
    {
        $attachments = LeadAttachment::with(['lead', 'note.user'])
            ->where('lead_id', $lead_id)
            ->get();
        return view('admin.clients.all-attachment', compact('attachments'));
    }

    public function deleteAttachment($id)
    {
        $attachment = LeadAttachment::findOrFail($id);

        // Delete the file from storage
        if (file_exists(public_path($attachment->attachment))) {
            unlink(public_path($attachment->attachment));
        }

        // Delete the attachment record
        $attachment->forceDelete();

        return redirect()->back()->with('success', 'Attachment deleted successfully.');
    }

    public function assignResearcher(Request $request)
    {
        $request->validate([
            'researcher_ids' => 'required|array|min:1',
        ]);
        $client                 = Client::findOrFail($request->client_id);
        $client->researcher_ids = $request->researcher_ids ? json_encode($request->researcher_ids) : null;
        $client->save();

        log_activity('Client', 'assign researcher', "Assign Researcher");

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Researcher assigned successfully!'
            ]);
        }

        return redirect('admin/clients')->with('success', 'Researcher assinging successfully');
    }

    public function downloadPdf($id)
    {
        $data = Client::with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts'])->findOrFail($id);

        $pdf = PDF::loadView('admin.preview.client-preview', ['data' => $data]);
        $pdf->setPaper('a4', 'landscape');

        // Configure DomPDF for better performance
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', false);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->getDomPDF()->set_option('isFontSubsettingEnabled', false);
        $pdf->getDomPDF()->set_option('defaultFont', 'Noto Sans Devanagari');
        $pdf->getDomPDF()->set_option('enable_unicode', true);
        $pdf->getDomPDF()->set_option('dpi', 72);
        $pdf->getDomPDF()->set_option('debug_keep_temp', false);
        $pdf->getDomPDF()->set_option('debug_css', false);
        $pdf->getDomPDF()->set_option('debug_layout', false);

        return $pdf->download('client_preview_' . $id . '.pdf');
    }

    //mansi add  new 
    public function createBillForClient($clientId)
    {
        $client = Client::findOrFail($clientId);

        // Already bill exist so move in edit
        $existingBill = $client->bills()->latest()->first();
        if ($existingBill) {
            return redirect(url('admin/bills/edit/' . $existingBill->id));
        }

        // Bill create
        $bill = Bill::create([
            'client_id'      => $client->id,
            'invoice_number' => generate_invoice_number(),
        ]);

        // ClientServices fetch
        $clientServices = $client->clientServices()->orderBy('block_index')->get();

        // SubProject amounts fetch
        $subProjectIds = $clientServices->pluck('sub_project_id')->filter()->unique()->toArray();
        $projectsById  = collect();
        if (!empty($subProjectIds)) {
            $projectsById = Project::whereIn('id', $subProjectIds)->get()->keyBy('id');
        }

        // BillServices create
        foreach ($clientServices as $cs) {
            if ($cs->type === 'project') {
                $unitPrice = (float)($projectsById->get($cs->sub_project_id)?->amount ?? 0);
                $qty       = (float)($cs->quantity ?? 1);

                BillService::create([
                    'bill_id'        => $bill->id,
                    'block_index'    => $cs->block_index,
                    'project_id'     => $cs->project_id,
                    'sub_project_id' => $cs->sub_project_id,
                    'service_name'   => null,
                    'description'    => null,
                    'hsn'            => null,
                    'quantity'       => $qty,
                    'amount'         => $unitPrice * $qty, // ✅
                    'type'           => 'project',
                ]);
            }

            if ($cs->type === 'service') {
                $qty = (float)($cs->quantity ?? 1);

                BillService::create([
                    'bill_id'        => $bill->id,
                    'block_index'    => $cs->block_index,
                    'project_id'     => null,
                    'sub_project_id' => null,
                    'service_name'   => $cs->service_name,
                    'description'    => $cs->description,
                    'hsn'            => null,
                    'quantity'       => $qty,
                    'amount'         => $cs->amount ?? 0, // ✅
                    'type'           => 'service',
                ]);
            }
        }

        return redirect(url('admin/bills/edit/' . $bill->id));
    }


}