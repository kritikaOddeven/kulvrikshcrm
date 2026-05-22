@extends('admin.layouts.app')
@section('pagetitle', 'Role | Kulvriksh')
@section('admin-content')
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Roles</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ url('admin/roles') }}">Roles</a></li>
                <li class="breadcrumb-item active">View All Roles</li>
            </ol>
        </div>
        <div class="col-auto">
            @can('add_role')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#role">
                    + Add Role
                </button>
            @endcan
        </div>
    </div>

    <div class="row">
        {{-- Alert message --}}
        <x-alert />
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>Role Name</th>
                                <th>Role Type</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 200px important!" data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="text-capitalize">{{ $role->name }}</td>
                                    <td>
                                        @php
                                            $roleClass = match ($role->role_type) {
                                                'agent' => 'high-lead',
                                                'researcher' => 'done-lead',
                                                'admin_team' => 'low-lead',
                                                'none' => 'default-lead',
                                            };
                                        @endphp

                                        <span class="status-lead-btn {{ $roleClass }}">
                                            {{ ucwords(str_replace('_', ' ', $role->role_type)) }}
                                        </span>

                                        {{-- @if ($role->role_type)
                                            <span class="status-lead-btn {{ $role->role_type === 'agent' ? 'high-lead' : 'done-lead' }}">
                                                {{ ucwords(str_replace('_', ' ', $role->role_type)) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif --}}
                                    </td>
                                    <td>{{ $role->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($role->status === 'active')
                                            <span class="active-btn">Active</span>
                                        @else
                                            <span class="inactive-btn">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('assign_permission')
                                                <a href="{{ url('admin/roles/permission/' . $role->id) }}" class="btn-sm view-icon-btn"><i class="ri-user-settings-line"></i></a>
                                            @endcan
                                            @can('edit_role')
                                                <button class="edit-icon-btn btn-sm btn-action mr-1" data-bs-toggle="modal" data-bs-target="#editRole{{ $role->id }}"><i class="ri-edit-line"></i></button>
                                            @endcan

                                            @can('delete_role')
                                                <form action="{{ url('admin/roles/' . $role->id) }}" method="POST" id="deleteForm_{{ $role->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Role" data-description="Are you sure you want to delete this Role ?" onclick="deleteAccount(this, {{ $role->id }})">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.role-permissions.edit', ['role' => $role])
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.role-permissions.add')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            // Handle Role Create
            $('#addRoleForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                let originalText = $submitBtn.text();


                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: '{{ route('admin.roles.store') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');

                        if (errors) {
                            $.each(errors, function(field, message) {
                                if (field == 'name') {
                                    $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                                }
                                if (field == 'role_type') {
                                    $form.find(`[name="${field}"]`).closest('.col-md-12').find('.text-danger').text(message[0]);
                                }
                            });
                        }

                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Handle Role Edit (Multiple dynamic forms)
            $('.editRoleForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let roleId = $form.data('role-id');
                let $submitBtn = $form.find('button[type="submit"]');
                let originalText = $submitBtn.text();

                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: `/admin/roles/${roleId}`,
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');

                        if (errors) {
                            $.each(errors, function(field, message) {
                                if (field == 'name') {
                                    $('.name-errorr' + roleId).text(message[0]);
                                }
                                if (field == 'role_type') {
                                    $('.role-type-errorr' + roleId).text(message[0]);
                                }
                            });
                        }

                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });

        });
    </script>
@endsection
