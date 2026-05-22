<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editProjectForm" action="{{route('admin.projects.update')}}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <input type="hidden" name="project_id" id="project_id">
                    <div class="col-md-12">
                        <label for="validationDefault01" class="form-label">Name<x-required-star /></label>
                        <input type="text" class="form-control"  id="name" name="name">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="validationDefault" class="form-label">Description<x-required-star /></label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                        <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                    </div>

                    
                    <div class="col-md-12">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $('.editbtn').on('click', function() {
        $('#editProjectModal').modal('show');

        // console.log("Edit button clicked"); // Debug log
        var project_id = $(this).data('value');
        // console.log("Agent ID: ", project_id);
        $.ajax({
            url: "{{ url('admin/projects/edit/') }}" + '/' + project_id,
            type: 'GET',
            success: function(response) {
                console.log(response)
                $('#project_id').val(response.id);
                $('#name').val(response.name);
                $('#description').val(response.description);
                $('#status').val(response.status);
            }
        });
    });
</script>
