<div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Add Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="projectAddForm" action="{{route('admin.projects.store')}}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label for="validationDefault01" class="form-label">Project Name<x-required-star /></label>
                        <input type="text" class="form-control" value="" name="name">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="validationDefaultEmail" class="form-label">Description<x-required-star /></label>
                        <textarea name="description" id="" class="form-control"></textarea>
                        <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                    </div>

                    <div class="col-md-12">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select"  name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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
