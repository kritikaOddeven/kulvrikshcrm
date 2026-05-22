@extends('admin.layouts.app')
@section('pagetitle', 'Add Lead | Kulvriksh')
@section('admin-content')
    <style>
        .accordion-item {
            border-radius: 0 !important;
        }
    </style>
    <form action="{{ url('admin/leads/store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row py-3 align-items-center justify-content-between gap-2">
            <div class="col-auto">
                <h4 class="page-title">Add Lead</h4>
                {{-- <p>Agents/View All Agents</p> --}}
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lead</a></li>
                    <li class="breadcrumb-item active"><a href="{{ url('admin/leads') }}">View All Leads</a></li>
                    <li class="breadcrumb-item active">Add Leads</li>
                </ol>
            </div>
            <div class="col-auto">
                <a href="{{ url('admin/leads') }}" type="button" id="notes" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" id="notes" class="btn btn-primary"> Save</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card form-box">
                    <div class="accordion rounded-0" id="accordionPanelsStayOpenExample">
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
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ url('admin/leads') }}" type="button" id="notes" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="notes" class="btn btn-primary"> Save</button>
                    </div>
                </div><!-- end card -->
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
             else if (field.hasClass('lead-city')) {
                $('.city-error').html(errorDiv);
            }
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
                    {
                        field: $('select[name="city"]'),
                         message: 'City is required'
                    }
                ];

                requiredFields.forEach(function(item) {
                    if (!item.field.val() || item.field.val() === 'Select Country' ||
                        item.field.val() === 'Select State' || item.field.val() === 'Select District' ||
                        item.field.val() === 'Select City') {
                        showError(item.field, item.message);
                        isValid = false;
                    }
                });

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
            $('input, select').on('input change', function() {
                clearError($(this));
            });

        });
    </script>

    {{-- add row dynamically for great-grandfather/mother deatils  --}}
    <script>
        $(document).ready(function() {
            let count = 1;
            flatpickr(".basic-datepicker", {
                altInput: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d"
            });
            $('#addMore').click(function(e) {
                e.preventDefault();
                count++;
                // Show delete button
                $('#delete').show();
                // Column structure
                let columnGroup = `
                <div class="row dynamic-group mb-3">
                    <div class="col-md-3 mb-2">
                        <label for="validationDefault01" class="form-label">Great-Grandfather's Name (${count})</label>
                        <input type="text" class="form-control" id="validationDefault01"  name="ggf_name[]" >
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="validationDefault01" class="form-label">Birth Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_dob[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="validationDefault01" class="form-label">Marriage Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_marriage_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="validationDefault01" class="form-label">Death Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_death_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Great-Grandmother's Name (${count})</label>
                        <input type="text" class="form-control" name="ggm_name[]" >
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Birth Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_dob[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Marriage Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_marriage_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
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
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Brother / Sister (${broSisCount})</label>
                            <select class="form-select" name="sibling_relation[]" >
                                <option selected disabled>Select Type</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Sister</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Brother/Sister Name (${broSisCount})</label>
                            <input type="text" class="form-control" name="sibling_name[]" placeholder="Enter Name" >
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Birth Date (${broSisCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="sibling_dob[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
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
                    broSisCount = 1; // Reset count if needed
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
                <div class="col-md-3 mb-2">
                    <label class="form-label">Brother / Sister (${wifeBroSisCount})</label>
                    <select class="form-select" name="wife_sibling_relation[]" >
                        <option selected disabled>Select Type</option>
                        <option value="brother">Brother</option>
                        <option value="sister">Sister</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Brother/Sister Name (${wifeBroSisCount})</label>
                    <input type="text" class="form-control" name="wife_sibling_name[]" placeholder="Enter Name" >
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Birth Date (${wifeBroSisCount})</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker" name="wife_sibling_dob[]" placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
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
    </script>

    {{-- Country, State, City, District, Taluka, Village Handling --}}
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
        $('.lead-country').on('change', function() {
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
    
@endsection
