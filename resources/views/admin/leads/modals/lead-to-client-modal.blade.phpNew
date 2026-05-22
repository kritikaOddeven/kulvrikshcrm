<div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="myLargeModalLabel">Convert Lead To Client</h5>
                
                <div class="">
                    <strong class="text-end">
                    REF00 <span id="convert_to_lead_id2">{{ request()->id ?? '' }}</span>
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
            </div>
            <form id="convertLeadForm" action="{{ url('admin/leads/convert-to-client') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="lead_id" id="convert_to_lead_id" value="{{ request()->id ?? '' }}">
                <div class="modal-body g-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="validationDefault04" class="form-label">Kulvrisk Id</label>
                            <input type="text" class="form-control" id="kulvrisk_id" name="kulvrisk_id"  value="">
                            <span class="text-danger">
                                @error('kulvrisk_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="validationDefault04" class="form-label">Payment Mode <x-required-star /></label>
                            <select class="form-select" id="payment_mode" name="payment_mode">
                                <option selected disabled>Select Mode</option>
                                <option value="neft">NEFT</option>
                                <option value="dbf">Direct Bank Transfer</option>
                                <option value="cheque">Cheque</option>
                                <option value="upi">UPI</option>
                                <option value="credit">Credit Card</option>
                                <option value="debit">Debit Card</option>
                                <option value="cash">Cash</option>
                                <option value="razorpay">Razorpay</option>
                                <option value="stripe">Stripe</option>
                                <option value="op">Online Payment</option>
                                <option value="pp">Pending Payment</option>
                            </select>
                            <span class="text-danger">
                                @error('payment_mode')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>


                    <div class="row dynamic-group mb-1" data-index="0">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Project Name</label>
                            <select class="form-select project-select" name="project[]" data-index="0" >
                                <option selected disabled>Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger project-error">
                                @error('project')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Sub Project Name</label>
                            <select class="form-select subproject-select" name="sub_project[]" data-index="0" >
                                <option selected disabled>Select Sub Project</option>
                            </select>
                            <span class="text-danger subproject-error">
                                @error('sub_project')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Service Name</label>
                            <input type="text" class="form-control" name="service_name[]" placeholder="Enter service name">
                            <span class="text-danger service-name-error"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Service Description</label>
                            <input type="text" class="form-control" name="service_description[]" placeholder="Enter service description">
                            <span class="text-danger service-description-error"></span>
                        </div>
                    </div>

                    

                    {{-- Dynamic row will be added here for project details  --}}
                    <div id="dynamicContainer">
                        <!-- Dynamic content will be added here -->
                    </div>

                    <!-- Buttons -->
                     <span class="text-danger" id="service-table-error" style="display:none;">
                        Please add at least one Project OR Service.
                    </span>
                    <div class="row justify-content-between">
                        <div class="col-auto mb-2">
                            <button id="addMore" class="btn btn-sm btn-primary">+ Add More</button>
                        </div>
                        <div class="col-auto mb-2">
                            <button id="delete" class="btn btn-sm btn-danger" style="display: none"><i class="ri-delete-bin-line"></i> Delete</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="validationDefault04" class="form-label">Start Date </label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker pe-5" name="start_date" id="start_date" required placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                            
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="validationDefault04" class="form-label">End Date </label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker pe-5" name="end_date" id="end_date" required placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                            
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="validationDefault04" class="form-label">Image Upload </label>
                            <input type="file" class="form-control" id="image" name="image_path" accept=".pdf, .png, .jpg, .jpeg">
                            <small class="text-danger">Maximum upload file size: 5MB. Accepted formats: PDF, PNG, JPG.</small>
                        </div>


                        <div class="col-md-12">
                            <label for="validationDefault04" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Convert </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#convertLeadForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let formData = new FormData(this);
            let $submitBtn = $form.find('button[type="submit"]');
            let originalText = $submitBtn.text();

            $submitBtn.prop('disabled', true).text('Converting...');

            // Clear old error messages
            $form.find('.text-danger').not('.req-star, #service-table-error').text('');
            $('#service-table-error').hide();

            // Require at least one Project OR Service
            const hasAnyProject = $form.find('.project-select').toArray().some(el => {
                const v = $(el).val();
                return v !== null && v !== undefined && String(v).trim() !== '';
            });
            const hasAnyService = $form.find('input[name="service_name[]"], input[name="service_description[]"]').toArray().some(el => {
                return String($(el).val() ?? '').trim() !== '';
            });
            if (!hasAnyProject && !hasAnyService) {
                $('#service-table-error').show();
                $submitBtn.prop('disabled', false).text(originalText);
                return;
            }

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $submitBtn.prop('disabled', false).text(originalText);

                    $('#convertLeadForm')[0].reset();
                    $('.bs-example-modal-lg').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Converted!',
                        text: response.message || 'Lead converted successfully.',
                        timer: 5000,
                        confirmButtonText: 'OK',
                    }).then(() => {
                        window.location.href = '/admin/leads';
                    });
                },
                error: function(xhr) {
                    $form.find('.text-danger').not('.req-star, #service-table-error').text('');
                    $('#service-table-error').hide();

                    $submitBtn.prop('disabled', false).text(originalText);

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $form.find('.text-danger').not('.req-star').text('');

                            if (errors) {
                                $.each(errors, function(field, messages) {
                                    const arrayField = field.replace(/\.(\d+)/g, '[$1]');
                                    const $input = $form.find(`[name="${arrayField}"]`);

                                    // Special case: show message near .project-select or .subproject-select
                                    if (field === 'project') {
                                        $form.find('.project-error').text(messages[0]);
                                    } else if (field === 'sub_project') {
                                        $form.find('.subproject-error').text(messages[0]);
                                    } else if (field === 'project_or_service') {
                                        $('#service-table-error').text(messages[0]).show();
                                    } else if ($input.length) {
                                        // Default handler for other fields
                                        $input.closest('.mb-2, .col-md-6, .col-md-12')
                                            .find('.text-danger')
                                            .not('.req-star')
                                            .first()
                                            .text(messages[0]);
                                    } else {
                                        console.warn(`⚠️ Field not found: ${field}`);
                                    }
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        let count = 1;

        // Function to update all subproject dropdowns (allows same sub project to be selected in multiple rows)
        function updateSubprojectOptions() {
            $('.subproject-select').each(function() {
                const $select = $(this);
                const currentValue = $select.val();
                const currentIndex = $select.data('index');
                
                // Clear and rebuild options
                $select.empty().append('<option selected disabled>Select Sub Project</option>');
                
                // Get all available subprojects for this project
                const projectId = $(`.project-select[data-index="${currentIndex}"]`).val();
                if (projectId) {
                    $.ajax({
                        url: `/admin/get-subprojects/${projectId}`,
                        type: 'GET',
                        async: false,
                        success: function(res) {
                            res.forEach(sub => {
                                $select.append(`<option value="${sub.id}">${sub.name}</option>`);
                            });
                            if (currentValue) {
                                $select.val(currentValue);
                            }
                        },
                        error: function() {
                            $select.html('<option>Error loading subprojects</option>').prop('disabled', true);
                        }
                    });
                }
            });
        }

        // Add more dynamic rows
        $('#addMore').click(function(e) {
            e.preventDefault();

            let index = count++;
            // Show delete button
            $('#delete').show();

            const projectOptions = @json($projects).map(
                p => `<option value="${p.id}">${p.name}</option>`
            ).join('');

            const group = `
            <div class="row dynamic-group mb-3" data-index="${index}">
                <div class="col-md-6">
                    <label class="form-label">Project Name(${count})</label>
                    <select class="form-select project-select" name="project[]" data-index="${index}">
                        <option selected disabled>Select Project</option>
                        ${projectOptions}
                    </select>
                    <span class="text-danger project-error">
                        @error('project')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sub Project Name(${count})</label>
                    <select class="form-select subproject-select" name="sub_project[]" data-index="${index}">
                        <option selected disabled>Select Sub Project</option>
                    </select>
                    <span class="text-danger subproject-error">
                        @error('sub_project')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                 <div class="col-md-6 mb-2">
                        <label class="form-label">Service Name(${count})</label>
                        <input type="text" class="form-control" name="service_name[]"  placeholder="Enter service name">
                        <span class="text-danger service-name-error"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Service Description(${count})</label>
                        <input type="text" class="form-control" name="description[]" placeholder="Enter service description">
                        <span class="text-danger service-description-error"></span>
                    </div>
                </div>
            </div>
        `;

            $('#dynamicContainer').append(group);
        });

        // Delete last group
        $('#delete').click(function(e) {
            e.preventDefault();
            const lastGroup = $('#dynamicContainer .dynamic-group').last();
            lastGroup.remove();
            
            updateSubprojectOptions();
            
            // If no rows left, hide delete button
            if ($('#dynamicContainer .dynamic-group').length === 0) {
                $('#delete').hide();
                count = 1; // Reset count if needed
            }
        });

        // On project change, fetch related subprojects (allows same sub project in multiple rows)
        $(document).on('change', '.project-select', function() {
            const projectId = $(this).val();
            const index = $(this).data('index');
            const $subSelect = $(`.subproject-select[data-index="${index}"]`);

            $subSelect.empty().append('<option selected disabled>Select Sub Project</option>').prop('disabled', true);

            if (!projectId) return;

            $.ajax({
                url: `/admin/get-subprojects/${projectId}`,
                type: 'GET',
                success: function(res) {
                    let options = '<option selected disabled>Select Sub Project</option>';
                    res.forEach(sub => {
                        options += `<option value="${sub.id}">${sub.name}</option>`;
                    });
                    $subSelect.html(options).prop('disabled', false);
                },
                error: function() {
                    $subSelect.html('<option>Error loading subprojects</option>').prop('disabled', true);
                }
            });
        });
    });
</script>
