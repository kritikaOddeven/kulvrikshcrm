@extends('admin.layouts.app')
@section('pagetitle', 'Agent Dashboard | Kulvriksh')
@section('admin-content')
    <div class="py-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto mb-3 mb-md-0">
                <h4 class="page-title">Agent Dashboard</h4>
            </div>
            <div class="col-auto">
                <form method="GET" class="d-flex flex-wrap gap-2 justify-content-end">
                    <div class="position-relative">
                        <input type="text" class="form-control flatpickr-input active dash-input-filter" id="rangecalendar-datepicker" name="date_range" value="{{ request('date_range') }}" placeholder="From - To" readonly="readonly">
                        <i class="ri-calendar-2-line calendar-icon position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%);"></i>
                    </div>

                    <div class="d-flex align-items-end">
                        @if (request('date_range'))
                            <a href="{{ url('admin/dashboard') }}" class="btn btn-danger">
                                <i class="ri-filter-off-line me-1"></i> Clear Filters
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="ri-filter-3-line me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- SMTP Configuration Alert -->
    @if($smtpAlert && auth()->user()->hasPermissionTo('smtp_setup'))
        <x-smtp-alert />
    @endif

    <!-- Bank Account Configuration Alert -->
    @if($bankingAlert)
        <x-account-alert />
    @endif

    <!-- IMAP Configuration Alert -->
    @if(!auth()->user()->hasImapConfigured() && auth()->user()->hasPermissionTo('imap_setup'))
        <x-imap-alert />
    @endif
    
    <div class="row dash-row">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #90AFD0">
                            <i class="ri-user-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #90AFD0">{{ $totalLead ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #CA74FF">
                            <i class="ri-user-follow-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total Convert Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #CA74FF">{{ $totalConvertLead ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #FF6C60">
                            <i class="ri-user-unfollow-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total Low Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #FF6C60">{{ $totalLowLead ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #FFA500">
                            <i class="ri-user-star-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total High Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #FFA500">{{ $totalHighLead ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #5CC35C">
                            <i class="ri-user-heart-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total Done Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #5CC35C">{{ $totalDoneLead ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #57C8F2">
                            <i class="ri-group-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total Joint Convert Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #57C8F2">{{ $totalJointConvertLead ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4 p-lg-3">
        <div class="card-body card-body2 table-responsive">
            <table id="datatable" class="table">
                <thead class="table-light">
                    <tr>
                        <th>Ref ID</th>
                        <th>Agent Name</th>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Phone No.</th>
                        <th>Email Id</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>District</th>
                        <th>City</th>
                        <th>Taluka</th>
                        <th>Village</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leads as $lead)
                        <tr>
                            <td>REF00{{ $lead->id }}</td>
                            <td>{{ $lead->user->name ?? '-' }}</td>
                            <td>{{ $lead->first_name }} {{ $lead->middle_name }} {{ $lead->last_name }}</td>
                            <td>{{ $lead->created_at->format('d M Y') }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->email }}</td>
                            <td>{{ $lead->countries->name ?? '-' }}</td>
                            <td>{{ $lead->states->name ?? '-' }}</td>
                            <td>{{ $lead->districts->name ?? '-' }}</td>
                            <td>{{ $lead->cities->name ?? '-' }}</td>
                            <td>{{ $lead->taluka ?? '-' }}</td>
                            <td>{{ $lead->village ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr("#rangecalendar-datepicker", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "Y-m-d to Y-m-d",
                    allowInput: true
                });
            });
        </script>
    @endpush
@endsection
