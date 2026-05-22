@extends('admin.layouts.app')
@section('pagetitle', 'Activity Logs | Kulvriksh')
@section('admin-content')
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View Activity Logs</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item active">View Activity Logs</li>
            </ol>
        </div>
        <div class="col-auto">
            @can('export_csv')
            <a href="{{ route('admin.logs.export') }}" class="btn btn-primary me-2">
                <i class="ri-download-2-line me-1"></i> Export To CSV
            </a>
            @endcan

            @if (auth()->user()?->hasRole('super-admin'))
                <button type="button" class="btn btn-danger" data-title="Clear Activity Logs" data-description="Are you sure you want to delete all activity logs? This action cannot be undone." onclick="confirmClearLogs(this)">
                    <i class="ri-delete-bin-line me-1"></i> Clear Logs
                </button>
            @endif

            <form method="POST" action="{{ route('admin.logs.clear') }}" id="deleteLogForm" style="display:none;">
                @csrf
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">

                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>Date & Time</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('m-d-Y, h:i A') }}</td>
                                    <td>{{ $log->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if (auth()->user()?->hasRole('super-admin'))
                                                <form action="{{ route('admin.logs.delete', $log->id) }}" method="POST" id="deleteForm_{{ $log->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-outline-danger me-1" data-title="Delete Log" data-description="Are you sure you want to delete this log?" onclick="deleteAccount(this, {{ $log->id }})">
                                                        <i class="ri-delete-bin-line fs-16"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="view-icon-btn btn-outline-dark" onclick="viewLogDetails({{ $log->id }})" title="View Details">
                                                <i class="ri-eye-line fs-16"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Log Details Modal -->
            <div class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logDetailsModalLabel">Log Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table info-table mb-0">
                                    <tr>
                                        <th width="200">Date & Time</th>
                                        <td id="modal-date"></td>
                                    </tr>
                                    <tr>
                                        <th>Agent Name</th>
                                        <td id="modal-agent"></td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td id="modal-description"></td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>
                                            <pre class="mb-0" id="modal-properties"></pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>IP Address</th>
                                        <td id="modal-ip_address"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function viewLogDetails(id) {
            // Show loading state

            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('logDetailsModal'));
            modal.show();

            // Fetch log details
            $.ajax({
                url: "{{ url('admin/logs/view') }}/" + id,
                type: 'GET',
                success: function(response) {
                    $('#modal-date').text(response.created_at);
                    $('#modal-agent').text(response.user ? response.user.name : 'Unknown');
                    $('#modal-description').text(response.description);
                    $('#modal-properties').text(response.role);
                    $('#modal-ip_address').text(response.ip_address);
                },
                error: function() {
                    $('#modal-date, #modal-agent, #modal-description, #modal-properties').html('<div class="text-danger">Error loading log details</div>');
                }
            });
        }
    </script>
@endsection
