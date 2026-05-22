@extends('admin.layouts.app')
@section('pagetitle','Campagim-Details | Kulvriksh')
@section('admin-content')
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Campaign Details</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.mass-email.campaign.list') }}">Mail Campaign</a></li>
                <li class="breadcrumb-item active">View Campaign</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <a href="{{ route('admin.mass-email.campaign.list') }}" class="btn btn-secondary">
                <i class="ri-arrow-left-line me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Campaign Information -->
                        <div class="col-md-6">
                            <h5 class="card-title mb-4">Campaign Information</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">Template Name:</th>
                                            <td>{{ $campaign->template->template_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Date:</th>
                                            <td>{{ \Carbon\Carbon::parse($campaign->start_date)->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Time:</th>
                                            <td>{{ \Carbon\Carbon::parse($campaign->start_time)->format('h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Recipients:</th>
                                            <td>
                                                <span class="badge bg-primary rounded-pill">{{ $campaign->total_person }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                @php
                                                    $statusClass = [
                                                        'pending' => 'warning',
                                                        'running' => 'info',
                                                        'complete' => 'success'
                                                    ][$campaign->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($campaign->status) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At:</th>
                                            <td>{{ $campaign->created_at->format('d M Y h:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Template Details -->
                        <div class="col-md-6">
                            <h5 class="card-title mb-4">Template Details</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="200">Subject:</th>
                                            <td>{{ $campaign->template->subject ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description:</th>
                                            <td>{!! $campaign->template->description ?? 'N/A' !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recipients List -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="card-title mb-4">Recipients List</h5>
                            @if(!empty($selectedEmails))
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($selectedEmails as $index => $recipient)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $recipient['name'] ?? 'N/A' }}</td>
                                                    <td>{{ $recipient['email'] ?? 'N/A' }}</td>
                                                    <td>{{ $recipient['id'] ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="ri-information-line me-2"></i>
                                    No recipients have been added to this campaign yet.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
