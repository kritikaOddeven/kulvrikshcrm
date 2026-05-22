@extends('admin.layouts.app')
@section('pagetitle', 'Researcher | Kulvriksh')
@section('admin-content')
    <style>
        .avatar-list-stack {
            display: flex;
            align-items: center;
        }

        .avatar-list-stack .avatar {
            border: 2px solid #fff;
            z-index: 1;
            position: relative;
        }

        .avatar-list-stack .avatar:first-child {
            margin-left: 0;
        }

        .avatar-list-stack .avatar.more {
            background-color: #3394df;
            color: #fff;
        }
    </style>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Researcher</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">View All Researchers</li>
            </ol>
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
                                <th>KV ID</th>
                                <th>Client Name</th>
                                <th>Email Id</th>
                                <th>Researcher Name</th>
                                <th>Project Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($researchers as $researcher)
                                <tr>
                                    @php
                                        $assign_researchers = getResearchersWithNames(json_decode($researcher->researcher_ids ?? '[]', true))['researchers'];
                                        $projectData = getProjectsWithNames('parent', json_decode($researcher->project_ids ?? '[]', true));

                                    @endphp
                                    <td>{{ $researcher->kulvrisk_id }}</td>
                                    <td>{{ $researcher->lead->first_name ?? '' }} {{ $researcher->lead->middle_name ?? '' }} {{ $researcher->lead->last_name ?? '' }}</td>
                                    <td>{{ $researcher->lead->email ?? '' }}</td>
                                    <td>
                                        <div class="avatar-group avatar-list-stack">
                                            @foreach ($assign_researchers->take(3) as $item)
                                                <div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="{{ $item->name }}">
                                                    {{ get_initials($item->name) }}
                                                </div>
                                            @endforeach

                                            @if ($assign_researchers->count() > 3)
                                                <div class="avatar avatar-xs rounded-circle d-inline-flex align-items-center justify-content-center more" style="width: 32px; height: 32px; font-size: 12px;">
                                                    +{{ $assign_researchers->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $projectData['names'] }}</td>
                                    <td>{{ $researcher->start_date ?? '' }}</td>
                                    <td>{{ $researcher->end_date ?? '' }}</td>
                                    @php
                                        $statusClass = match ($researcher->research_status) {
                                            'running' => 'high-lead',
                                            'pending' => 'low-lead',
                                            default => 'done-lead',
                                        };
                                    @endphp
                                    <td>
                                        {{-- <a class="status-lead-btn  {{ $statusClass }}" @if ($researcher->research_status == 'running') data-value="{{ $researcher->id }}" data-bs-toggle="modal" data-bs-target=".research-status-modal-{{ $researcher->id }}" @endif>
                                            {{ $researcher->research_status ?? '' }} @if ($researcher->research_status == 'running')
                                                <i class="ri-edit-line"></i>
                                            @endif
                                        </a> --}}
                                        <a class="status-lead-btn {{ $statusClass }}" @if ($researcher->research_status == 'running') data-value="{{ $researcher->id }}" data-bs-toggle="modal" data-bs-target=".research-status-modal-{{ $researcher->id }}" @endif>
                                            {{ $researcher->research_status == 'completed' ? 'Submitted' : ucfirst($researcher->research_status) }}

                                            @if ($researcher->research_status == 'running')
                                                <i class="ri-edit-line"></i>
                                            @endif
                                        </a>

                                    </td>


                                    {{-- <td class="text-capitalize">{{ $researcher->research_status ?? '' }}</td> --}}
                                    <td style="width: 150px">
                                        <div class="d-flex gap-2">
                                            @can('view_researcher')
                                                <a href="{{ url('admin/researcher/view/' . $researcher->id) }}" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                            @endcan

                                            @can('researcher_edit_client')
                                                <a href="{{ url('admin/clients/edit/' . $researcher->id) }}" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a>
                                            @endcan

                                            @can('delete_researcher')
                                                <form action="{{ url('admin/researcher/delete/' . $researcher->id) }}" method="POST" id="deleteForm_{{ $researcher->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Researcher" data-description="Are you sure you want to delete this Researcher ?" onclick="deleteAccount(this, {{ $researcher->id }})">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.researchers.modals.status-update', ['researchers' => $researcher])
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
