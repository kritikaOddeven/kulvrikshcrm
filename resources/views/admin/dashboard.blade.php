@extends('admin.layouts.app')
@section('pagetitle', 'Dashboard | Kulvriksh')
@section('admin-content')


    <div class="py-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto mb-3 mb-md-0">
                <h4 class="page-title">Dashboard</h4>
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
    @if($smtpAlert)
        <x-smtp-alert />
    @endif

    <!-- Bank Account Configuration Alert -->
    @if($bankingAlert)
        <x-account-alert />
    @endif

    <!-- IMAP Configuration Alert -->
    @if(!auth()->user()->hasImapConfigured())
        <x-imap-alert />
    @endif

    <!-- Start Main Widgets -->
    <div class="row dash-row">

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #90AFD0">
                            <i class="ri-user-settings-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Agent</p>
                            <h3 class="total-number" style="--dsash-bg-color: #90AFD0">{{ $data['agent'] }}</h3>
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
                            <i class="ri-user-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Client</p>
                            <h3 class="total-number" style="--dsash-bg-color: #CA74FF">{{ $data['client'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #F8D347">
                            <i class="ri-user-follow-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #F8D347">{{ $data['lead'] }}</h3>
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
                            <i class="ri-user-follow-fill"></i>
                        </span>

                        <div>
                            <p class="total-title">Lead To Client</p>
                            <h3 class="total-number" style="--dsash-bg-color: #FFA500">{{ $data['leadClient'] }}</h3>
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
                            <i class="ri-money-dollar-circle-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Monthly Income</p>
                            <h3 class="total-number" style="--dsash-bg-color: #5CC35C">₹ <span class="total-number">{{ $data['income'] }}</span></h3>
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
                            <i class="ri-money-dollar-box-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Monthly Expense</p>
                            <h3 class="total-number" style="--dsash-bg-color: #FF6C60">₹ <span class="total-number">{{ number_format($data['expense'], 2) }}</span></h3>
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
                            <i class="ri-message-2-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Research Submitted</p>
                            <h3 class="total-number" style="--dsash-bg-color: #57C8F2">{{ $data['completed_status'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #6CCAC9">
                            <i class="ri-message-3-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Research Running</p>
                            <h3 class="total-number" style="--dsash-bg-color: #6CCAC9">{{$data['running_status']}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #1E89C8">
                            <i class="ri-vip-crown-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Paid User</p>
                            <h3 class="total-number" style="--dsash-bg-color: #1E89C8">{{ $data['paid'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #E58E95">
                            <i class="ri-user-unfollow-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Unpaid User</p>
                            <h3 class="total-number" style="--dsash-bg-color: #E58E95">{{ $data['lead'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #90AFD0">
                            <i class="ri-mail-send-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Email Sent</p>
                            <h3 class="total-number" style="--dsash-bg-color: #90AFD0">0</h3>
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
                            <i class="ri-whatsapp-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Whatsapp Message Sent</p>
                            <h3 class="total-number" style="--dsash-bg-color: #CA74FF">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Main Widgets -->

    <div class="row">
        <!-- Income & Expense -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">Income & Expense</h5>
                    </div>
                </div>
                <div class="pad-15">
                    <div style="height: 400px;">
                        <canvas id="incomeExpenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid & Unpaid Users -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">Paid & Unpaid Users</h5>
                    </div>
                </div>
                <div class="pad-15">
                    <div style="height: 400px;">
                        @if ($data['paid'] == 0 && $data['lead'] == 0)
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <h5 class="text-muted mb-0">No Data Found</h5>
                            </div>
                        @else
                            <canvas id="paidUnpaidChart"></canvas>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Due Research Table -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Due Research</h5>
        </div>
        <div class="card-body card-body2 table-responsive">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['latestResearchers'] as $client)
                        @php
                            $assign_researchers = getResearchersWithNames(json_decode($client->researcher_ids ?? '[]', true))['researchers'];
                            $projectData = getProjectsWithNames('parent', json_decode($client->project_ids ?? '[]', true));
                            // Calculate overdue days
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
                                <div>
                                    @foreach ($assign_researchers as $researcher)
                                        <span class="me-2">{{ $researcher->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ $projectData['names'] }}</td>
                            <td>{{ $client->start_date ? \Carbon\Carbon::parse($client->start_date)->format('m-d-Y') : '' }}</td>
                            <td>{{ $client->end_date ? \Carbon\Carbon::parse($client->end_date)->format('m-d-Y') : '' }}</td>
                            <td>{{ $overdueDays !== '' ? $overdueDays . ' Days' : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Income & Expense Bar Chart
        const incomeData = @json($data['incomeData']);
        const expenseData = @json($data['expenseData']);

        const incomeExpenseCtx = document.getElementById('incomeExpenseChart').getContext('2d');
        new Chart(incomeExpenseCtx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ],
                datasets: [{
                        label: 'Income',
                        data: incomeData,
                        backgroundColor: 'rgba(46, 204, 113, 0.8)',
                        borderColor: 'rgba(46, 204, 113, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    },
                    {
                        label: 'Expense',
                        data: expenseData,
                        backgroundColor: 'rgba(231, 76, 60, 0.8)',
                        borderColor: 'rgba(231, 76, 60, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ₹${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });


        // Paid & Unpaid Users Doughnut Chart
        
        @if ($data['paid'] != 0 || $data['lead'] != 0)

            const paidUsers = @json($data['paid']);
            const unpaidUsers = @json($data['lead']);
            const totalUsers = paidUsers + unpaidUsers;

            const paidUnpaidCtx = document.getElementById('paidUnpaidChart').getContext('2d');
            new Chart(paidUnpaidCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Paid', 'Unpaid'],
                    datasets: [{
                        data: [paidUsers, unpaidUsers],
                        backgroundColor: [
                            'rgba(52, 152, 219, 0.8)',
                            'rgba(241, 148, 138, 0.8)'
                        ],
                        borderColor: [
                            'rgba(52, 152, 219, 1)',
                            'rgba(241, 148, 138, 1)'
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percent = ((value / totalUsers) * 100).toFixed(1);
                                    return `${context.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });
    </script>
    @endif

    </script>

@endsection
