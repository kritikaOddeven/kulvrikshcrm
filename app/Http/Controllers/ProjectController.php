<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('project_id', null)->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
        ]);
        $data              = new Project();
        $data->name        = $request->name;
        $data->description = $request->description;
        // $data->project_id = $request->filled('project_id') ? $request->project_id : null;
        $data->status = $request->status;
        $data->save();

        log_activity('Project', 'create', "New project created: {$data->name}");

        return redirect('admin/projects/')->with('success', 'Project added successfully');
    }

    public function edit($id)
    {
        $project  = Project::where('id', $id)->first();
        $response = [
            'project' => $project,
        ];
        return response()->json($project, 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
        ]);
        $data              = Project::find($request->project_id);
        $data->name        = $request->name;
        $data->description = $request->description;
        $data->status      = $request->status;
        $data->save();

        log_activity('Project', 'update', "Project updated: {$data->name}");

        return redirect('admin/projects/')->with('success', 'Project updated successfully');
    }

    public function view($id)
    {
        $project    = Project::findOrFail($id);
        $subProject = Project::where('project_id', $id)->get();
        // dd($subProject);
        return view('admin/projects/view', compact('project', 'subProject'));
    }

    public function destory($id)
    {
        $project = Project::findOrFail($id);
        $projectName = $project->name;
        $project->delete();
        log_activity('Project', 'delete', "Project deleted: {$projectName}");


        return redirect('admin/projects/')->with('success', 'Project deleted successfully');
    }

    public function subStore(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'amount'      => 'required',
            'status'      => 'required',
        ]);
        // dd($request->all());
        
        $data              = new Project();
        $data->name        = $request->name;
        $data->description = $request->description;
        $data->status      = $request->status;
        $data->amount      = $request->amount;
        $data->project_id  = $request->filled('project_id') ? $request->project_id : null;
        $data->save();
        // dd($data);
        log_activity('Sub Project', 'create', "New sub project created: {$data->name}");

        return redirect('admin/projects/view/' . $request->project_id)->with('success', 'Sub Project added successfully');
    }

    public function subEdit($id)
    {
        $subProject = Project::where('id', $id)->first();
        $response   = [
            'subProject' => $subProject,
        ];
        return response()->json($subProject, 200);
    }

    public function subUpdate(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'amount'      => 'required',
            'status'      => 'required',
        ]);
        $data              = Project::find($request->subProject_id);
        $data->name        = $request->name;
        $data->description = $request->description;
        $data->status      = $request->status;
        $data->amount      = $request->amount;
        $data->project_id  = $request->filled('project_id') ? $request->project_id : null;
        $data->save();

        log_activity('Sub Project', 'update', "New sub project updated: {$data->name}");

        return redirect('admin/projects/view/' . $request->project_id)->with('success', 'Sub Project updated successfully');
    }

    public function subDestory($id)
    {
        // dd($id);
        $data = Project::findOrFail($id);
        $p_id = $data->project_id;
        $data->delete();
        log_activity('Sub Project', 'delete', "New sub project deleted");

        return redirect('admin/projects/view/' . $p_id)->with('success', 'Sub project deleted successfully');
    }

    public function getSubprojects(Project $project)
    {
        $subprojects = $project->subprojects()->get();
        return response()->json($subprojects);
    }

}
