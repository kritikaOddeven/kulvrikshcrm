@extends('admin.layouts.app')
@section('pagetitle','Advertisement | Kulvriksh')
@section('admin-content')
<style>
    .choices__inner{
        background-color: #fff !important;
    }
</style>
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Advertisement</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp</a></li>
                <li class="breadcrumb-item active">Advertisement</li>
            </ol>
        </div>
        <div class="col-auto">
            <div class="d-flex justify-content-end align-items-center gap-2">
                @can('send_birthday_email')
                    <button id="openCampaignModal" class="btn btn-primary" disabled>Send Advertisement</button>
                @endcan
                <x-filter :countries="$countries" />
            </div>
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
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Name</th>
                                <th>Email Id</th>
                                <th>Phone Number</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-checkbox" 
                                               value="{{ $client->id }}" 
                                               data-email="{{ $client->email }}" 
                                               data-name="{{ $client->first_name . ' ' . $client->middle_name . ' ' . $client->last_name }}" 
                                               data-id="{{ $client->id }}" 
                                               data-type="client" 
                                               data-relation="Client">
                                    </td>
                                    <td>{{ $client->first_name . ' ' . $client->middle_name . ' ' . $client->last_name }}</td>
                                    <td>{{ $client->email ?? '-' }}</td>
                                    <td>{{ $client->phone ?? '-' }}</td>
                                    <td>{{ $client->countries->name ?? '-' }}</td>
                                    <td>{{ $client->states->name ?? '-' }}</td>
                                    <td>{{ $client->cities->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Advertisement Campaign Modal -->
    <div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="advertisementCampaignForm" method="POST" action="{{ route('admin.mass-email.advertisements.send') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="campaignModalLabel">Send Advertisement Campaign</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="template_id" class="form-label">Template</label>
                            <select class="form-select" id="template_id" name="template_id" required>
                                <option value="">Select Template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->template_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="text" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="text" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <div class="alert alert-info">
                                <strong>Selected Recipients:</strong> <span id="selectedCount">0</span>
                                <br>
                                <small class="text-muted">Maximum 10 emails will be sent per campaign.</small>
                            </div>
                        </div>
                        <input type="hidden" name="selected_emails" id="selected_emails">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Advertisement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all functionality
            const selectAll = document.getElementById('select-all');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    let checked = this.checked;
                    document.querySelectorAll('.row-checkbox').forEach(cb => {
                        cb.checked = checked;
                    });
                    updateSelectedCount();
                    toggleSendButton();
                });
            }
            
            // Enable/disable Send button based on selection
            document.querySelectorAll('.row-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    updateSelectedCount();
                    toggleSendButton();
                });
            });

            function updateSelectedCount() {
                const count = document.querySelectorAll('.row-checkbox:checked').length;
                document.getElementById('selectedCount').textContent = count;
            }

            function toggleSendButton() {
                let anyChecked = Array.from(document.querySelectorAll('.row-checkbox')).some(cb => cb.checked);
                let sendBtn = document.getElementById('openCampaignModal');
                if (sendBtn) sendBtn.disabled = !anyChecked;
            }
            
            toggleSendButton();
            updateSelectedCount();

            // Open modal on Send button click
            document.getElementById('openCampaignModal')?.addEventListener('click', function() {
                let campaignModal = new bootstrap.Modal(document.getElementById('campaignModal'));
                campaignModal.show();
            });

            // Initialize Flatpickr for date
            const datePicker = flatpickr("#start_date", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: "today",
                defaultDate: "today"
            });

            // Initialize Flatpickr for time
            const timePicker = flatpickr("#start_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                defaultHour: new Date().getHours(),
                defaultMinute: new Date().getMinutes() + 5
            });

            // Handle form submit
            document.getElementById('advertisementCampaignForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Collect selected emails
                let selectedEmails = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                    .map(cb => ({
                        email: cb.getAttribute('data-email'),
                        name: cb.getAttribute('data-name') || '',
                        id: cb.getAttribute('data-id') || '',
                        type: cb.getAttribute('data-type') || 'client',
                        relation: cb.getAttribute('data-relation') || 'Client'
                    }));

                if (selectedEmails.length === 0) {
                    alert('Please select at least one recipient.');
                    return;
                }

                // Set the hidden field with selected emails
                document.getElementById('selected_emails').value = JSON.stringify(selectedEmails);
                
                // Submit the form
                this.submit();
            });
        });
    </script>
@endsection 