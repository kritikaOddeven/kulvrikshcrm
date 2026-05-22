@extends('admin.layouts.app')
@section('pagetitle','Agent | Kulvriksh')
@section('admin-content')
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Agents</h4>
            {{-- <p>Agents/View All Agents</p> --}}
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Agents</a></li>
                <li class="breadcrumb-item active">View All Agents</li>
            </ol>
        </div>
        <div class="col-auto">
            @can('add_agent')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#exampleModalPopovers">
                    + Add Agent
                </button>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{-- Alert message --}}
            <x-alert />
            <div class="card">
                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive nowrap">
                        <thead class="table-info">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($agent as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone ?? 'N/A' }}</td>
                                    <td class="text-capitalize">{{ $item->roles->pluck('name')->first() }}</td>
                                    <td>
                                        @if ($item->status === 'active')
                                            <span class="active-btn">Active</span>
                                        @else
                                            <span class="inactive-btn">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('view_agent')
                                                <a href="{{ url('admin/agents/view/' . $item->id) }}" data-value="{{ $item->id }}" class="view-icon-btn btn-sm btn-action mr-1 view" data-bs-toggle="modal" data-bs-target="#viewModalPopovers{{ $item->id }}"><i class="ri-eye-line"></i></a>
                                            @endcan

                                            @can('edit_agent')
                                                <a data-value="{{ $item->id }}" class="edit-icon-btn btn-sm btn-action mr-1 editbtn"><i class="ri-edit-line"></i></a>
                                            @endcan

                                            @can('delete_agent')
                                                <form action="{{ url('admin/agents/delete/' . $item->id) }}" method="POST" id="deleteForm_{{ $item->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Agent" data-description="Are you sure you want to delete this agent? Deleting this agent will remove all related data." onclick="deleteAccount(this, {{ $item->id }})">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.agents.view_agent', ['agent' => $item])
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.agents.add_agent')
    @include('admin.agents.edit_agent')

    <script>
        $(document).ready(function() {
            // Password Match Validation
            function handlePasswordValidation(formSelector, passwordSelector, confirmPasswordSelector, errorSelector, submitBtnSelector) {
                $(formSelector).on('input', `${passwordSelector}, ${confirmPasswordSelector}`, function() {
                    const password = $(formSelector + ' ' + passwordSelector).val().trim();
                    const confirmPassword = $(formSelector + ' ' + confirmPasswordSelector).val().trim();
                    const $error = $(formSelector + ' ' + errorSelector);
                    const $submitBtn = $(formSelector + ' ' + submitBtnSelector);

                    if (!confirmPassword) {
                        $error.text('').hide();
                        $submitBtn.prop('disabled', true);
                        return;
                    }

                    if (password !== confirmPassword) {
                        $error.text('Passwords do not match').show();
                        $submitBtn.prop('disabled', true);
                    } else {
                        $error.text('').hide();
                        $submitBtn.prop('disabled', false);
                    }
                });
            }

            handlePasswordValidation(
                '#agentForm',
                '.password',
                '#confirm_password',
                '#password_error',
                '#agentAddSubmit'
            );

            handlePasswordValidation(
                '#agentEditForm',
                '.edit-password',
                '.confirm_password',
                '.password_error',
                '#agentEditSubmit'
            );

            // AJAX Form Submission (Both Create & Edit)
            $('#agentForm, #agentEditForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                let originalText = $submitBtn.text();

                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $form[0].reset();
                        $form.find('.text-danger').not('.req-star').text('');
                        $form.find('.password_error, #password_error').text('');

                        $('.modal').modal('hide');
                        // alert(response.message || 'Success!');

                        // Optionally reload or update UI here
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 5000,
                        }).then(() => {
                            location.reload(); // reloads the current page after alert is dismissed
                        });

                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        $form.find('.password_error, #password_error').text('');

                        if (errors) {
                            $.each(errors, function(field, messages) {
                                $form.find(`[name="${field}"]`).next('.text-danger').text(messages[0]);
                                if (field === 'password') {
                                    $form.find('.password_error, #password_error').text(messages[0]);
                                }
                            });
                        }
                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Populate Edit Modal via AJAX
            $('.editbtn').on('click', function() {
                const agentId = $(this).data('value');
                $('#editAgentModal').modal('show');

                $.ajax({
                    url: "{{ url('admin/agents/edit') }}/" + agentId,
                    type: 'GET',
                    success: function(response) {
                        $('#agent_id').val(response.id);
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#phone').val(response.phone);
                        $('#role').val(response.roles[0]?.name);
                        $('#status').val(response.status);
                    }
                });
            });
        });
    </script>
@endsection
