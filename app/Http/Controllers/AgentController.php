<?php
namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class AgentController extends Controller
{
    public function index()
    {
        $agent = User::where('is_admin', false)->get();
        $roles = Role::where('status', 'active')->where('name', '!=', 'super-admin')->pluck('name');
        return view('admin.agents.index', compact('agent', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email:rfc,dns|unique:users,email',
            'phone'    => 'required|unique:users,phone',
            'role'     => 'required',
            'password' => 'required',
        ]);
        $agent           = new User();
        $agent->name     = $request->name;
        $agent->email    = $request->email;
        $agent->phone    = $request->phone;
        $agent->password = Hash::make($request->password);
        $agent->status   = $request->status;
        $agent->save();
        $agent->assignRole($request->role);

        Mail::to($agent->email)->send(new WelcomeMail($agent, $request->password));
        log_activity('Agent', 'add', "{$agent->name} was created.");
        return response()->json(['status' => 'success', 'message' => 'Agent added successfully']);

    }

    public function edit($id)
    {
        // $agent    = user::where('id', $id)->get()->first();
        // $userRole = $agent->roles->pluck('name')->first();
        // $response = [
        //     'agent' => $agent,
        //     'userRole' => $userRole,
        // ];
        // return response()->json($agent, 200);
        $agent = User::with('roles')->findOrFail($id); 
        return response()->json($agent);
    }

    public function update(Request $request)
    {
        $agent = User::find($request->agent_id);
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $agent->id,
            'phone' => 'required|unique:users,phone,' . $agent->id,
            'role'  => 'required',
        ]);
        $agent->name  = $request->name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        if ($request->has('password') && $request->password) {
            $agent->password = Hash::make($request->password);
        }
        $agent->syncRoles([$request->role]);
        $agent->status = $request->status;
        $agent->save();
        log_activity('Agent', 'update', "{$agent->name} was updated.");

        return response()->json(['status' => 'success', 'message' => 'Agent updated successfully']);

    }

    public function show($id)
    {
        $data  = User::where(['id', $id, 'is_admin', false])->get()->first();
        $roles = Role::where('status', 'active')->where('name', '!=', 'super-admin')->pluck('name');
        // dd($roles);
        return view('admin.agents.view_agent', compact('data', 'roles'));
    }

    public function destory($id)
    {
        $agent = User::findOrFail($id);
        log_activity('Agent', 'delete', "{$agent->name} was deleted.");
        $agent->delete();
        return redirect('admin/agents/')->with('success', 'Agent deleted successfully');
    }
}
