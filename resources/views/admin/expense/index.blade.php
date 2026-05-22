@extends('admin.layouts.app')
@section('pagetitle','Expense | Kulvriksh')
@section('admin-content')
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Expense</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Expense</a></li>
                <li class="breadcrumb-item active">View All Expenses</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            @can('add_expense')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpense">
                    + Add Expense
                </button>
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
                                <th>Subject</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Payment Mode</th>
                                <th>Amount</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($expenses as $item)
                                <tr>
                                    <td>{{ $item->subject }}</td>
                                    <td>{{ $item->expensesCategory->category }}</td>
                                    <td>{{ date('d M Y', strtotime($item->date)) }}</td>
                                    <td class="text-wrap-400">{{ $item->description }}</td>
                                    <td>{{ $item->payment_mode }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td style="width: 100px">
                                        <div class="d-flex gap-2">
                                            @can('edit_expense')
                                                <a data-value="{{ $item->id }}" class="edit-icon-btn btn-sm btn-action mr-1 editbtn"><i class="ri-edit-line"></i></a>
                                            @endcan

                                            @can('delete_expense')
                                                <form action="{{ url('admin/expenses/delete/' . $item->id) }}" method="POST" id="deleteForm_{{ $item->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Expense" data-description="Are you sure you want to delete this expense?" onclick="deleteAccount(this, {{ $item->id }})">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.expense.add')
    @include('admin.expense.edit')


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // ✅ ADD EXPENSE
            $('#addExpenseForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: '{{ route('admin.expenses.store') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(res) {
                        $form[0].reset();
                        $form.find('.text-danger').not('.req-star').text('');
                        $('#addExpense').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: res.message || 'Expense added successfully!',
                            timer: 5000,
                            confirmButtonText: 'OK',
                        }).then(() => location.reload());
                        
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        $.each(errors, function(field, message) {
                            console.log(field, message);
                            if (field === 'date') {
                                $form.find('.date-error').text(message[0]);
                            }else{
                                $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                            }
                        });
                        $submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });

            // ✅ EDIT EXPENSE
            $('#editExpenseForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: '{{ route('admin.expenses.update') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(res) {
                        $form[0].reset();
                        $form.find('.text-danger').not('.req-star').text('');
                        $('#editExpense').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: res.message || 'Expense updated successfully!',
                            timer: 5000,
                            confirmButtonText: 'OK',
                        }).then(() => location.reload());
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        
                        $.each(errors, function(field, message) {
                            if (field === 'date') {
                                $form.find('.date-error').text(message[0]);
                            }else{
                                $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                            }
                        });
                        $submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });
            
            $('.editbtn').on('click', function() {

                // console.log("Edit button clicked"); // Debug log
                var id = $(this).data('value');
                // console.log("Agent ID: ", id);
                $.ajax({
                    url: "{{ url('admin/expenses/edit/') }}" + '/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response)
                        $('#id').val(response.id);
                        $('#subject').val(response.subject);
                        $('#category_id').val(response.category_id);
                        $('#account_id').val(response.account_id);
                        $('#amount').val(response.amount);
                        $('#payment_mode').val(response.payment_mode);
                        $('.date').val(response.date);
                        // $('#description').val(response.description);
                        $('#description').text(response.description);

                        $('#status').val(response.status);
                    }
                });
                $('#editExpense').modal('show');

            });
        });
    </script>
@endsection
