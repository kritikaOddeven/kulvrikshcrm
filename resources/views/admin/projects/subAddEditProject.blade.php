<div class="modal fade" id="subproject" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Add Sub Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="subProjectAddForm" action="{{route('admin.projects.subproject.store')}}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label for="validationDefault04" class="form-label">Category<x-required-star /></label>
                        <input type="text" class="form-control" disabled value="{{ $project->name }}">
                        <input type="hidden" class="form-control"  value="{{ $project->id }}" name="project_id">
                        <span class="text-danger">@error('project_id'){{ $message }}@enderror</span>
                    </div>

                    <div class="col-md-12">
                        <label for="validationDefault01" class="form-label">Project Name<x-required-star /></label>
                        <input type="text" class="form-control" maxlength="255" id="validationDefault01" value="{{old('name')}}" name="name">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Amount<x-required-star /></label>
                        <input type="number" class="form-control" id="validationDefault01" value="{{old('amount')}}" name="amount" step="0.01">
                        <span class="text-danger">@error('amount'){{ $message }}@enderror</span>
                    </div>
                   
                    <div class="col-md-6">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select" id="validationDefault04" name="status">
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

{{-- edit sub project --}}
<div class="modal fade" id="editSubProject" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Sub Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="subProjectEditForm" action="{{route('admin.projects.subproject.update')}}" method="POST">
                @csrf
            
                <div class="modal-body row g-3">
                    <input type="hidden" name="subProject_id" id="subProject_id">
                    <div class="col-md-12">
                        <label for="validationDefault04" class="form-label">Category<x-required-star /></label>
                        <input type="text" class="form-control" disabled value="{{ $project->name }}">
                        <input type="hidden" class="form-control"  value="{{ $project->id }}" name="project_id">
                        <span class="text-danger">@error('project_id'){{ $message }}@enderror</span>
                    </div>

                    <div class="col-md-12">
                        <label for="validationDefault01" class="form-label">Project Name<x-required-star /></label>
                        <input type="text" class="form-control" id="name" maxlength="255" value="" name="name">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Amount<x-required-star /></label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01">
                        <span class="text-danger">@error('amount'){{ $message }}@enderror</span>
                    </div>
                   
                    <div class="col-md-6">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="validationDefaultEmail" class="form-label">Description<x-required-star /></label>
                        <textarea name="description" id="description" rows="4" class="form-control"></textarea>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Form submission handler for both add and edit forms
    $('#subProjectAddForm, #subProjectEditForm').on('submit', function(e) {
        e.preventDefault();

        let $form = $(this);
        let $submitBtn = $form.find('button[type="submit"]');
        let originalText = $submitBtn.text();

        $submitBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $form[0].reset();
                $form.find('.text-danger').not('.req-star').text('');
                $('.modal').modal('hide');

                Swal.fire({
                    title: 'Success!',
                    text: response.message || 'Sub Project saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 5000,
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                $form.find('.text-danger').not('.req-star').text('');

                if (errors) {
                    $.each(errors, function(field, messages) {
                        $form.find(`[name="${field}"]`).next('.text-danger').text(messages[0]);
                    });
                }
                $submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Edit button click handler
    $('.editbtn').on('click', function() {
        $('#editSubProject').modal('show');

        var subProject_id = $(this).data('value');
        $.ajax({
            url: "{{ url('admin/projects/subproject/edit/') }}" + '/' + subProject_id,
            type: 'GET',
            success: function(response) {
                $('#subProject_id').val(response.id);
                $('#name').val(response.name);
                $('#amount').val(response.amount);
                $('#description').val(response.description);
                $('#status').val(response.status);
            }
        });
    });
</script>
