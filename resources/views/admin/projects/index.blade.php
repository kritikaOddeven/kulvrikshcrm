@extends('admin.layouts.app')
@section('pagetitle','projects | Kulvriksh')
@section('admin-content')
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Projects</h4>
            {{-- <p>Agents/View All Agents</p> --}}
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{url('admin/projects')}}">Projects</a></li>
                <li class="breadcrumb-item active">View All Projects</li>
            </ol>
        </div>
        <div class="col-auto">

            @can('add_project')
            <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#projectAddModal">
                + Add Project
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
                                <th style="width: 180px important!">Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 200px important!" data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($projects as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-wrap-400">{{ $item->description }}</td>
                                    <td>
                                        @if ($item->status === 'active')
                                            <span class="active-btn">Active</span>
                                        @else
                                            <span class="inactive-btn">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('view_project')
                                            <a href="{{ url('admin/projects/view/' . $item->id) }}" class="view-icon-btn btn-sm btn-action mr-1"  title="view" ><i class="ri-eye-line"></i></a>
                                            @endcan

                                            @can('edit_project')
                                            <a data-value="{{ $item->id }}" class="edit-icon-btn btn-sm btn-action mr-1 editbtn" ><i class="ri-edit-line"></i></a>
                                            @endcan
                                            
                                            @can('delete_project')
                                            <form action="{{ url('admin/projects/delete/' . $item->id) }}" method="POST" id="deleteForm_{{$item->id}}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Project" data-description="Are you sure you want to delete this project?" onclick="deleteAccount(this, {{ $item->id }})">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.projects.add')
    @include('admin.projects.edit')
    <script>
        // Common form submission handler for both add and edit forms
        $('#projectAddForm, #editProjectForm').on('submit', function(e) {
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
                    $('.modal').modal('hide');
    
                    Swal.fire({
                        title: 'Success!',
                        text: response.message || 'Project saved successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 5000,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    $form.find('.text-danger').not('.req-star').text('');
    
                    if (errors) {
                        $.each(errors, function(field, messages) {
                            $form.find(`[name="${field}"]`).next('.text-danger').text(messages[0]);
                        });
                    }
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    
        // Edit button click handler
        $('.editbtn').on('click', function() {
            $('#editProjectModal').modal('show');
    
            var project_id = $(this).data('value');
            $.ajax({
                url: "{{ url('admin/projects/edit/') }}" + '/' + project_id,
                type: 'GET',
                success: function(response) {
                    $('#project_id').val(response.id);
                    $('#name').val(response.name);
                    $('#description').val(response.description);
                    $('#status').val(response.status);
                }
            });
        });
    </script>
   
@endsection

