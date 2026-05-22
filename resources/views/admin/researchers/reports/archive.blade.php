@extends('admin.layouts.app')
@section('pagetitle', 'Archive Report | Kulvriksh')
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
            <h4 class="page-title">Researcher Report</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="">Researcher Report</a></li>
                <li class="breadcrumb-item active">Archive Report</li>
            </ol>
        </div>
    </div>


    <div class="row">
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
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        @foreach ($researchers as $report)
                            <tr>
                                @php
                                    $assign_researchers = getResearchersWithNames(json_decode($report->researcher_ids ?? '[]', true))['researchers'];
                                    $projectData = getProjectsWithNames('parent', json_decode($report->project_ids ?? '[]', true));

                                @endphp
                                <td>{{ $report->kulvrisk_id }}</td>
                                <td>{{ $report->lead->first_name ?? ''}} {{ $report->lead->middle_name ?? ''}} {{ $report->lead->last_name ?? ''}}</td>
                                <td>{{ $report->lead->email ?? '' }}</td>
                                <td>
                                    <div class="avatar-group avatar-list-stack">
                                        @foreach ($assign_researchers->take(3) as $data)
                                            <div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="{{ $data->name }}">
                                                {{ get_initials($data->name) }}
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
                                <td>{{ $report->start_date ?? '' }}</td>
                                <td>{{ $report->end_date ?? '' }}</td>
                                <td style="width: 150px">
                                    <div class="d-flex gap-2">
                                        @can('download_archive_report')
                                        <a href="{{ url('admin/research-reports/' . $report->id . '/restore') }}" class="btn-sm convert-icon-btn" title="Restore"><i class="ri-reset-left-line"></i></a>
                                        @endcan

                                        @can('view_archive_report')
                                        <a href="{{ url('admin/research-reports/view/' . $report->id) }}" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                        @endcan

                                        @can('delete_archive_report')
                                        <form action="{{ url('admin/research-reports/delete/' . $report->id . '?force=true') }}" method="POST" id="deleteForm_{{ $report->id }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Researcher Report" data-description="Are you sure you want to delete this Researcher Report ?" onclick="deleteAccount(this, {{ $report->id }})">
                                                <i class="ri-delete-bin-6-line"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
