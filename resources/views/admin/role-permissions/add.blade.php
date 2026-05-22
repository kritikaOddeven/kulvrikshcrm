<style>
    .form-check-input{
        width: 20px !important;
        height: 20px !important;
        margin-top: 0 !important;
    }
</style>
<div class="modal fade" id="role" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addRoleForm" action="{{route('admin.roles.store')}}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label for="validationDefault01" class="form-label">Role Name<x-required-star /></label>
                        <input type="text" class="form-control" value="" name="name">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label">Role Type<x-required-star /></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_agent" value="agent" checked>
                                <label class="form-check-label" for="role_type_agent">
                                    Agent
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_researcher" value="researcher">
                                <label class="form-check-label" for="role_type_researcher">
                                    Researcher
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_admin_team" value="admin_team">
                                <label class="form-check-label" for="role_type_admin_team">
                                    Admin Team
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_none" value="none">
                                <label class="form-check-label" for="role_type_none">
                                    None
                                </label>
                            </div>
                        </div>
                        <span class="text-danger">@error('role_type'){{ $message }}@enderror</span>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select"  name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>

