@extends('admin.layouts.app')
@section('pagetitle','Permission | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Permission</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ url('admin/roles') }}">Roles</a></li>
                <li class="breadcrumb-item active">View All Permission</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <x-alert />
            <form action="{{ url('admin/roles/assign-permissions') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-end gap-2 justify-content-between">
                            <div class="col-md-6">
                                <label for="role_name" class="form-label">Role</label>
                                <input type="text" disabled class="form-control" name="role_name" id="role_name" value="{{ $role->name }}">
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                            </div>

                            <div class="col-auto text-end">
                                <a href="{{ url('admin/roles') }}" type="button" class="btn btn-secondary me-2">Close</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row card-body">
                        <div class="col-md-12">
                            <div class="">
                                <label for="exampleFormControlInput1" class="form-label">Role</label>
                                <input type="text" disabled class="form-control" name="role_name" value="{{ $role->name }}">
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-body pb-0">
                        @php
                            use Spatie\Permission\Models\Permission;

                            // Get all permissions grouped by section
                            $groupedPermissions = Permission::all()->groupBy('section');
                        @endphp

                        @foreach ($groupedPermissions as $section => $permissions)
                            @php
                                $moduleKey = str_replace(' ', '_', strtolower($section)); // Normalize to match data-module
                                
                                $permissionNames = $permissions->pluck('name')->toArray();
                                $allSelected = collect($permissionNames)->every(fn($permName) => $role->hasPermissionTo($permName));
                            @endphp

                            <ul class="list-group mb-3">
                                <li class="list-group-item role-box" aria-current="true">
                                    <p class="role-title">{{ ucwords(str_replace('_', ' ', $section)) }}</p>
                                    <div class="form-check form-switch m-0 align-items-center">
                                        <label class="ps-2" for="select_all_{{ $moduleKey }}">Select All</label>
                                        <input type="checkbox" id="select_all_{{ $moduleKey }}" class="form-check-input check-all m-0" data-module="{{ $moduleKey }}" {{ $allSelected ? 'checked' : '' }}>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-auto">
                                                <div class="role-module-box">
                                                    <p class="control-label">{{ str_replace('_', ' ', $permission->name) }}</p>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} data-module="{{ $moduleKey }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        @endforeach
                    </div>

                    <div class="card-footer d-flex justify-content-between pt-0">
                        <a href="{{ url('admin/roles') }}" type="button" class="btn btn-secondary">Close</a>
                        <button type="submit" class="btn btn-primary">Save </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle "All" toggle
            document.querySelectorAll('.check-all').forEach(function(allToggle) {
                const module = allToggle.getAttribute('data-module');
                const checkboxes = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);

                allToggle.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = allToggle.checked);
                });

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        const allChecked = Array.from(checkboxes).every(i => i.checked);
                        allToggle.checked = allChecked;
                    });
                });
            });
        });
    </script>
@endsection
