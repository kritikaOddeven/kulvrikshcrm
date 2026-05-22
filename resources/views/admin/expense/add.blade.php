<div class="modal fade" id="addExpense" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addExpenseForm" action="{{ route('admin.expenses.store') }}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Title <x-required-star /></label>
                        <input type="text" class="form-control" value="{{ old('subject') }}" name="subject">
                        <span class="text-danger">
                            @error('subject')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefaultEmail" class="form-label">Category <x-required-star /></label>
                        <select class="form-select" id="category" name="category_id">
                            <option selected disabled>Select Category</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->category }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('category_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-6">
                        <label for="validationDefault04" class="form-label">Payment Mode <x-required-star /></label>
                        <select class="form-select" id="payment_mode"  name="payment_mode">
                            <option selected disabled>Select Mode</option>
                            <option value="cash">Cash</option>
                            <option value="upi">UPI</option>
                            <option value="cheque">Cheque</option>
                            <option value="credit">Credit Card</option>
                            <option value="debit">Debit Card</option>
                            <option value="dbf">Direct Bank Transfer</option>
                        </select>
                        <span class="text-danger">
                            @error('payment_mode')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6" >
                        <label for="validationDefaultEmail" class="form-label">Account Name <x-required-star /></label>
                        <select class="form-select" id="account" name="account_id">
                            <option selected disabled>Select Account Name</option>
                            @foreach ($accoount as $item)
                                <option value="{{ $item->id }}">{{ $item->bank_name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('account_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Amount <x-required-star /></label>
                        <input type="number" class="form-control" value="{{ old('amount') }}" name="amount">
                        <span class="text-danger">
                            @error('amount')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Date <x-required-star /></label>

                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" value="{{ old('date') }}" name="date" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                        <span class="text-danger date-error">
                            @error('date')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select" id="validationDefault04" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="active" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="validationDefaultEmail" class="form-label">Description <x-required-star /></label>
                        <textarea name="description" class="form-control"></textarea>
                        <span class="text-danger">
                            @error('description')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-light" @if (!$errors->any()) data-bs-dismiss="modal" @endif>Close</button> --}}
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary save-btn">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Script -->
<script>
    // document.getElementById('payment_mode').addEventListener('change', function() {
    //     if (this.value === 'dbf') {
    //         document.getElementById('account_div').style.display = 'block';
    //     } else {
    //         document.getElementById('account_div').style.display = 'none';
    //     }
    // });
</script>
