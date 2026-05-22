<div class="modal fade" id="expense" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Add Expense Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addExpenseForm" action="{{route('admin.expenses.category.store')}}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Category<x-required-star /></label>
                        <input type="text" class="form-control" id="validationDefault01" value="" name="category">
                        <span class="text-danger">@error('category'){{ $message }}@enderror</span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select"  name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="validationDefaultEmail" class="form-label">Description<x-required-star /></label>
                        <textarea name="description" id="" class="form-control"></textarea>
                        <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- edit expense --}}
<div class="modal fade" id="editCatExpense" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Expense Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editExpenseForm" action="{{route('admin.expenses.category.update')}}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <input type="hidden" name="expense_id" id="expense_id">
                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Category <x-required-star /></label>
                        <input type="text" class="form-control" id="category" value="" name="category">
                        <span class="text-danger">@error('category'){{ $message }}@enderror</span>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="validationDefaultEmail" class="form-label">Description<x-required-star /></label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                        <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>


