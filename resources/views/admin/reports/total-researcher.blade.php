@extends('admin.layouts.app')
@section('pagetitle','Research Report | Kulvriksh')
@section('admin-content')
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Total Research Reort</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                <li class="breadcrumb-item active">Total Research Report</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            @can('researcher_report_export')
            <a href="{{ url('admin/reports/researcher?export=csv') }}" type="button" class="btn btn-primary">
                <i class="ri-download-2-line"></i> Export to CSV
            </a>
            @endcan
        </div>
    </div>

    <div class="row">
        {{-- Alert message --}}
        <x-alert />
        <div class="col-12">
            <form action="{{ url('admin/reports/researcher') }}" method="GET">
                <div class="report-filterbox">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="position-relative">
                                <input type="text" class="form-control flatpickr-input active" id="rangecalendar-datepicker" name="date_range" value="{{ request('date_range') }}" placeholder="From - To" readonly="readonly">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2">
                            <select class="form-select" name="client_id">
                                <option selected disabled>Select Client</option>
                                @foreach ($researchers as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->lead->first_name }} {{ $client->lead->middle_name }} {{ $client->lead->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-select" name="researcher_id">
                                <option selected disabled>Select Researcher</option>
                                @foreach ($researchersName as $researcher)
                                    <option value="{{ $researcher->id }}" {{ request('researcher_id') == $researcher->id ? 'selected' : '' }}>
                                        {{ $researcher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-2 text-end">
                            @if (request('date_range') || request('client_id') || request('researcher_id'))
                                <a href="{{ url('admin/reports/researcher') }}" class="btn btn-danger me-2">
                                    <i class="ri-filter-off-line me-1"></i> Clear Filters
                                </a>
                            @endif
                            <button type="submit" class="btn btn-success">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>KV ID</th>
                                <th>Client Name</th>
                                <th>Researcher Name</th>
                                <th>Project Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Overdue</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($researchers as $researcher)
                                <tr>
                                    @php
                                        $assign_researchers = getResearchersWithNames(json_decode($researcher->researcher_ids ?? '[]', true))['researchers'];
                                        $projectData = getProjectsWithNames('parent', json_decode($researcher->project_ids ?? '[]', true));
                                        // Calculate overdue days
                                        $overdueDays = '';
                                        if ($researcher->end_date) {
                                            $endDate = \Carbon\Carbon::parse($researcher->end_date);
                                            $today = \Carbon\Carbon::now();

                                            if ($endDate->isPast()) {
                                                $overdueDays = abs((int) $today->diffInDays($endDate));
                                            } else {
                                                $overdueDays = 0;
                                            }
                                        }
                                    @endphp
                                    <td>{{ $researcher->kulvrisk_id }}</td>
                                    <td>{{ $researcher->lead->first_name }} {{ $researcher->lead->middle_name }} {{ $researcher->lead->last_name }}</td>
                                    <td>
                                        <div>
                                            @foreach ($assign_researchers as $researcherName)
                                                <span class="me-2">{{ $researcherName->name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{ $projectData['names'] }}</td>
                                    <td>{{ $researcher->start_date ?? '' }}</td>
                                    <td>{{ $researcher->end_date ?? '' }}</td>
                                    <td>{{ $overdueDays !== '' ? $overdueDays . ' days' : '' }}</td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

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
