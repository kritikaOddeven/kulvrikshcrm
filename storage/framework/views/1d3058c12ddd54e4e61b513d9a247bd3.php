<div class="modal fade" id="<?php echo e($id ?? 'filterModal'); ?>" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel"><?php echo e($title ?? 'Filter Data'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="GET" action="<?php echo e($action ?? url()->current()); ?>">
                    <div class="row">

                        <div class="col-md-12 mb-2">
                            <label for="Date" class="form-label">Date</label>
                            <div class="position-relative">
                                <input type="text" class="form-control flatpickr-input active" id="rangecalendar-datepicker" name="date_range" value="<?php echo e(request('date_range')); ?>" placeholder="From - To" readonly="readonly">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>

                        
                        <div class="col-md-12 mb-2">
                            <label for="agent_name" class="form-label">Agent Name</label>
                            <select class="form-select" id="agent_name" name="agent_name">
                                <option selected disabled>Select Agent Name</option>
                                <?php $__currentLoopData = $agents ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($agent->id); ?>" <?php echo e(request('agent_name') == $agent->id ? 'selected' : ''); ?>>
                                        <?php echo e($agent->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-md-6 mb-2">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select js-choice" id="country" name="country">
                                <option selected disabled>Select Country</option>
                                <?php $__currentLoopData = $countries ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php echo e(request('country') == $item->id ? 'selected' : ''); ?>>
                                        <?php echo e($item->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-md-6 mb-2">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select js-choice" id="state" name="state">
                                <option selected disabled>Select State</option>
                            </select>
                        </div>

                        
                        <div class="col-md-6 mb-2">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select js-choice" id="district" name="district">
                                <option selected disabled>Select District</option>
                            </select>
                        </div>

                        
                        <div class="col-md-6 mb-2">
                            <label for="city" class="form-label">City</label>
                            <select class="form-select js-choice" id="city" name="city">
                                <option selected disabled>Select City</option>
                            </select>
                        </div>

                        
                        <div class="col-md-6 mb-2">
                            <label for="taluka" class="form-label">Taluka</label>
                            <select class="form-select js-choice" id="taluka" name="taluka">
                                <option selected disabled>Select Taluka</option>
                            </select>
                        </div>

                        
                        <div class="col-md-6 mb-2">
                            <label for="village" class="form-label">Village</label>
                            <select class="form-select js-choice" id="village" name="village">
                                <option selected disabled>Select Village</option>
                            </select>
                        </div>

                        
                        <div class="col-md-12 mt-3 d-flex justify-content-between">
                            <a href="<?php echo e(url()->current()); ?>" type="button" class="btn btn-secondary me-2">Clear</a>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('a13420f1-3ee9-43ab-8fc0-665f348b538e')): $__env->markAsRenderedOnce('a13420f1-3ee9-43ab-8fc0-665f348b538e'); ?>
    <?php $__env->startPush('script'); ?>
        
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

                    // Wait for Choices.js to be initialized
                    function waitForChoices(element, callback) {
                        if (element.choicesInstance) {
                            callback(element.choicesInstance);
                        } else {
                            setTimeout(() => waitForChoices(element, callback), 50);
                        }
                    }

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

                    function updateChoicesWithSelection(choicesInstance, data, placeholder, selectedValue) {
                        if (!choicesInstance) return;
                        choicesInstance.clearStore();
                        const choices = [{
                            value: '',
                            label: `-- ${placeholder} --`,
                            selected: !selectedValue,
                            disabled: true
                        }];
                        data.forEach(item => {
                            choices.push({
                                value: item.id,
                                label: item.name,
                                selected: item.id == selectedValue
                            });
                        });
                        choicesInstance.setChoices(choices, 'value', 'label', false);
                    }

                    // Initialize dropdowns with existing values
                    function initializeDropdowns() {
                        // Get values from URL parameters instead of select elements
                        const urlParams = new URLSearchParams(window.location.search);
                        const selectedCountry = urlParams.get('country') || $(`#country${prefix}`).val();
                        const selectedState = urlParams.get('state') || $(`#state${prefix}`).val();
                        const selectedDistrict = urlParams.get('district') || $(`#district${prefix}`).val();
                        const selectedCity = urlParams.get('city') || $(`#city${prefix}`).val();
                        const selectedTaluka = urlParams.get('taluka') || $(`#taluka${prefix}`).val();
                        const selectedVillage = urlParams.get('village') || $(`#village${prefix}`).val();
                        console.log(selectedCountry, selectedState, selectedDistrict, selectedCity, selectedTaluka, selectedVillage, 'selectedCountry, selectedState, selectedDistrict, selectedCity, selectedTaluka, selectedVillage');

                        // Load states if country is selected
                        if (selectedCountry) {
                            waitForChoices(stateSelect, function(stateChoices) {
                                $.getJSON(`/admin/settings/get-state/${selectedCountry}`).done(function(states) {
                                    updateChoicesWithSelection(stateChoices, states, 'Select State', selectedState);
                                    
                                    // Load cities if state is selected
                                    if (selectedState) {
                                        waitForChoices(citySelect, function(cityChoices) {
                                            $.getJSON(`/admin/settings/get-cities/${selectedState}`).done(function(cities) {
                                                updateChoicesWithSelection(cityChoices, cities, 'Select City', selectedCity);
                                                
                                                // Load talukas if city is selected
                                                if (selectedCity) {
                                                    waitForChoices(talukaSelect, function(talukaChoices) {
                                                        $.getJSON(`/admin/settings/get-talukas/${selectedCity}`).done(function(talukas) {
                                                            updateChoicesWithSelection(talukaChoices, talukas, 'Select Taluka', selectedTaluka);
                                                            
                                                            // Load villages if taluka is selected
                                                            if (selectedTaluka) {
                                                                waitForChoices(villageSelect, function(villageChoices) {
                                                                    $.getJSON(`/admin/settings/get-villages/${selectedTaluka}`).done(function(villages) {
                                                                        updateChoicesWithSelection(villageChoices, villages, 'Select Village', selectedVillage);
                                                                    }).fail(function() {
                                                                        updateChoices(villageChoices, [], 'Select Village');
                                                                    });
                                                                });
                                                            }
                                                        }).fail(function() {
                                                            updateChoices(talukaChoices, [], 'Select Taluka');
                                                        });
                                                    });
                                                }
                                            }).fail(function() {
                                                updateChoices(cityChoices, [], 'Select City');
                                            });
                                        });
                                    }

                                    // Load districts if state is selected
                                    if (selectedState) {
                                        waitForChoices(districtSelect, function(districtChoices) {
                                            $.getJSON(`/admin/settings/get-district/${selectedState}`).done(function(districts) {
                                                updateChoicesWithSelection(districtChoices, districts, 'Select District', selectedDistrict);
                                            }).fail(function() {
                                                updateChoices(districtChoices, [], 'Select District');
                                            });
                                        });
                                    }
                                }).fail(function() {
                                    waitForChoices(stateSelect, function(stateChoices) {
                                        updateChoices(stateChoices, [], 'Select State');
                                    });
                                });
                            });
                        }
                    }

                    // Country change event
                    $(`#country${prefix}`).on('change', function() {
                        const countryId = this.value;
                        waitForChoices(stateSelect, function(stateChoices) {
                            updateChoices(stateChoices, [], 'Loading states...');
                        });
                        waitForChoices(citySelect, function(cityChoices) {
                            updateChoices(cityChoices, [], 'Select City');
                        });
                        waitForChoices(districtSelect, function(districtChoices) {
                            updateChoices(districtChoices, [], 'Select District');
                        });
                        waitForChoices(talukaSelect, function(talukaChoices) {
                            updateChoices(talukaChoices, [], 'Select Taluka');
                        });
                        waitForChoices(villageSelect, function(villageChoices) {
                            updateChoices(villageChoices, [], 'Select Village');
                        });

                        $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                            waitForChoices(stateSelect, function(stateChoices) {
                                updateChoices(stateChoices, states, 'Select State');
                            });
                        }).fail(function() {
                            waitForChoices(stateSelect, function(stateChoices) {
                                updateChoices(stateChoices, [], 'Select State');
                            });
                        });
                    });

                    // State change event
                    $(`#state${prefix}`).on('change', function() {
                        const stateId = this.value;
                        waitForChoices(citySelect, function(cityChoices) {
                            updateChoices(cityChoices, [], 'Loading cities...');
                        });
                        waitForChoices(districtSelect, function(districtChoices) {
                            updateChoices(districtChoices, [], 'Loading districts...');
                        });
                        // Reset taluka and village
                        waitForChoices(talukaSelect, function(talukaChoices) {
                            updateChoices(talukaChoices, [], 'Select Taluka');
                        });
                        waitForChoices(villageSelect, function(villageChoices) {
                            updateChoices(villageChoices, [], 'Select Village');
                        });

                        $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                            waitForChoices(citySelect, function(cityChoices) {
                                updateChoices(cityChoices, cities, 'Select City');
                            });
                        }).fail(function() {
                            waitForChoices(citySelect, function(cityChoices) {
                                updateChoices(cityChoices, [], 'Select City');
                            });
                        });

                        $.getJSON(`/admin/settings/get-district/${stateId}`).done(function(districts) {
                            waitForChoices(districtSelect, function(districtChoices) {
                                updateChoices(districtChoices, districts, 'Select District');
                            });
                        }).fail(function() {
                            waitForChoices(districtSelect, function(districtChoices) {
                                updateChoices(districtChoices, [], 'Select District');
                            });
                        });
                    });

                    // City change event to load talukas
                    $(`#city${prefix}`).on('change', function() {
                        const cityId = this.value;
                        waitForChoices(talukaSelect, function(talukaChoices) {
                            updateChoices(talukaChoices, [], 'Loading talukas...');
                        });
                        waitForChoices(villageSelect, function(villageChoices) {
                            updateChoices(villageChoices, [], 'Select Village');
                        });

                        if (cityId) {
                            $.getJSON(`/admin/settings/get-talukas/${cityId}`).done(function(talukas) {
                                waitForChoices(talukaSelect, function(talukaChoices) {
                                    updateChoices(talukaChoices, talukas, 'Select Taluka');
                                });
                            }).fail(function() {
                                waitForChoices(talukaSelect, function(talukaChoices) {
                                    updateChoices(talukaChoices, [], 'Select Taluka');
                                });
                            });
                        }
                    });

                    // Taluka change event to load villages
                    $(`#taluka${prefix}`).on('change', function() {
                        const talukaId = this.value;
                        waitForChoices(villageSelect, function(villageChoices) {
                            updateChoices(villageChoices, [], 'Loading villages...');
                        });

                        if (talukaId) {
                            $.getJSON(`/admin/settings/get-villages/${talukaId}`).done(function(villages) {
                                waitForChoices(villageSelect, function(villageChoices) {
                                    updateChoices(villageChoices, villages, 'Select Village');
                                });
                            }).fail(function() {
                                waitForChoices(villageSelect, function(villageChoices) {
                                    updateChoices(villageChoices, [], 'Select Village');
                                });
                            });
                        }
                    });

                    // Initialize dropdowns when modal is shown
                    $(`#${$('#filterModal').attr('id') || 'filterModal'}`).on('shown.bs.modal', function() {
                        initializeDropdowns();
                    });

                    // Also initialize on page load if there are existing values
                    const urlParams = new URLSearchParams(window.location.search);
                    const selectedCountry = urlParams.get('country') || $(`#country${prefix}`).val();
                    const selectedState = urlParams.get('state') || $(`#state${prefix}`).val();
                    const selectedDistrict = urlParams.get('district') || $(`#district${prefix}`).val();
                    const selectedCity = urlParams.get('city') || $(`#city${prefix}`).val();
                    const selectedTaluka = urlParams.get('taluka') || $(`#taluka${prefix}`).val();
                    const selectedVillage = urlParams.get('village') || $(`#village${prefix}`).val();
                    console.log(selectedCountry, selectedState, selectedDistrict, selectedCity, selectedTaluka, selectedVillage, 'selectedCountry, selectedState, selectedDistrict, selectedCity, selectedTaluka, selectedVillage');
                    if (selectedCountry || selectedState || selectedDistrict || selectedCity || selectedTaluka || selectedVillage) {
                        // Wait a bit for Choices.js to be ready
                        setTimeout(initializeDropdowns, 200);
                    }
                }

                // Initialize for both sets of dropdowns
                setupLocationHandlers('');
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#rangecalendar-datepicker", {
                mode: "range",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "Y-m-d to Y-m-d",
                allowInput: true
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/components/filter-modal.blade.php ENDPATH**/ ?>