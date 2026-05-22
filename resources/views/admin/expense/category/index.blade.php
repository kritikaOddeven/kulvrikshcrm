@extends('admin.layouts.app')
@section('pagetitle','Expense Category| Kulvriksh')
@section('admin-content')
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Expense Category</h4>
            {{-- <p>Agents/View All Agents</p> --}}
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Category</a></li>
                <li class="breadcrumb-item active">View All Category</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">

            @can('add_expense_category')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expense">
                    + Add Category
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
                                <th style="width: 180px important!">Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 200px important!" data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($expense as $item)
                                <tr>
                                    <td>{{ $item->category }}</td>
                                    <td class="text-wrap-400">{{ $item->description }}</td>
                                    <td>
                                        @if ($item->status === 'active')
                                            <span class="active-btn">Active</span>
                                        @else
                                            <span class="inactive-btn">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('edit_expense_category')
                                                <a data-value="{{ $item->id }}" class="edit-icon-btn btn-sm btn-action mr-1 editbtn"><i class="ri-edit-line"></i></a>
                                            @endcan

                                            @can('delete_expense_category')
                                                <form action="{{ url('admin/expenses/category/delete/' . $item->id) }}" method="POST" id="deleteForm_{{ $item->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Expense Category" data-description="Are you sure you want to delete this expense category?" onclick="deleteAccount(this, {{ $item->id }})">
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

    @include('admin.expense.category.add-edit')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // 🟢 Add Expense Form
            $('#addExpenseForm').on('submit', function(e) {
                e.preventDefault();
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $form[0].reset();
                        $('#expense').modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Added successfully!',
                            icon: 'success',
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

            // 🟢 Edit Expense Form
            $('#editExpenseForm').on('submit', function(e) {
                e.preventDefault();
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $form[0].reset();
                        $('#editCatExpense').modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Updated successfully!',
                            icon: 'success',
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

            // 🟢 Edit Button Click
            $('.editbtn').on('click', function() {
                const expense_id = $(this).data('value');
                $('#editCatExpense').modal('show');

                $.ajax({
                    url: "{{ url('admin/expenses/category/edit') }}/" + expense_id,
                    type: 'GET',
                    success: function(response) {
                        $('#expense_id').val(response.id);
                        $('#category').val(response.category);
                        $('#description').val(response.description);
                        $('#status').val(response.status);
                    }
                });
            });
        });
    </script>
@endsection
