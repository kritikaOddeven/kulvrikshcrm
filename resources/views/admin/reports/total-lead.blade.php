@extends('admin.layouts.app')
@section('pagetitle','Lead report | Kulvriksh')
@section('admin-content')
    <style>
        .select2-container--open {
            z-index: 999999 !important;
        }
    </style>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Total Lead Report</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                <li class="breadcrumb-item active">Total Lead Report</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <button class="btn btn-secondary mt-md-0" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="ri-equalizer-line"></i> Filter
            </button>

            @can('lead_report_export')
            <a href="{{ url('admin/reports/lead?export=csv') }}" type="button" class="btn btn-primary">
                <i class="ri-download-2-line"></i> Export to CSV
            </a>
            @endcan
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
                                <th>Ref. Id</th>
                                <th>Agent Name</th>
                                <th>Client Name</th>
                                <th>Caste</th>
                                <th>Date</th>
                                <th>Phone No.</th>
                                <th>Email Id</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Taluka</th>
                                <th>Village</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @include('components.filter-modal', [
        'id' => 'filterModal',
        'title' => 'Filter',
        'action' => url('admin/reports/lead'),
        'agents' => $agents,
        'countries' => $countries,
    ])


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            function getParam(name) {
                const url = new URL(window.location.href);
                return url.searchParams.get(name);
            }
            
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.reports.lead.datatable') }}',
                    data: function(d) {
                        d.agent_name = getParam('agent_name');
                        d.country = getParam('country');
                        d.state = getParam('state');
                        d.district = getParam('district');
                        d.city = getParam('city');
                        d.taluka = getParam('taluka');
                        d.village = getParam('village');
                        d.date_range = getParam('date_range');
                    }
                },
                columns: [
                    {
                        data: 'ref_id'
                    },
                    {
                        data: 'user.name',
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'client_name'
                    },
                    {
                        data: 'caste',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'created_date'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'country_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'state_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'district_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'city_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'taluka',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'village',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'status',
                        orderable: true,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
