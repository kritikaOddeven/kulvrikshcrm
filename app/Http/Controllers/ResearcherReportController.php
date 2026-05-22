<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ResearcherReport;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ResearcherReportController extends Controller
{
    public function index()
    {
        $researchers = Client::whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])->where('is_researchar_report', true)->with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts', 'report'])->get();
        $role        = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();
        
        $researchersName = collect();

        if ($role) {
            $researchersName = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }
        return view('admin.researchers.reports.index', compact('researchers', 'researchersName'));
    }

    public function archives()
    {
        $researchers = Client::onlyTrashed()->whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])->with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts'])->where('is_researchar_report', true)->get();
        $role        = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();

        $researchersName = collect();

        if ($role) {
            $researchersName = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }
        log_activity('Researcher Report', 'archive', "Researcher report archive");

        return view('admin.researchers.reports.archive', compact('researchers', 'researchersName'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'         => 'required',
            'top_tagline'       => 'nullable|string',
            'kul_tagline'       => 'nullable|string',
            'name'              => 'nullable|string',
            'surname'           => 'nullable|string',
            'lineage'           => 'nullable|string',
            'credit'            => 'nullable|string',
            'caste'             => 'nullable|string',
            'subspecies'        => 'nullable|string',
            'gotra'             => 'nullable|string',
            'pravar'            => 'nullable|string',
            'vedas'             => 'nullable|string',
            'upaveda'           => 'nullable|string',
            'branch'            => 'nullable|string',
            'peak'              => 'nullable|string',
            'formula'           => 'nullable|string',
            'gotra_devi'        => 'nullable|string',
            'ishta_devi'        => 'nullable|string',
            'ishtadev'          => 'nullable|string',
            'kuldevi'           => 'nullable|string',
            'kuldevata'         => 'nullable|string',
            'supportive_mother' => 'nullable|string',
            'river'             => 'nullable|string',
            'ancestor_shrine'   => 'nullable|string',
            'tirth_purohit'     => 'nullable|string',
            'original_location' => 'nullable|string',
            'kuldevi_dash'      => 'nullable|string',
            'patriarchy'        => 'nullable|string',
            'title'             => 'nullable|string',
            'description'       => 'nullable|string',
            'history_title'             => 'nullable|string',
            'history_description'       => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'translated_language' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clients/research-reports'), $imageName);
            $validated['image'] = 'clients/research-reports/' . $imageName;
        }

        ResearcherReport::updateOrCreate(['client_id' => $validated['client_id']], $validated);
        log_activity('Researcher Report', 'create', "Researcher report created");


        return redirect()->back()->with('success', 'Research report saved successfully.');
    }

    public function show(Request $request, $id)
    {

        $projects    = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();
        $data        = Client::withTrashed()->where('id', $id)->with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts', 'conversation', 'researcherView', 'report'])->first();
        // dd($data->conersation);
        return view('admin.researchers.reports.view', compact('data', 'projects', 'subprojects'));
    }

    public function edit($id)
    {
        $report = ResearcherReport::with('client.lead.lineages')->where('client_id', $id)->first();
        if (!$report) {
            $report = Client::with('lead.lineages')->where('id', $id)->first();
            $lineage = $report->lead->lineages()->where('belongs_to', 'lead')->first();
        }else{
        $lineage = $report->client->lead->lineages()->where('belongs_to', 'lead')->first();
            
        }
        return view('admin.researchers.reports.edit-report', compact('report', 'lineage'));
    }

    public function destroy($id, Request $request)
    {
        $report = Client::withTrashed()->findOrFail($id);
        if($request->force){
            $report->forceDelete();
        }else{
            $report->delete();
        }
        log_activity('Researcher Report', 'deleted', "Researcher report deleted");

        return redirect()->back()->with('success', 'Researcher report deleted successfully');
    }

    public function restore($id)
    {
        $report = Client::onlyTrashed()->findOrFail($id);
        $report->restore();
        
        log_activity('Researcher Report', 'restore', "Researcher report restore");

        return redirect()->back()->with('success', 'Researcher report restored successfully');
    }

    public function pdf1($id)
    {
        $report = ResearcherReport::with('client.lead')->where('client_id', $id)->first();
        if (!$report) {
            return redirect()->back()->with('error', 'Report not found');
        }
        return view('admin.researchers.reports.pdf-page1', compact('report'));
    }
   
}
