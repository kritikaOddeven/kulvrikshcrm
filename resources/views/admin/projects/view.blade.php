@extends('admin.layouts.app')
@section('pagetitle','View Project | Kulvriksh')
@section('admin-content')
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View Projects</h4>
            {{-- <p>Agents/View All Agents</p> --}}
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{url('admin/projects')}}">Projects</a></li>
                <li class="breadcrumb-item active">View Projects</li>
            </ol>
        </div>
        <div class="col-auto">
            @can('add_sub_project')
                
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subproject">
                + Add Sub Project
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
                    <div class="view-project-details-box">
                        <table class="table info-table mb-0">
                            <tr>
                                <th>Project Name</th>
                                <td>{{ $project->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td class="text-wrap-400">{{ $project->description }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($project->status === 'active')
                                        <span class="active-btn">Active</span>
                                    @else
                                        <span class="inactive-btn">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table id="datatable" class="table table-responsive ">
                        <thead class="table-info">
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th style="width:150px" data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($subProject as $item)
                                <tr>
                                    <td>{{ $item->name ?? '' }}</td>
                                    <td class="text-wrap-400">{{ $item->description ?? '' }}</td>
                                    <td>{{ $item->amount ?? '' }}</td>
                                    <td>
                                        @if (isset($item->status) && $item->status === 'active')
                                            <span class="active-btn">Active</span>
                                        @else
                                            <span class="inactive-btn">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('edit_sub_project')
                                            <a data-value="{{ $item->id ?? '' }}" class="edit-icon-btn btn-sm btn-action mr-1 editbtn"><i class="ri-edit-line"></i></a>
                                            @endcan
                                            @can('delete_sub_project')
                                            <form action="{{ url('admin/projects/subproject/delete/' . $item->id) }}" method="POST" id="deleteForm_{{ $item->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Sub-Project" data-description="Are you sure you want to delete this sub-project?" onclick="deleteAccount(this, {{ $item->id }})">
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
                </div> <!-- end card-body -->
            </div>
        </div>
    </div>

    @include('admin.projects.subAddEditProject', ['project' => $project])
@endsection
