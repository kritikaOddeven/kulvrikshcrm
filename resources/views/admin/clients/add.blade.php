@extends('admin.layouts.app')
@section('pagetitle', 'Add Client | Kulvriksh')
@section('admin-content')


    <form action="{{ url('admin/clients/store') }}" method="post" enctype="multipart/form-data">
        <div class="row py-3 align-items-center justify-content-between gap-2">
            <div class="col-auto">
                <h4 class="page-title">Add Client</h4>
                {{-- <p>Agents/View All Agents</p> --}}
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashborad</a></li>
                    <li class="breadcrumb-item active"><a href="{{ url('admin/clients') }}">View All Clients</a></li>
                    <li class="breadcrumb-item active">Add Client</li>
                </ol>
            </div>
            <div class="col-auto">
                <a href="{{ url('admin/clients') }}" type="button" id="notes" class="btn btn-secondary">Cancel</a>
                <button type="submit" id="notes" class="btn btn-primary"> Save</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card form-box">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        {{-- client info --}}
                        <div class="accordion-item">
                            <div id="panelsStayOpen-collapse" class="accordion-collapse collapse show">
                                @csrf
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Kulvriksh Id <x-required-star /></label>
                                            <input type="text" class="form-control" id="validationDefault01" name="kulvrisk_id">
                                            <span class="text-danger">
                                                @error('kulvrisk_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Researcher Name <x-required-star /></label>
                                            <select class="form-select js-choice researcher-select" id="researcher_name" name="researcher_ids[]" multiple>
                                                <option disabled>Select Researcher</option>
                                                @foreach ($researchers as $researcher)
                                                    <option @if (roleType() == 'researcher' && $researcher->id == auth()->id()) selected @endif value="{{ $researcher->id }}">{{ $researcher->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger researcher-error">
                                                @error('researcher_ids')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault04" class="form-label">Payment Mode <x-required-star /></label>
                                            <select class="form-select" id="payment_mode" required name="payment_mode">
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
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault04" class="form-label">Image Upload</label>
                                            <input type="file" class="form-control" id="image" name="image_path" accept=".pdf, .png, .jpg, .jpeg">
                                            <small class="text-danger">Maximum upload file size: 5MB. Accepted formats: PDF, PNG, JPG.</small>
                                        </div>

                                        <!-- <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Project Name <x-required-star /></label>
                                            <select class="form-select project-select" name="project[]" data-index="0" required>
                                                <option selected disabled>Select Project</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('project')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Sub Project Name <x-required-star /></label>
                                            <select class="form-select subproject-select" name="sub_project[]" data-index="0" required>
                                                <option selected disabled>Select Sub Project</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('sub_project')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div> -->
  @if ($errors->has('project_or_service'))
                                        <div class="alert alert-danger mt-2">
                                            {{ $errors->first('project_or_service') }}
                                        </div>
                                    @endif

                                        {{-- Project Container --}}
                                        <div class="col-12" id="clientProjectContainer">
                                            <div class="row">
                                                <div class="col-12 mb-2 client-project-row" data-index="0">
                                                    <div class="row g-2 align-items-start">
                                                        <div class="col-md-3 mb-2">
                                                            <label class="form-label">Project Name </label>
                                                            <select class="form-select project-select" name="project[]" data-index="0">
                                                                <option value="">Select Project</option>
                                                                @foreach ($projects as $project)
                                                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                @error('project') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <label class="form-label">Sub Project Name </label>
                                                            <select class="form-select subproject-select" name="sub_project[]" data-index="0" disabled>
                                                                <option value="">Select Sub Project</option>
                                                            </select>
                                                            <span class="text-danger">
                                                                @error('sub_project') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <label class="form-label">Service Name</label>
                                                            <input type="text" class="form-control" name="service_name[]" placeholder="Enter service name">
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <div class="d-flex gap-2 align-items-end">
                                                                <div class="flex-grow-1">
                                                                    <label class="form-label">Service Description</label>
                                                                    <textarea class="form-control" name="service_description[]" rows="1" placeholder="Enter service description"></textarea>
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn btn-sm btn-danger btn-remove-project-row mt-2" title="Remove" style="visibility: hidden;">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Add More Button --}}
                                        <div class="row mb-2">
                                            <div class="col-auto">
                                                <button type="button" id="clientProjectAddMore" class="btn btn-sm btn-primary">+ Add More</button>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault04" class="form-label">Start Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5" name="start_date" id="start_date" required placeholder="dd-mm-yyyy">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>

                                            <span class="text-danger">
                                                @error('start_date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault04" class="form-label">End Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5" name="end_date" id="end_date" required placeholder="dd-mm-yyyy">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>

                                            <span class="text-danger">
                                                @error('end_date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- lead info --}}
                        @include('admin.leads.partials.lead-info')

                        {{-- Family lineage and heritage --}}
                        @include('admin.leads.partials.lineage.lead-lineage')

                        {{-- family member Info --}}
                        @include('admin.leads.partials.familes.lead-family')

                        {{-- lead wife info --}}
                        @include('admin.leads.partials.lead-wife')

                        {{-- Wife Family lineage and heritage --}}
                        @include('admin.leads.partials.lineage.wife-lineage')

                        {{-- wife family information --}}
                        @include('admin.leads.partials.familes.wife-family')

                        {{-- Children Information --}}
                        @include('admin.leads.partials.children')

                        {{-- Notes --}}
                        @include('admin.leads.partials.lead-note')
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ url('admin/clients') }}" type="button" id="notes" class="btn btn-secondary">Cancel</a>
                    <button type="submit" id="notes" class="btn btn-primary"> Save</button>
                </div>
            </div><!-- end card -->
        </div>
        </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Form Validation Script --}}
    <script>
        // Global validation functions
        function showError(field, message) {
            // Remove existing error message
            field.siblings('.error-message').remove();
            // field.addClass('is-invalid');
            console.log(field);
            // Add error message below the field
            const errorDiv = $('<div class="error-message text-danger small mt-1"></div>').text(message);
            if (field.hasClass('lead-country')) {
                $('.country-error').html(errorDiv);
            } else if (field.hasClass('lead-state')) {
                $('.state-error').html(errorDiv);
            } else if (field.hasClass('lead-district')) {
                $('.district-error').html(errorDiv);
            }
            //else if(field.hasClass('lead-city')){
            //$('.city-error').html(errorDiv);
            //}
            else {
                field.after(errorDiv);
            }
        }

        function clearError(field) {
            field.removeClass('is-invalid');
            field.siblings('.error-message').remove();
        }

        $(document).ready(function() {

            // Function to validate email format
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Function to validate phone number
            function isValidPhone(phone) {
                return phone.length === 10 && /^\d+$/.test(phone);
            }

            // Function to validate date format
            function isValidDate(dateStr) {
                if (!dateStr) return true; // Allow empty dates
                const dateRegex = /^\d{2}-\d{2}-\d{4}$/;
                if (!dateRegex.test(dateStr)) return false;

                const parts = dateStr.split('-');
                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]);
                const year = parseInt(parts[2]);

                const date = new Date(year, month - 1, day);
                return date.getDate() === day && date.getMonth() === month - 1 && date.getFullYear() === year;
            }

            // Form validation function
            function validateForm() {
                let isValid = true;

                // Clear all previous errors
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Required fields validation
                const requiredFields = [{
                        field: $('input[name="kulvrisk_id"]'),
                        message: 'Kulvriksh ID is required'
                    },
                    {
                        field: $('select[name="researcher_ids[]"]'),
                        message: 'Researcher is required'
                    },
                    {
                        field: $('select[name="payment_mode"]'),
                        message: 'Payment mode is required'
                    },
                    // {
                    //     field: $('select[name="project[]"]'),
                    //     message: 'Project is required'
                    // },
                    // {
                    //     field: $('select[name="sub_project[]"]'),
                    //     message: 'Sub Project is required'
                    // },
                    {
                        field: $('input[name="first_name"]'),
                        message: 'First name is required'
                    },
                    {
                        field: $('input[name="last_name"]'),
                        message: 'Last name is required'
                    },
                    {
                        field: $('select[name="country"]'),
                        message: 'Country is required'
                    },
                    {
                        field: $('select[name="state"]'),
                        message: 'State is required'
                    },
                    {
                        field: $('select[name="district"]'),
                        message: 'District is required'
                    },
                    // { field: $('select[name="city"]'), message: 'City is required' }
                ];

                requiredFields.forEach(function(item) {
                    if (!item.field.val() || item.field.val() === 'Select Country' ||
                        item.field.val() === 'Select State' || item.field.val() === 'Select District' ||
                        item.field.val() === 'Select City') {
                        showError(item.field, item.message);
                        isValid = false;
                    }
                });

                 let hasValidProject = false;
                let hasValidService = false;

                // Check each project+subproject row
                $('#clientProjectContainer .client-project-row').each(function() {
                    const projectId = $(this).find('.project-select').val();
                    const subProjectId = $(this).find('.subproject-select').val();
                    if (projectId && subProjectId && projectId !== '' && subProjectId !== '') {
                        hasValidProject = true;
                    }
                });

                // Check each service row (name or description filled)
                $('#clientProjectContainer .client-project-row').each(function() {
                    const serviceName = $(this).find('input[name="service_name[]"]').val().trim();
                    const serviceDesc = $(this).find('textarea[name="service_description[]"]').val().trim();
                    if (serviceName !== '' || serviceDesc !== '') {
                        hasValidService = true;
                    }
                });

                if (!hasValidProject && !hasValidService) {
                    const errorHtml = '<div class="alert alert-danger mt-2 project-service-error">Please add at least one Project OR Service.</div>';
                    $('#clientProjectContainer').before(errorHtml);
                    isValid = false;
                }
                // Phone number validation
                const phoneField = $('input[name="phone"]');
                if (phoneField.val()) {
                    if (!isValidPhone(phoneField.val())) {
                        $('.phone-error').html('Phone number must be 10 digits');
                        // showError(phoneField, 'Phone number must be 10 digits');
                        isValid = false;
                    }
                } else {
                    $('.phone-error').html('Phone number is required');
                    // showError(phoneField, 'Phone number is required');
                    isValid = false;
                }

                if ($('.researcher-select').val().length == 0) {
                    showError($('.researcher-error'), 'Researcher is required');
                    isValid = false;
                }
                // Email validation
                const emailField = $('input[name="email"]');
                if (emailField.val() && !isValidEmail(emailField.val())) {
                    showError(emailField, 'Please enter a valid email address');
                    isValid = false;
                }

                return isValid;
            }

            // Form submit handler
            $('form').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = $('.is-invalid').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                    return false;
                }
            });

            // Real-time validation on input change
            // $('input, select').on('input change', function() {
            //     clearError($(this));
            // });
             $('input, select').on('input change', function() {
                clearError($(this));
                // Remove the project/service error if any field becomes valid
                let hasProject = false;
                let hasService = false;
                $('#clientProjectContainer .client-project-row').each(function() {
                    const p = $(this).find('.project-select').val();
                    const sp = $(this).find('.subproject-select').val();
                    if (p && sp && p !== '' && sp !== '') hasProject = true;
                    const sn = $(this).find('input[name="service_name[]"]').val().trim();
                    const sd = $(this).find('textarea[name="service_description[]"]').val().trim();
                    if (sn !== '' || sd !== '') hasService = true;
                });
                if (hasProject || hasService) {
                    $('.project-service-error').remove();
                }
            });

        });
    </script>

    {{-- add row dynamically for great-grandfather/mother deatils  --}}
    <script>
        $(document).ready(function() {
            let count = 1;
            $('#addMore').click(function(e) {
                e.preventDefault();
                count++;
                // Show delete button
                $('#delete').show();
                // Column structure
                let columnGroup = `
                <div class="row dynamic-group mb-3">
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Great-Grandfather's Name (${count})</label>
                        <input type="text" class="form-control" id="validationDefault01"  name="ggf_name[]" >
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Birth Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_dob[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Marriage Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_marriage_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Death Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_death_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Great-Grandmother's Name (${count})</label>
                        <input type="text" class="form-control" name="ggm_name[]" >
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Birth Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_dob[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Marriage Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_marriage_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Death Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_death_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                </div>`;

                // Append the new columns
                $('#dynamicContainer').append(columnGroup);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });

            $('#delete').click(function(e) {
                e.preventDefault();

                // Remove the last added group of columns
                $('#dynamicContainer .dynamic-group').last().remove();
                // If no rows left, hide delete button
                if ($('#dynamicContainer .dynamic-group').length === 0) {
                    $('#delete').hide();
                    count = 1; // Reset count if needed
                }
            });
        });

        // add row dynamically for lead brother/sister deatils
        $(document).ready(function() {
            let broSisCount = 1;

            $('#addBroSisRow').click(function(e) {
                e.preventDefault();
                broSisCount++;

                // Show delete button
                $('#deleteBroSisRow').show();

                let row = `
                    <div class="row dynamic-brosis-group mb-3">
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Brother / Sister (${broSisCount})</label>
                            <select class="form-select" name="sibling_relation[]" >
                                <option selected disabled>Select Type</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Sister</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Brother/Sister Name (${broSisCount})</label>
                            <input type="text" class="form-control" name="sibling_name[]" placeholder="Enter Name" >
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Birth Date (${broSisCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="sibling_dob[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Death Date (${broSisCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="sibling_death_date[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                    </div>
                `;

                $('#broSisContainer').append(row);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });
            // delete row dynamically for lead brother/sister deatils
            $('#deleteBroSisRow').click(function(e) {
                e.preventDefault();
                if (broSisCount > 1) {
                    $('#broSisContainer .dynamic-brosis-group').last().remove();
                    broSisCount--;
                }
                // If no rows left, hide delete button
                if ($('#broSisContainer .dynamic-brosis-group').length === 0) {
                    $('#deleteBroSisRow').hide();
                    count = 1; // Reset count if needed
                }
            });
        });

        // add row dynamically for wife brother/sister deatils
        $(document).ready(function() {
            let wifeBroSisCount = 1;

            $('#addWifeBroSisRow').click(function(e) {
                e.preventDefault();
                wifeBroSisCount++;
                // Show delete button
                $('#deleteWifeBroSisRow').show();

                let row = `
            <div class="row dynamic-brosis-group mb-3">
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="form-label">Brother / Sister (${wifeBroSisCount})</label>
                    <select class="form-select" name="wife_sibling_relation[]" >
                        <option selected disabled>Select Type</option>
                        <option value="brother">Brother</option>
                        <option value="sister">Sister</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="form-label">Brother/Sister Name (${wifeBroSisCount})</label>
                    <input type="text" class="form-control" name="wife_sibling_name[]" placeholder="Enter Name" >
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="form-label">Birth Date (${wifeBroSisCount})</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker" name="wife_sibling_dob[]" placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="form-label">Death Date (${wifeBroSisCount})</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker" name="wife_sibling_death_date[]" placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                </div>
            </div>
            `;

                $('#broWifeSisContainer').append(row);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });
            // delete row dynamically for wife brother/sister deatils
            $('#deleteWifeBroSisRow').click(function(e) {
                e.preventDefault();
                if (wifeBroSisCount > 1) {
                    $('#broWifeSisContainer .dynamic-brosis-group').last().remove();
                    wifeBroSisCount--;
                }
                // If no rows left, hide delete button
                if ($('#broWifeSisContainer .dynamic-brosis-group').length === 0) {
                    $('#deleteWifeBroSisRow').hide();
                    wifeBroSisCount = 1; // Reset count if needed
                }
            });
        });

        // add row dynamically for children deatils
        $(document).ready(function() {
            let childCount = 1;

            $('#addChildRow').click(function(e) {
                e.preventDefault();
                childCount++;
                // Show delete button
                $('#deleteChildRow').show();

                let row = `
            <div class="row dynamic-child-group mb-3">
               <div class="col-md-4 mb-2">
                    <label for="validationDefault01" class="form-label">Gender (${childCount})</label>
                    <select class="form-select" id="child_gender"  name="child_gender[]">
                        <option selected disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="validationDefault01" class="form-label">Children Name (${childCount})</label>
                    <input type="text" class="form-control" id="validationDefault01"  name="child_name[]" >
                </div>
                <div class="col-md-4 mb-2">
                    <label for="validationDefault01" class="form-label">Birth Date (${childCount})</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker" name="child_dob[]" placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                </div>
            </div>
            `;

                $('#childContainer').append(row);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });
            // delete row dynamically forchildren deatils
            $('#deleteChildRow').click(function(e) {
                e.preventDefault();
                if (childCount > 1) {
                    $('#childContainer .dynamic-child-group').last().remove();
                    childCount--;
                }
                // If no rows left, hide delete button
                if ($('#childContainer .dynamic-child-group').length === 0) {
                    $('#deleteChildRow').hide();
                    childCount = 1; // Reset count if needed
                }
            });
        });

        // On project change, fetch related subprojects
        $(document).on('change', '.project-select', function() {
            const projectId = $(this).val();
            const index = $(this).data('index');

            const $subSelect = $(`.subproject-select[data-index="${index}"]`);

            $subSelect.empty().append('<option>Loading...</option>').prop('disabled', true);

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
    </script>


    {{-- Country, State, City, District Handling --}}
    {{-- <script>
        $(document).ready(function() {
            function setupLocationHandlers(prefix = '') {
                // Select elements by prefix
                const countrySelect = document.querySelector(`#country${prefix}`);
                const stateSelect = document.querySelector(`#state${prefix}`);
                const citySelect = document.querySelector(`#city${prefix}`);
                const districtSelect = document.querySelector(`#district${prefix}`);

                // Use existing Choices instance or initialize if missing
                const countryChoices = countrySelect.choicesInstance;
                const stateChoices = stateSelect.choicesInstance;
                const cityChoices = citySelect.choicesInstance;
                const districtChoices = districtSelect.choicesInstance;

                function updateChoices(choicesInstance, data, placeholder) {
                    choicesInstance.clearStore();
                    const choices = [{
                        value: '',
                        label: `-- ${placeholder} --`,
                        selected: true,
                        disabled: true
                    }];
                    data.forEach(item => {
                        choices.push({
                            value: item.id,
                            label: item.name,
                            selected: false
                        });
                    });
                    choicesInstance.setChoices(choices, 'value', 'label', false);
                }

                // Country change event
                // Function to load states for a country
                function loadStatesForCountry(countryId) {
                    updateChoices(stateChoices, [], 'Loading states...');
                    updateChoices(cityChoices, [], 'Select City');
                    updateChoices(districtChoices, [], 'Select District');

                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        updateChoices(stateChoices, states, 'Select State');
                    }).fail(function() {
                        updateChoices(stateChoices, [], 'Select State');
                    });
                }

                // Check if country is pre-selected and load states
                if (countrySelect.value) {
                    loadStatesForCountry(countrySelect.value);
                }

                // Country change event
                $(`#country${prefix}`).on('change', function() {
                    const countryId = this.value;
                    loadStatesForCountry(countryId);
                });

                // State change event
                $(`#state${prefix}`).on('change', function() {
                    const stateId = this.value;
                    updateChoices(cityChoices, [], 'Loading cities...');
                    updateChoices(districtChoices, [], 'Loading districts...');

                    $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                        updateChoices(cityChoices, cities, 'Select City');
                    }).fail(function() {
                        updateChoices(cityChoices, [], 'Select City');
                    });

                    $.getJSON(`/admin/settings/get-district/${stateId}`).done(function(districts) {
                        updateChoices(districtChoices, districts, 'Select District');
                    }).fail(function() {
                        updateChoices(districtChoices, [], 'Select District');
                    });
                });
            }

            // Initialize for both sets of dropdowns
            setupLocationHandlers(''); // For #country, #state, #city, #district
            setupLocationHandlers('1'); // For #country1, #state1, #city1, #district1
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            function setupLocationHandlers(prefix = '') {
                // Select elements by prefix
                const countrySelect = document.querySelector(`#country${prefix}`);
                const stateSelect = document.querySelector(`#state${prefix}`);
                const citySelect = document.querySelector(`#city${prefix}`);
                const districtSelect = document.querySelector(`#district${prefix}`);
                const talukaSelect = document.querySelector(`#taluka${prefix}`);
                const villageSelect = document.querySelector(`#village${prefix}`);

                // Use existing Choices instance or initialize if missing
                const countryChoices = countrySelect.choicesInstance;
                const stateChoices = stateSelect ? stateSelect.choicesInstance : null;
                const cityChoices = citySelect ? citySelect.choicesInstance : null;
                const districtChoices = districtSelect ? districtSelect.choicesInstance : null;
                const talukaChoices = talukaSelect ? talukaSelect.choicesInstance : null;
                const villageChoices = villageSelect ? villageSelect.choicesInstance : null;

                function updateChoices(choicesInstance, data, placeholder) {
                    if (!choicesInstance) return;
                    choicesInstance.clearStore();
                    const choices = [{
                        value: '',
                        label: `-- ${placeholder} --`,
                        selected: true,
                        disabled: true
                    }];
                    data.forEach(item => {
                        choices.push({
                            value: item.id,
                            label: item.name,
                            selected: false
                        });
                    });
                    choicesInstance.setChoices(choices, 'value', 'label', false);
                }

                // Function to load states for a country
                function loadStatesForCountry(countryId) {
                    updateChoices(stateChoices, [], 'Loading states...');
                    updateChoices(cityChoices, [], 'Select City');
                    updateChoices(districtChoices, [], 'Select District');
                    updateChoices(talukaChoices, [], 'Select Taluka');
                    updateChoices(villageChoices, [], 'Select Village');

                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        updateChoices(stateChoices, states, 'Select State');
                    }).fail(function() {
                        updateChoices(stateChoices, [], 'Select State');
                    });
                }

                // Check if country is pre-selected and load states
                if (countrySelect.value) {
                    loadStatesForCountry(countrySelect.value);
                }

                // Country change event
                $(`#country${prefix}`).on('change', function() {
                    const countryId = this.value;
                    loadStatesForCountry(countryId);
                });

                // State change event
                $(`#state${prefix}`).on('change', function() {
                    const stateId = this.value;
                    updateChoices(cityChoices, [], 'Loading cities...');
                    updateChoices(districtChoices, [], 'Loading districts...');
                    updateChoices(talukaChoices, [], 'Select Taluka');
                    updateChoices(villageChoices, [], 'Select Village');

                    $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                        updateChoices(cityChoices, cities, 'Select City');
                    }).fail(function() {
                        updateChoices(cityChoices, [], 'Select City');
                    });

                    $.getJSON(`/admin/settings/get-district/${stateId}`).done(function(districts) {
                        updateChoices(districtChoices, districts, 'Select District');
                    }).fail(function() {
                        updateChoices(districtChoices, [], 'Select District');
                    });
                });

                // City change event to load talukas
                if (citySelect && cityChoices) {
                    $(`#city${prefix}`).on('change', function() {
                        const cityId = this.value;
                        updateChoices(talukaChoices, [], 'Loading talukas...');
                        updateChoices(villageChoices, [], 'Select Village');

                        if (cityId) {
                            $.getJSON(`/admin/settings/get-talukas/${cityId}`).done(function(talukas) {
                                updateChoices(talukaChoices, talukas, 'Select Taluka');
                            }).fail(function() {
                                updateChoices(talukaChoices, [], 'Select Taluka');
                            });
                        }
                    });
                }

                // Taluka change event to load villages
                if (talukaSelect && talukaChoices) {
                    $(`#taluka${prefix}`).on('change', function() {
                        const talukaId = this.value;
                        updateChoices(villageChoices, [], 'Loading villages...');

                        if (talukaId) {
                            $.getJSON(`/admin/settings/get-villages/${talukaId}`).done(function(villages) {
                                updateChoices(villageChoices, villages, 'Select Village');
                            }).fail(function() {
                                updateChoices(villageChoices, [], 'Select Village');
                            });
                        }
                    });
                }
            }

            // Initialize for both sets of dropdowns
            setupLocationHandlers(''); // For #country, #state, #city, #district, #taluka, #village
            setupLocationHandlers('1'); // For #country1, #state1, #city1, #district1, #taluka1, #village1
        });
    </script>



    {{-- According to Country phone no code --}}
    <script>
        $('.lead-country, .client-country').on('change', function() {
            const countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: `/admin/settings/get-phone-code/${countryId}`,
                    type: 'GET',
                    success: function(response) {
                        $('#phonecode').text(response.phonecode);
                        $('#alternate_phonecode').text(response.phonecode);
                        $('input[name="phonecode"]').val(response.phonecode);
                    }
                });
            } else {
                $('#phonecode').text('');
            }
        });

        // Handle wife country change for phonecode
        $('#country1').on('change', function() {
            const countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: `/admin/settings/get-phone-code/${countryId}`,
                    type: 'GET',
                    success: function(response) {
                        $('#wife_phonecode').text(response.phonecode);
                        $('input[name="wife_phonecode"]').val(response.phonecode);
                    }
                });
            } else {
                $('#wife_phonecode').text('');
            }
        });
    </script>
     <script>
$(document).ready(function() {
    let clientProjectCount = 1;

    function toggleFirstRowDeleteBtn() {
        const total = $('#clientProjectContainer .client-project-row').length;
        const $firstBtn = $('#clientProjectContainer .client-project-row').first().find('.btn-remove-project-row');
        $firstBtn.css('visibility', total > 1 ? 'visible' : 'hidden');
    }

    // Add More
    $(document).on('click', '#clientProjectAddMore', function(e) {
        e.preventDefault();
        const index = clientProjectCount++;
        const $firstProjectSelect = $('#clientProjectContainer .project-select').first();
        let projectOptsHtml = '';
        $firstProjectSelect.find('option').slice(1).each(function() {
            projectOptsHtml += '<option value="' + $(this).val() + '">' + $(this).text() + '</option>';
        });

        const newRow = `
            <div class="col-12 mb-2 client-project-row" data-index="${index}">
                <div class="row g-2 align-items-start">
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Project Name (${index+1}) </label>
                        <select class="form-select project-select" name="project[]" data-index="${index}">
                            <option value="">Select Project</option>${projectOptsHtml}
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Sub Project Name (${index+1}) </label>
                        <select class="form-select subproject-select" name="sub_project[]" data-index="${index}" disabled>
                            <option value="">Select Sub Project</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Service Name (${index+1})</label>
                        <input type="text" class="form-control" name="service_name[]" placeholder="Enter service name">
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="d-flex gap-2 align-items-end">
                            <div class="flex-grow-1">
                                <label class="form-label">Service Description (${index+1})</label>
                                <textarea class="form-control" name="service_description[]" rows="1" placeholder="Enter service description"></textarea>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-danger btn-remove-project-row mt-2" title="Remove">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#clientProjectContainer .row').first().append(newRow);
        toggleFirstRowDeleteBtn();
    });

    // Remove row
    $(document).on('click', '.btn-remove-project-row', function(e) {
        e.preventDefault();
        const $row = $(this).closest('.client-project-row');
        if ($('#clientProjectContainer .client-project-row').length <= 1) return;
        $row.remove();
        clientProjectCount = $('#clientProjectContainer .client-project-row').length;
        toggleFirstRowDeleteBtn();
    });

    // Project change - load subprojects
    $(document).on('change', '.project-select', function() {
        const projectId = $(this).val();
        const index = $(this).data('index');
        const $subSelect = $(`.subproject-select[data-index="${index}"]`);

        $subSelect.empty().append('<option value="">Select Sub Project</option>').prop('disabled', true);
        if (!projectId) return;

        $.ajax({
            url: `/admin/get-subprojects/${projectId}`,
            type: 'GET',
            success: function(res) {
                let options = '<option value="">Select Sub Project</option>';
                res.forEach(sub => {
                    options += `<option value="${sub.id}">${sub.name}</option>`;
                });
                $subSelect.html(options).prop('disabled', false);
            },
            error: function() {
                $subSelect.html('<option value="">Error loading</option>').prop('disabled', true);
            }
        });
    });
});
</script>
@endsection
