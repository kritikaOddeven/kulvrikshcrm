@extends('admin.layouts.app')
@section('pagetitle', 'Mail-Campaign | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Mail Campaign</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Mass Email</a></li>
                <li class="breadcrumb-item active">Mail Campaign</li>
            </ol>
        </div>
        {{-- <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampaignModal">
                + Add Mail Campaign
            </button>
        </div> --}}
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
                                <th>Template Name</th>
                                <th>Start Date</th>
                                <th>Start Time</th>
                                <th>Total Person</th>
                                <th>Status</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->template->template_name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                    <td>{{ $schedule->total_person }}</td>
                                    <td>
                                        @php
                                            $statusClass =
                                                [
                                                    'pending' => 'close-lead',
                                                    'running' => 'low-lead',
                                                    'complete' => 'done-lead',
                                                ][$schedule->status] ?? 'high-lead';
                                        @endphp
                                        <span class="status-lead-btn {{ $statusClass }}">{{ ucfirst($schedule->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('admin/mass-email/campaign/view/' . $schedule->id) }}" class="view-icon-btn btn-sm btn-action" data-bs-toggle="tooltip" title="View Details">
                                                <i class="ri-eye-line"></i>
                                            </a>

                                            @if($schedule->status === 'pending')
                                            <button type="button" class="edit-icon-btn btn-sm btn-action editbtn" data-value="{{ $schedule->id }}" data-bs-toggle="tooltip" title="Edit Campaign">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            @endif

                                            <form action="{{ url('admin/mass-email/campaign/delete/' . $schedule->id) }}" method="POST" id="deleteForm_{{ $schedule->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-icon-btn btn-sm btn-action" data-bs-toggle="tooltip" title="Delete Campaign" data-title="Delete Mail Campaign" data-description="Are you sure you want to delete this Mail Campaign?" onclick="deleteAccount(this, {{ $schedule->id }})">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                                {{-- <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $schedule->template->template_name ?? 'N/A' }}</span>
                                            <small class="text-muted">ID: {{ $schedule->template_id }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary rounded-pill me-2">{{ $schedule->total_person }}</span>
                                            <span>recipients</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass =
                                                [
                                                    'pending' => 'warning',
                                                    'running' => 'info',
                                                    'complete' => 'success',
                                                ][$schedule->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ ucfirst($schedule->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $schedule->created_at->format('d M Y') }}</span>
                                            <small class="text-muted">{{ $schedule->created_at->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td class="d-flex gap-2">
                                        <div class="d-flex gap-1">
                                            <a href="{{ url('admin/mass-email/campaign/view/' . $schedule->id) }}" class="view-icon-btn btn-sm btn-action" data-bs-toggle="tooltip" title="View Details">
                                                <i class="ri-eye-line"></i>
                                            </a>

                                            <button type="button" class="edit-icon-btn btn-sm btn-action editbtn" data-value="{{ $schedule->id }}" data-bs-toggle="tooltip" title="Edit Campaign">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                            <form action="{{ url('admin/mass-email/campaign/delete/' . $schedule->id) }}" method="POST" id="deleteForm_{{ $schedule->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-icon-btn btn-sm btn-action" data-bs-toggle="tooltip" title="Delete Campaign" data-title="Delete Mail Campaign" data-description="Are you sure you want to delete this Mail Campaign?" onclick="deleteAccount(this, {{ $schedule->id }})">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.mass-email.campaign.add-campaign')
    @include('admin.mass-email.campaign.edit-campaign')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // ✅ ADD campaign
            $('#addCampaignForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: '{{ route('admin.mass-email.campaign.store') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(res) {
                        $form[0].reset();
                        $form.find('.text-danger').not('.req-star').text('');
                        $('#addCampaignModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: res.message || 'Mail Campaign added successfully!',
                            timer: 5000,
                            confirmButtonText: 'OK',
                        }).then(() => location.reload());

                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        $.each(errors, function(field, message) {
                            $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                        });
                        $submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });

            // Edit button click handler
            $('.editbtn').on('click', function() {
                var id = $(this).data('value');
                $.ajax({
                    url: "{{ url('admin/mass-email/campaign/edit/') }}" + '/' + id,
                    type: 'GET',
                    success: function(response) {
                        
                        $('#id').val(response.id);
                        $('#template_id').val(response.template_id).trigger('change');
                        $('#start_date').val(response.start_date);
                        $('#start_time').val(response.start_time);
                        $('#status').val('pending');

                        // Initialize Flatpickr for date
                        const datePicker = flatpickr("#start_date", {
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            minDate: "today",
                            defaultDate: response.start_date,
                            onChange: function(selectedDates, dateStr) {
                                // Update time picker's min time when date changes
                                if (selectedDates[0].toDateString() === new Date().toDateString()) {
                                    timePicker.set('minTime', 'now');
                                } else {
                                    timePicker.set('minTime', '00:00');
                                }
                            }
                        });

                        // Initialize Flatpickr for time
                        const timePicker = flatpickr("#start_time", {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: true,
                            minTime: "now",
                            defaultHour: new Date(response.start_time).getHours(),
                            defaultMinute: new Date(response.start_time).getMinutes()
                        });

                        $('#editCampaignModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load campaign details.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // ✅ EDIT campaign
            $('#editCampaignForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                // Clear previous errors
                $form.find('.text-danger').not('.req-star').text('');

                // Validate date and time
                const selectedDate = $('#start_date').val();
                const selectedTime = $('#start_time').val();
                
                if (!selectedDate || !selectedTime) {
                    if (!selectedDate) {
                        $('#start_date_error').next('.text-danger').text('Please select a date.');
                    }
                    if (!selectedTime) {
                        $('#start_time_error').next('.text-danger').text('Please select a time.');
                    }
                    $submitBtn.prop('disabled', false).text('Save');
                    return;
                }

                // Combine date and time for validation
                const scheduledDateTime = new Date(selectedDate + 'T' + selectedTime);
                
                if (scheduledDateTime < new Date()) {
                    $('#start_date_error').text('Please select a future date.');
                    $('#start_time_error').text('Please select a future time.');
                    $submitBtn.prop('disabled', false).text('Save');
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.mass-email.campaign.update') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(res) {
                        $form[0].reset();
                        $form.find('.text-danger').not('.req-star').text('');
                        $('#editCampaignModal').modal('hide');

                        window.location.reload();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        
                        if (xhr.status === 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON.error || 'Only pending campaigns can be edited.',
                                confirmButtonText: 'OK'
                            });
                        } else if (errors) {
                            $.each(errors, function(field, message) {
                                $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while updating the campaign.',
                                confirmButtonText: 'OK'
                            });
                        }
                        $submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });
        });
    </script>
@endsection
