@extends('admin.layouts.app')
@section('pagetitle','WhatsApp Campaigns | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">WhatsApp Campaigns</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp</a></li>
                <li class="breadcrumb-item active">Campaigns</li>
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
                                <th>Template</th>
                                <th>Start Date</th>
                                <th>Start Time</th>
                                <th>Total Recipients</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($campaigns as $campaign)
                                <tr>
                                    <td>{{ $campaign->template->template_name ?? 'N/A' }}</td>
                                    <td>{{ $campaign->start_date ? \Carbon\Carbon::parse($campaign->start_date)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $campaign->start_time ? \Carbon\Carbon::parse($campaign->start_time)->format('H:i') : '-' }}</td>
                                    <td>{{ $campaign->total_person }}</td>
                                    <td>
                                        <span class="status-lead-btn {{ $campaign->status == 'completed' ? 'done-lead' : ($campaign->status == 'processing' ? 'high-lead' : ($campaign->status == 'failed' ? 'danger' : 'close-lead')) }}">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $campaign->created_at ? \Carbon\Carbon::parse($campaign->created_at)->format('d-m-Y H:i') : '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('admin/whatsapp/campaign/view/' . $campaign->id) }}" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                            {{-- <a href="{{ url('admin/whatsapp/campaign/edit/' . $campaign->id) }}" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a> --}}
                                            <form action="{{ url('admin/whatsapp/campaign/delete/' . $campaign->id) }}" method="POST" id="deleteForm_{{ $campaign->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete WhatsApp Campaign" data-description="Are you sure you want to delete this Campaign?" onclick="deleteAccount(this, {{ $campaign->id }})">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
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
@endsection 