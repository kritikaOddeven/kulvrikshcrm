@extends('admin.layouts.app')
@section('pagetitle','Mail-Campaign | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Mail Campaign Details</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ url('admin/mass-email/campaign') }}">Mass Email</a></li>
                <li class="breadcrumb-item active">Mail Campaign Details</li>
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
                                <th>Campaign</th>
                                <th>Person Name</th>
                                <th>Relation</th>
                                <th>Email</th>
                                <th>Message Contact Mobile</th>
                                <th>Message</th>
                                <th data-orderable="false">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($emailLogs as $log)
                                <tr>
                                    <td>{{ $log->campaign->template->template_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($log->person_name)
                                            {{ $log->person_name }}
                                        @else
                                            {{ $log->client->lead->first_name ?? '' }} {{ $log->client->lead->middle_name ?? '' }} {{ $log->client->lead->last_name ?? '' }}
                                        @endif
                                    </td>
                                    <td>{{ $log->relation ?? 'Lead' }}</td>
                                    <td>{{ $log->email }}</td>
                                    <td>{{ $log->client->lead->phone ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $description = strip_tags($log->campaign->template->description ?? 'N/A');
                                            echo strlen($description) > 50 ? substr($description, 0, 50) . '...' : $description;
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'sent' => 'success',
                                                'failed' => 'danger'
                                            ][$log->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ ucfirst($log->status) }}</span>
                                        @if($log->error_message)
                                            <br>
                                            <small class="text-danger">{{ $log->error_message }}</small>
                                        @endif
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
