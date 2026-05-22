{{-- edit role --}}
<style>
    .form-check-input{
        width: 20px !important;
        height: 20px !important;
        margin-top: 0 !important;
    }
</style>
<div class="modal fade" id="editRole{{$role->id}}" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="editRoleForm" action="{{ url('admin/roles/'.$role->id ) }}" data-role-id="{{$role->id}}" method="POST">
                @method('PUT')  
                @csrf
                <div class="modal-body row g-3">
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="col-md-12">
                        <label for="validationDefault01" class="form-label">Role Name <x-required-star /></label>
                        <input type="text" class="form-control" id="name" value="{{$role->name}}" name="name">
                        <span class="text-danger name-errorr{{$role->id}}"></span>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Role Type<x-required-star /></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_agent{{$role->id}}" value="agent" {{ $role->role_type === 'agent' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_type_agent{{$role->id}}">
                                    Agent
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_researcher{{$role->id}}" value="researcher" {{ $role->role_type === 'researcher' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_type_researcher{{$role->id}}">
                                    Researcher
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_admin_team{{$role->id}}" value="admin_team" {{ $role->role_type === 'admin_team' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_type_admin_team{{$role->id}}">
                                    Admin Team
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_none{{$role->id}}" value="none" {{ $role->role_type === 'none' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_type_none{{$role->id}}">
                                    None
                                </label>
                            </div>
                        </div>
                        <span class="text-danger role-type-errorr{{$role->id}}"></span>
                    </div>

                    <div class="col-md-12">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select" id="validationDefault04"id="status" name="status">
                            <option  @if ($role->status === 'active') selected @endif value="active">Active</option>
                            <option @if ($role->status === 'inactive') selected @endif value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
