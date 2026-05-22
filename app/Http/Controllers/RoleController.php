<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        return view('admin.role-permissions.role', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'role_type' => 'required',
        ]);
        $role         = new Role();
        $role->name   = $request->name;
        $role->role_type = $request->role_type;
        $role->status = $request->status;
        $role->save();
        log_activity('Role', 'add', "{$role->name} role was added.");

        return redirect('admin/roles/')->with('success', 'Role added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd("test");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::where('id', $id)->get()->first();
        return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'role_type' => 'required',
        ]);
        $role->name   = $request->name;
        $role->role_type = $request->role_type;
        $role->status = $request->status;
        $role->update();
        log_activity('Role', 'update', "{$role->name} role was updated.");

        return redirect('admin/roles/')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::where('id', $id)->get()->first();
        log_activity('Role', 'delete', "{$role->name} role was deleted.");

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    public function permissions($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role-permissions.permission', compact('role'));
    }

    public function assignPermissions(Request $request)
    {
        $request->validate([
            'role_id'       => 'required|exists:roles,id',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $role = Role::findById($request->role_id);
        log_activity('Permission', 'update', "{$role->name} role permission was changed.");

        // Sync permissions (remove old and assign new)
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }
}
