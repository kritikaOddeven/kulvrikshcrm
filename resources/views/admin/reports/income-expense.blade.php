@extends('admin.layouts.app')
@section('pagetitle', 'Income-Expense Report | Kulvriksh')
@section('admin-content')
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Income Expense Report</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                <li class="breadcrumb-item active">Income Expense Report</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            @can('income_expense_report_export')
                <a href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}" type="button" class="btn btn-primary"><i class="ri-download-2-line"></i> Export To CSV</a>
            @endcan
        </div>
    </div>

    <div class="row">
        {{-- Alert message --}}
        <x-alert />
        <div class="col-12">
            <form action="{{ url('admin/reports/income-expense') }}" method="GET">
                <div class="report-filterbox">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8">
                            <div class="row">

                                <div class="col-md-4 mb-2">
                                    <div class="position-relative">
                                        <input type="text" class="form-control flatpickr-input active" id="rangecalendar-datepicker" name="date_range" placeholder="From - To" readonly="readonly" value="{{ request('date_range') }}">
                                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                        <i class="ri-calendar-2-line calendar-icon"></i>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <select class="form-select" name="type" id="transaction-type">
                                        <option value="">All Transactions</option>
                                        <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Credit</option>
                                        <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>Debit</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-2" id="category-filter" style="display: none;">
                                    <select class="form-select" name="category_id">
                                        <option value="">All Categories</option>
                                        @foreach ($expenseCategories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2 text-end" id="filter-buttons">
                            @if (request('date_range') || request('type') || request('category_id'))
                                <a href="{{ url('admin/reports/income-expense') }}" class="btn btn-danger mb-2">
                                    <i class="ri-filter-off-line me-1"></i> Clear Filters
                                </a>
                            @endif
                            <button type="submit" class="btn btn-success mb-2 ms-2">
                                <i class="ri-file-list-3-line me-1"></i> Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>Opening Balance</p>
                        <p class="text-end"><strong>₹{{$account->opening_balance ?? ''}}</strong></p>
                        
                    </div>

                </div>
                <div class="card-body card-body2">
                    <div class="table-responsive">
                        <table id="datatable" class="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-info">
                                <tr>
                                    <th>Date</th>
                                    <th class="text-wrap-400">Description</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction['date']->format('d M Y') }}</td>
                                        <td class="text-wrap-400">{{ $transaction['description'] }}</td>
                                        <td>₹{{ number_format($transaction['credit'], 2) }}</td>
                                        <td>₹{{ number_format($transaction['debit'], 2) }}</td>
                                        <td>₹{{ number_format($transaction['total_amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionType = document.getElementById('transaction-type');
            const categoryFilter = document.getElementById('category-filter');

            // Function to toggle category filter visibility
            function toggleCategoryFilter() {
                if (transactionType.value === 'debit') {
                    categoryFilter.style.display = 'block';
                } else {
                    categoryFilter.style.display = 'none';
                    // Clear category selection when hidden
                    categoryFilter.querySelector('select').value = '';
                }
            }

            // Initial check
            toggleCategoryFilter();

            // Listen for changes
            transactionType.addEventListener('change', toggleCategoryFilter);
        });
    </script>
@endsection
