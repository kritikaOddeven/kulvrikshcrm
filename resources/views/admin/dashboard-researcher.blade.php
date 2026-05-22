@extends('admin.layouts.app')
@section('pagetitle', 'Researcher Dashboard | Kulvriksh')
@section('admin-content')

    <div class="py-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto mb-3 mb-md-0">
                <h4 class="page-title">Researcher Dashboard</h4>
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
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #90AFD0">
                            <i class="ri-user-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total Research</p>
                            <h3 class="total-number" style="--dsash-bg-color: #90AFD0">{{ $totalResearch ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #CA74FF">
                            <i class="ri-user-follow-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Running Research</p>
                            <h3 class="total-number" style="--dsash-bg-color: #CA74FF">{{ $runningResearch ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #5CC35C">
                            <i class="ri-user-heart-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Submitted Research</p>
                            <h3 class="total-number" style="--dsash-bg-color: #5CC35C">{{ $completeResearch ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #5CC35C">
                            <i class="ri-user-heart-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Joint Research Count</p>
                            <h3 class="total-number" style="--dsash-bg-color: #5CC35C">{{ $jointResearch ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Due Research</h5>
        </div>
        <div class="card-body card-body2">
            <table id="datatable" class="table">
                <thead class="table-light">
                    <tr>
                        <th>KV ID</th>
                        <th>Client Name</th>
                        <th>Researcher Name</th>
                        <th>Project Name</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th>Overdue</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        @php
                            $assign_researchers = getResearchersWithNames(json_decode($client->researcher_ids ?? '[]', true))['researchers'];
                            $projectData = getProjectsWithNames('parent', json_decode($client->project_ids ?? '[]', true));
                            $overdueDays = '';
                            if ($client->end_date) {
                                $endDate = \Carbon\Carbon::parse($client->end_date);
                                $today = \Carbon\Carbon::now();
                                if ($endDate->isPast()) {
                                    $overdueDays = abs((int) $today->diffInDays($endDate));
                                } else {
                                    $overdueDays = 0;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $client->kulvrisk_id }}</td>
                            <td>{{ $client->lead->first_name ?? '' }} {{ $client->lead->middle_name ?? ''}} {{ $client->lead->last_name ?? ''}}</td>
                            <td>
                                @foreach ($assign_researchers as $researcher)
                                    <span>{{ $researcher->name }}</span>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $projectData['names'] }}</td>
                            <td>{{ $client->start_date ? \Carbon\Carbon::parse($client->start_date)->format('m-d-Y') : '' }}</td>
                            <td>{{ $client->end_date ? \Carbon\Carbon::parse($client->end_date)->format('m-d-Y') : '' }}</td>
                            <td>{{ $overdueDays !== '' ? $overdueDays . ' Days' : '' }}</td>
                            <td>{{ $client->research_status == 'completed' ? 'Submitted' : ucfirst($client->research_status) }}</td>

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
