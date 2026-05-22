<?php
namespace App\Http\Controllers;

use App\Helpers\LeadHelper;
use App\Models\Children;
use App\Models\City;
use App\Models\Taluka;
use App\Models\Client;
use App\Models\Country;
use App\Models\Village;
use App\Models\District;
use App\Models\Lead;
use App\Models\LeadAttachment;
use App\Models\LeadNote;
use App\Models\Lineages;
use App\Models\Project;
use App\Models\State;
use App\Models\Bill;
use App\Models\BillService;
use App\Models\User;
use App\Models\ClientService;
use App\Models\WifeDetail;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        $agents    = User::whereHas('roles', fn($q) => $q->where('role_type', 'agent'))->get();
        $projects  = Project::parent()->status('active')->get();

        return view('admin.leads.index', compact('countries', 'agents', 'projects'));
    }

    public function getLeadsData(Request $request)
    {
        $query = Lead::excludeLeadClients()
            ->with(['user', 'states', 'cities', 'countries', 'districts', 'lineages', 'talukas', 'villages'])
            ->leftJoin('talukas', 'leads.taluka', '=', 'talukas.id')
            ->leftJoin('villages', 'leads.village', '=', 'villages.id')
            ->select('leads.*');

        if ($request->filled('agent_name')) {
            $query->where('added_by', $request->agent_name);
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

         $query->orderBy('leads.created_at', 'desc');

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
            ->addColumn('created_date', fn($item) => $item->created_at->format('d M Y'))
            ->orderColumn('created_date', function($query, $order) {
                            $query->orderBy('leads.created_at', $order);})
                            
            ->addColumn('taluka_name', function($item) {
                return $item->talukas ? $item->talukas->name : '';
            })
            ->orderColumn('taluka_name', function($query, $order) {
                $query->orderBy('talukas.name', $order);
            })
            
            ->addColumn('village_name', function($item) {
                return $item->villages ? $item->villages->name : '';
            })
            ->orderColumn('village_name', function($query, $order) {
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
                
            
                return '<button type="button" class="btn btn-sm ' . $bgClass . ' status-btn" 
                            data-id="' . $item->id . '" 
                            data-status="' . $item->status . '" 
                            data-bs-toggle="modal" 
                            data-bs-target="#statusModal">
                            ' . ucfirst($item->status) . ' <i class="ri-edit-line"></i>
                        </button>';
            })
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('leads.status', $order);
            })
            ->addColumn('action', function ($item) {
                $buttons = '';
                $buttons .= '<div class="d-flex gap-2">';

                if (auth()->user()->can('convert_to_client')) {
                    $buttons .= '<a href="#" class="convert-icon-btn btn-sm btn-action open-convert-modal rounded-pill mr-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-lead-id="' . $item->id . '" title="convert-lead-to-client"><i class="ri-refresh-fill"></i></a>';
                }

                if (auth()->user()->can('view_lead')) {
                    $buttons .= '<a href="' . url('admin/leads/view/' . $item->id) . '" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>';
                }

                if (auth()->user()->can('edit_lead')) {
                    $buttons .= '<a href="' . url('admin/leads/edit/' . $item->id) . '" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a>';
                }

                if (auth()->user()->can('delete_lead')) {
                    $buttons .= '<form action="' . url('admin/leads/delete/' . $item->id) . '" method="POST" id="deleteForm_' . $item->id . '" style="display:inline;">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="button" class="delete-icon-btn btn-sm btn-action mr-1" onclick="deleteAccount(this, ' . $item->id . ')"><i class="ri-delete-bin-6-line"></i></button>' .
                        '</form>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        $country = Country::all();
        return view('admin.leads.add', compact('country'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'first_name'          => 'required|string|max:255',
            'middle_name'         => 'nullable|string|max:255',
            'last_name'           => 'required|string|max:255',
            'dob'                 => 'nullable|date',
            'marriage_date'       => 'nullable|date',
            // 'phone'               => 'required|unique:leads,phone',
            // 'email'               => 'nullable|email:rfc,dns|unique:leads,email',
            'phone'               => 'required|unique:leads,phone,NULL,id,deleted_at,NULL',
            'email' => 'nullable|email:rfc,dns|unique:leads,email,NULL,id,deleted_at,NULL',
            'country'             => 'required',
            'state'               => 'required',
            'district'            => 'required',
            'city'                => 'required',
            'taluka'              => 'nullable|string|max:100',
            'village'             => 'nullable|string|max:100',
            'notes_address'       => 'nullable|string',
            'original_language'   => 'nullable|string',
            'translated_language' => 'nullable|string',
        ]);
        $lead = Lead::excludeLeadClients()->create([
            'added_by'                => auth()->id(),
            'first_name'              => $request->input('first_name'),
            'middle_name'             => $request->input('middle_name'),
            'last_name'               => $request->input('last_name'),
            'birth_date'              => $request->input('dob'),
            'marriage_date'           => $request->input('marriage_date'),
            'phone'                   => $request->input('phone'),
            'phonecode'               => $request->input('phonecode'),
            'alternate_mobile_number' => $request->input('alternate_mobile_number'),
            'email'                   => $request->input('email'),
            'country'                 => $request->input('country'),
            'state'                   => $request->input('state'),
            'district'                => $request->input('district'),
            'city'                    => $request->input('city'),
            'taluka'                  => $request->input('taluka'),
            'village'                 => $request->input('village'),
            'notes'                   => $request->input('notes_address'),
            'lead_ancestor_notes'     => $request->input('lead_ancestor_notes'),
            'wife_ancestor_notes'     => $request->input('wife_ancestor_notes'),
            'original_language'       => $request->input('original_language'),
            'translated_language'     => $request->input('translated_language'),
        ]);

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

        log_activity('Lead', 'create', "New lead created: {$lead->first_name} {$lead->last_name}");

        return redirect('admin/leads')->with('success', 'Lead created successfully.');
    }

    public function show(Request $request, $id)
    {
        $projects    = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();
        $data        = Lead::excludeLeadClients()->where('id', $id)->with('wifeDetail', 'families', 'siblings', 'children', 'lineages', 'leadNote', 'states', 'cities', 'countries', 'districts')->first();

        if ($request->has('preview') && $request->preview == 'true') {
            return view('admin.preview.lead-preview', compact('data', 'projects', 'subprojects'));
        }
        return view('admin.leads.view', compact('data', 'projects', 'subprojects'));
    }

    public function edit($id)
    {
        $data    = Lead::excludeLeadClients()->where('id', $id)->with('wifeDetail', 'families', 'siblings', 'children', 'lineages', 'leadNote.user', 'leadNote.attachments')->first();
        $country = Country::all();
        // $states    = State::all();
        // $cities    = City::all();
        // $districts = District::all();
        $selectedCountryId  = $data->country ?? null;
        $selectedWifeCountryId  = $data->wifeDetail->country ?? null;
        $selectedStateId    = $data->state ?? null;
        $selectedCityId    = $data->city ?? null;   //add new for taluka
        $selectedTalukaId    = $data->taluka ?? null;   //add new for village
        $selectedDistrictId = $data->district ?? null;
        $selectedWifeStateId = $data->wifeDetail->state ?? null;
        $selectedWifeCityId = $data->wifeDetail->city ?? null;
        $selectedWifeTalukaId = $data->wifeDetail->taluka ?? null;

        $country   = Country::all(); // fine (not too big)
        $states    = State::where('country_id', $selectedCountryId)->get();
        $wifeStates    = State::where('country_id', $selectedWifeCountryId)->get();
        $districts = District::where('state_id', $selectedStateId)->get();
        $cities    = City::where('state_id', $selectedStateId)->get();
        $talukas    = Taluka::where('city_id', $selectedCityId)->get(); //added new for tauka
        $villages    = Village::where('taluka_id', $selectedTalukaId)->get(); //added new for village
        $wifeCities    = City::where('state_id', $selectedWifeStateId)->get();
        $wifeDistricts = District::where('state_id', $selectedWifeStateId)->get();
        $wifeVillages = Village::where('taluka_id', $selectedWifeTalukaId)->get();
        $wifeTalukas = Taluka::where('city_id', $selectedWifeCityId)->get();

        return view('admin.leads.edit', compact('data', 'country', 'states', 'cities','talukas', 'villages', 'districts', 'wifeStates', 'wifeCities', 'wifeDistricts', 'wifeTalukas', 'wifeVillages'));
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::excludeLeadClients()->findOrFail($id);

        $request->validate([
            'first_name'          => 'required|string|max:255',
            'middle_name'         => 'nullable|string|max:255',
            'last_name'           => 'required|string|max:255',
            'dob'                 => 'nullable|date',
            'marriage_date'       => 'nullable|date',
            // 'phone'               => 'required|unique:leads,phone,' . $lead->id,
            // 'email'               => 'nullable|email|unique:leads,email,' . $lead->id,
             'phone' => 'required|unique:leads,phone,' . $lead->id . ',id,deleted_at,NULL',
            'email' => 'nullable|email|unique:leads,email,' . $lead->id . ',id,deleted_at,NULL',
            'country'             => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'district'            => 'required|string|max:100',
            'city'                => 'nullable|string|max:100',
            'taluka'              => 'nullable|string|max:100',
            'village'             => 'nullable|string|max:100',
            'notes_address'       => 'nullable|string',
            'original_language'   => 'nullable|string',
            'translated_language' => 'nullable|string',
        ]);

        $validated = $request->only([
            'first_name', 'middle_name', 'last_name',
            'dob', 'marriage_date', 'phone', 'alternate_mobile_number', 'email',
            'country', 'state', 'district', 'city',
            'taluka', 'village', 'notes_address', 'lead_ancestor_notes', 'wife_ancestor_notes', 'original_language', 'translated_language',
        ]);

        $lead->update([
            'first_name'              => $validated['first_name'] ?? null,
            'middle_name'             => $validated['middle_name'] ?? null,
            'last_name'               => $validated['last_name'] ?? null,
            'birth_date'              => $validated['dob'] ?? null,
            'marriage_date'           => $validated['marriage_date'] ?? null,
            'phonecode'               => $request->input('phonecode') ?? null,
            'phone'                   => $validated['phone'] ?? null,
            'alternate_mobile_number' => $validated['alternate_mobile_number'] ?? null,
            'email'                   => $validated['email'] ?? null,
            'country'                 => $validated['country'] ?? null,
            'state'                   => $validated['state'] ?? null,
            'district'                => $validated['district'] ?? null,
            'city'                    => $validated['city'] ?? null,
            'taluka'                  => $validated['taluka'] ?? null,
            'village'                 => $validated['village'] ?? null,
            'notes'                   => $validated['notes_address'] ?? null,
            'lead_ancestor_notes'     => $validated['lead_ancestor_notes'] ?? null,
            'wife_ancestor_notes'     => $validated['wife_ancestor_notes'] ?? null,
            'original_language'       => $validated['original_language'] ?? null,
            'translated_language'     => $validated['translated_language'] ?? null,
        ]);

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
        // LeadHelper::saveLeadNotes($lead->id, $request);

        log_activity('Lead', 'update', "Lead updated: {$lead->first_name} {$lead->last_name}");

        return redirect()->back()->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lead = Lead::excludeLeadClients()->findOrFail($id);

        // Soft delete related models first
        $lead->families()->delete();
        $lead->siblings()->delete();
        $lead->lineages()->delete();
        $lead->wifeDetail()->delete();
        $lead->children()->delete();
        $lead->leadNote()->delete();
        // Then soft delete the lead
        $lead->delete();

        log_activity('Lead', 'delete', "Lead deleted");

        return redirect('admin/leads')->with('success', 'Lead deleted successfully.');
    }

    public function attachment($lead_id)
    {
        $attachments = LeadAttachment::with(['lead', 'note.user'])
            ->where('lead_id', $lead_id)
            ->get();
        return view('admin.leads.partials.all-attachment', compact('attachments'));
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

    // status update
    public function updateStatus(Request $request)
    {
        $lead         = Lead::excludeLeadClients()->findOrFail($request->id);
        $lead->status = $request->status;
        $lead->save();

        log_activity('Lead', 'status', "Lead status change: {$lead->first_name} {$lead->last_name}");

        return redirect('admin/leads')->with('success', 'Lead status updated successfully');

    }

    // public function convertToClient(Request $request)
    // {
    //     $request->validate([
    //         'payment_mode' => 'required|string',
    //         'project'      => 'required|array',
    //         'project.*'    => 'required|integer|exists:projects,id',
    //         'sub_project'  => 'required|array',
    //         'start_date'   => 'nullable|date',
    //         'end_date'     => 'nullable|date|after_or_equal:start_date',
    //         'image_path'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
    //         'description'  => 'nullable|string',
    //         'kulvrisk_id'  => 'nullable|unique:clients,kulvrisk_id',
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

    //     $lead = Lead::find($request->lead_id);
    //     // Save to database
    //     $client = Client::create([
    //         'kulvrisk_id'        => $request->kulvrisk_id ?? null,
    //         'lead_id'            => $request->lead_id,
    //         'researcher_ids'     => $request->researcher_id ? json_encode($request->researcher_id) : null,
    //         'agent_id'           => $lead->added_by,
    //         'converted_agent_id' => auth()->id(),
    //         'project_ids'        => json_encode($request->project),
    //         'sub_project_ids'    => json_encode($request->sub_project),
    //         'payment_mode'       => $request->payment_mode,
    //         'start_date'         => $request->start_date,
    //         'end_date'           => $request->end_date,
    //         'image_path'         => $imagePath ?? '',
    //         'description'        => $request->description ?? '',
    //     ]);

    //     Lead::excludeLeadClients()->where('id', $request->lead_id)->update([
    //         "is_lead_to_client" => true,
    //     ]);

    //     log_activity('Lead', 'lead to client', "Convert lead to client");

    //     return response()->json(['message' => 'Lead successfully converted to client.']);
    // }
    //mansi -old
    // public function convertToClient(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'payment_mode'          => 'required|string',
    //         'project'               => 'nullable|array',
    //         'project.*'             => 'nullable|integer|exists:projects,id',
    //         'sub_project'           => 'nullable|array',
    //         'sub_project.*'         => 'nullable|integer|exists:projects,id',
    //         'service_name'          => 'nullable|array',
    //         'service_name.*'        => 'nullable|string|max:255',
    //         'service_description'   => 'nullable|array',
    //         'service_description.*' => 'nullable|string|max:500',
    //         'start_date'            => 'nullable|date',
    //         'end_date'              => 'nullable|date|after_or_equal:start_date',
    //         'image_path'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
    //         'description'           => 'nullable|string',
    //         'kulvrisk_id'           => 'nullable|unique:clients,kulvrisk_id',
    //     ]);

    //     // valdation msg Kritika
    //     $validator->after(function ($validator) use ($request) {
    //         $projectIds    = $request->input('project', []);
    //         $subProjectIds = $request->input('sub_project', []);
    //         $serviceNames  = $request->input('service_name', []);
    //         $serviceDescs  = $request->input('service_description', []);

    //         $maxBlocks = max(count($projectIds), count($subProjectIds), count($serviceNames), count($serviceDescs), 1);

    //         $hasAnyProject = false;
    //         $hasAnyService = false;

    //         for ($i = 0; $i < $maxBlocks; $i++) {
    //             $p  = trim((string)($projectIds[$i] ?? ''));
    //             $sp = trim((string)($subProjectIds[$i] ?? ''));

    //             $sn = trim((string)($serviceNames[$i] ?? ''));
    //             $sd = trim((string)($serviceDescs[$i] ?? ''));

    //             if ($p !== '' || $sp !== '') {
    //                 if ($p === '' || $sp === '') {
    //                     $validator->errors()->add('sub_project', 'Each project must have a sub-project.');
    //                     break;
    //                 }
    //                 $hasAnyProject = true;
    //             }

    //             if ($sn !== '' || $sd !== '') {
    //                 $hasAnyService = true;
    //             }
    //         }

    //         if (!$hasAnyProject && !$hasAnyService) {
    //             $validator->errors()->add('project_or_service', 'Please add at least one Project OR Service.');
    //         }
    //     });

    //     $validator->validate();

    //     // Image upload
    //     $imagePath = '';
    //     if ($request->hasFile('image_path')) {
    //         $image     = $request->file('image_path');
    //         $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('assets/admin/clients/images'), $imageName);
    //         $imagePath = 'assets/admin/clients/images/' . $imageName;
    //     }

    //     $lead = Lead::find($request->lead_id);


    //     $client = Client::create([
    //         'kulvrisk_id'        => $request->kulvrisk_id ?? null,
    //         'lead_id'            => $request->lead_id,
    //         'researcher_ids'     => $request->researcher_id ? json_encode($request->researcher_id) : null,
    //         'agent_id'           => $lead->added_by,
    //         'converted_agent_id' => auth()->id(),
    //         'project_ids'        => json_encode($request->project),
    //         'sub_project_ids'    => json_encode($request->sub_project),
    //         'payment_mode'       => $request->payment_mode,
    //         'start_date'         => $request->start_date,
    //         'end_date'           => $request->end_date,
    //         'image_path'         => $imagePath,
    //         'description'        => $request->description ?? '',
    //     ]);

    
    //     $bill = Bill::create([
    //         'client_id'      => $client->id, 
    //         'invoice_number' => generate_invoice_number(),

    //     ]);

    //     $projectIds    = array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->project ?? []);
    //     $subProjectIds = array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->sub_project ?? []);
    //     $serviceNames  = $request->service_name ?? [];
    //     $serviceDescs  = $request->service_description ?? [];

    //     $maxBlocks = max(
    //         count($projectIds),
    //         count($subProjectIds),
    //         count($serviceNames),
    //         1
    //     );


    //     $projectsById = null;
    //     if (!empty($subProjectIds)) {
    //         $projectsById = Project::whereIn('id', array_unique(array_map('intval', array_filter($subProjectIds))))
    //             ->get()->keyBy('id');
    //     }

    //     for ($i = 0; $i < $maxBlocks; $i++) {
    //         $projectId    = isset($projectIds[$i])    ? (int) $projectIds[$i]    : 0;
    //         $subProjectId = isset($subProjectIds[$i]) ? (int) $subProjectIds[$i] : 0;
    //         $hasProject   = $projectId > 0 && $subProjectId > 0;

    //         $serviceName = trim($serviceNames[$i] ?? '');
    //         $serviceDesc = trim($serviceDescs[$i] ?? '');
    //         $hasService  = $serviceName !== '' || $serviceDesc !== '';

        
    //         if ($hasProject) {
    //             $unitPrice = $projectsById ? (float) ($projectsById->get($subProjectId)?->amount ?? 0) : 0;
    //             $lineTotal = $unitPrice; // qty = 1

    //             BillService::create([
    //                 'bill_id'        => $bill->id,      
    //                 'block_index'    => $i,
    //                 'project_id'     => $projectId,      
    //                 'sub_project_id' => $subProjectId, 
    //                 'service_name'   => null,
    //                 'description'    => null,
    //                 'hsn'            => null,
    //                 'quantity'       => 1,
    //                 'amount'         => $lineTotal,
    //                 'type'           => 'project',
    //             ]);
    //         }

            
    //         if ($hasService) {
    //             BillService::create([
    //                 'bill_id'        => $bill->id,
    //                 'block_index'    => $i,
    //                 'project_id'     => null,
    //                 'sub_project_id' => null,
    //                 'service_name'   => $serviceName !== '' ? $serviceName : null,
    //                 'description'    => $serviceDesc  !== '' ? $serviceDesc  : null,
    //                 'hsn'            => null,
    //                 'qty'       => 1,
    //                 'amount'         => 0,
    //                 'type'           => 'service',
    //             ]);
    //         }
    //     }

    //     Lead::excludeLeadClients()->where('id', $request->lead_id)->update([
    //         'is_lead_to_client' => true,
    //     ]);

    //     log_activity('Lead', 'lead to client', 'Convert lead to client');

    //     return response()->json(['message' => 'Lead successfully converted to client.']);
    // }
    
    // new add  mansi 11
    public function convertToClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_mode'          => 'required|string',
            'project'               => 'nullable|array',
            'project.*'             => 'nullable|integer|exists:projects,id',
            'sub_project'           => 'nullable|array',
            'sub_project.*'         => 'nullable|integer|exists:projects,id',
            'service_name'          => 'nullable|array',
            'service_name.*'        => 'nullable|string|max:255',
            'service_description'   => 'nullable|array',
            'service_description.*' => 'nullable|string|max:500',
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
            'image_path'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'description'           => 'nullable|string',
            'kulvrisk_id'           => 'nullable|unique:clients,kulvrisk_id',
        ]);

        $validator->after(function ($validator) use ($request) {
            $projectIds    = $request->input('project', []);
            $subProjectIds = $request->input('sub_project', []);
            $serviceNames  = $request->input('service_name', []);
            $serviceDescs  = $request->input('service_description', []);

            $maxBlocks = max(count($projectIds), count($subProjectIds), count($serviceNames), count($serviceDescs), 1);

            $hasAnyProject = false;
            $hasAnyService = false;

            for ($i = 0; $i < $maxBlocks; $i++) {
                $p  = trim((string)($projectIds[$i] ?? ''));
                $sp = trim((string)($subProjectIds[$i] ?? ''));
                $sn = trim((string)($serviceNames[$i] ?? ''));
                $sd = trim((string)($serviceDescs[$i] ?? ''));

                if ($p !== '' || $sp !== '') {
                    if ($p === '' || $sp === '') {
                        $validator->errors()->add('sub_project', 'Each project must have a sub-project.');
                        break;
                    }
                    $hasAnyProject = true;
                }

                if ($sn !== '' || $sd !== '') {
                    $hasAnyService = true;
                }
            }

            if (!$hasAnyProject && !$hasAnyService) {
                $validator->errors()->add('project_or_service', 'Please add at least one Project OR Service.');
            }
        });

        $validator->validate();

        // Image upload
        $imagePath = '';
        if ($request->hasFile('image_path')) {
            $image     = $request->file('image_path');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admin/clients/images'), $imageName);
            $imagePath = 'assets/admin/clients/images/' . $imageName;
        }

        $lead = Lead::find($request->lead_id);

        // Client create
        $client = Client::create([
            'kulvrisk_id'        => $request->kulvrisk_id ?? null,
            'lead_id'            => $request->lead_id,
            'researcher_ids'     => $request->researcher_id ? json_encode($request->researcher_id) : null,
            'agent_id'           => $lead->added_by,
            'converted_agent_id' => auth()->id(),
            'project_ids'        => json_encode($request->project),
            'sub_project_ids'    => json_encode($request->sub_project),
            'payment_mode'       => $request->payment_mode,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'image_path'         => $imagePath,
            'description'        => $request->description ?? '',
        ]);

        // ✅ ClientServices store
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
                    'quantity'       => 1,  // ✅
                      'amount'         => 0, 
                    'type'           => 'service',
                ]);
            }
        }

        // ✅ Lead update
        Lead::excludeLeadClients()->where('id', $request->lead_id)->update([
            'is_lead_to_client' => true,
        ]);

        log_activity('Lead', 'lead to client', 'Convert lead to client');

        return response()->json(['message' => 'Lead successfully converted to client.']);
    }
    public function downloadPdf($id)
    {
        $data = Lead::with(['countries', 'states', 'districts', 'cities', 'families', 'siblings', 'lineages', 'wifeDetail', 'children', 'leadNote.user'])
            ->findOrFail($id);

        $pdf = PDF::loadView('admin.preview.lead-preview', ['data' => $data]);
        $pdf->setPaper('a4', 'landscape');

        // Configure DomPDF for better performance and compatibility
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

        return $pdf->download('lead_preview_' . $id . '.pdf');
    }

    /**
     * Store a new note via AJAX
     */
    public function storeNote(Request $request, $lead_id)
    {
        $request->validate([
            'original_content'   => 'required|string',
            'translated_content' => 'required|string',
            'attachments.*'      => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp3,wav,m4a|max:10240',
        ]);

        try {
            // Create the note
            $note = LeadNote::create([
                'lead_id'          => $lead_id,
                'added_by'         => auth()->id(),
                'original_content' => $request->original_content,
                'content'          => $request->translated_content,
            ]);

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileType     = $file->getMimeType();
                    $fileCategory = explode('/', $fileType)[0]; // 'image', 'audio', or 'application'

                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/admin/leads/attachment'), $fileName);

                    LeadAttachment::create([
                        'lead_id'    => $lead_id,
                        'note_id'    => $note->id,
                        'attachment' => 'assets/admin/leads/attachment/' . $fileName,
                        'type'       => $fileCategory,
                    ]);
                }
            }

            // Load the user relationship for the response
            $note->load('user', 'attachments');

            log_activity('Lead Note', 'create', "New note added to lead ID: {$lead_id}");

            return response()->json([
                'success' => true,
                'message' => 'Note added successfully',
                'note'    => [
                    'id'               => $note->id,
                    'original_content' => $note->original_content,
                    'content'          => $note->content,
                    'user_name'        => $note->user->name,
                    'user_image'       => asset(get_profile_image($note->user->profile_image, $note->user->name)),
                    'created_at'       => $note->created_at->format('D d F, g:i'),
                    'attachments'      => $note->attachments->map(function ($attachment) {
                        return [
                            'id'         => $attachment->id,
                            'attachment' => asset($attachment->attachment),
                            'type'       => $attachment->type,
                            'icon'       => $attachment->type === 'image' ? 'image' : ($attachment->type === 'audio' ? 'file-music' : ($attachment->type === 'application' ? 'file-pdf' : 'file')),
                        ];
                    }),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding note: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing note via AJAX
     */
    public function updateNote(Request $request, $note_id)
    {
        $request->validate([
            'original_content'   => 'required|string',
            'translated_content' => 'required|string',
        ]);

        try {
            $note = LeadNote::findOrFail($note_id);

            // Check if user has permission to edit this note
            if ($note->added_by !== auth()->id() && ! auth()->user()->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to edit this note',
                ], 403);
            }

            $note->update([
                'original_content' => $request->original_content,
                'content'          => $request->translated_content,
            ]);

            log_activity('Lead Note', 'update', "Note updated ID: {$note_id}");

            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully',
                'note'    => [
                    'id'               => $note->id,
                    'original_content' => $note->original_content,
                    'content'          => $note->content,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating note: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a note via AJAX
     */
    public function deleteNote($note_id)
    {
        try {
            $note = LeadNote::findOrFail($note_id);

            // Check if user has permission to delete this note
            if ($note->added_by !== auth()->id() && ! auth()->user()->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to delete this note',
                ], 403);
            }

            // Delete associated attachments
            foreach ($note->attachments as $attachment) {
                if (file_exists(public_path($attachment->attachment))) {
                    unlink(public_path($attachment->attachment));
                }
                $attachment->forceDelete();
            }

            $note->delete();

            log_activity('Lead Note', 'delete', "Note deleted ID: {$note_id}");

            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting note: ' . $e->getMessage(),
            ], 500);
        }
    }
}