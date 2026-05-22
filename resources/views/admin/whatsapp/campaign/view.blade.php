@extends('admin.layouts.app')
@section('pagetitle','View WhatsApp Campaign | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">View WhatsApp Campaign</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('admin/whatsapp/campaign') }}">Campaigns</a></li>
                <li class="breadcrumb-item active">View Campaign</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title mb-4">Campaign Details</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">Template:</th>
                                            <td>{{ $campaign->template->template_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Date:</th>
                                            <td>{{ $campaign->start_date ? \Carbon\Carbon::parse($campaign->start_date)->format('d-m-Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Time:</th>
                                            <td>{{ $campaign->start_time ? \Carbon\Carbon::parse($campaign->start_time)->format('H:i') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Recipients:</th>
                                            <td>{{ $campaign->total_person }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                <span class="badge bg-{{ $campaign->status == 'completed' ? 'success' : ($campaign->status == 'processing' ? 'warning' : ($campaign->status == 'failed' ? 'danger' : 'secondary')) }}">
                                                    {{ ucfirst($campaign->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At:</th>
                                            <td>{{ $campaign->created_at ? \Carbon\Carbon::parse($campaign->created_at)->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title mb-4">Template Details</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">Message Text:</th>
                                            <td>{!! nl2br(e($campaign->template->message_text ?? 'N/A')) !!}</td>
                                        </tr>
                                        @if($campaign->template->template_footer)
                                        <tr>
                                            <th>Template Footer:</th>
                                            <td>{!! nl2br(e($campaign->template->template_footer)) !!}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Message Logs -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="card-title mb-4">Message Logs</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Phone</th>
                                            <th>Person Name</th>
                                            <th>Type</th>
                                            <th>Relation</th>
                                            <th>Status</th>
                                            <th>Sent At</th>
                                            <th>Error Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($campaign->messageLogs as $log)
                                            <tr>
                                                <td>{{ $log->phone }}</td>
                                                <td>{{ $log->person_name }}</td>
                                                <td>{{ ucfirst($log->person_type) }}</td>
                                                <td>{{ $log->relation }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $log->status == 'sent' ? 'success' : ($log->status == 'failed' ? 'danger' : 'secondary') }}">
                                                        {{ ucfirst($log->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $log->sent_at ? \Carbon\Carbon::parse($log->sent_at)->format('d-m-Y H:i:s') : '-' }}</td>
                                                <td>{{ $log->error_message ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No message logs found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 