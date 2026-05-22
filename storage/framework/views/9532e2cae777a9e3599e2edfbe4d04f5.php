<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
            Lead Wife Information
        </button>
    </h2>
    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="wife_first_name">
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="wife_middle_name">
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="wife_last_name">
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">DOB</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker pe-5" name="wife_dob"  placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                    
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Marriage Date</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker pe-5" name="wife_marriage_date"  placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                    
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Death Date</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker pe-5" name="wife_death_date"  placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                    
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Phone No.</label>
                    <div class="input-group">
                        <input type="hidden" name="wife_phonecode" value="<?php echo e(old('wife_phonecode') ?? '+91'); ?>">
                        <span class="input-group-text" id="wife_phonecode">+91</span>
                        <input type="text" class="form-control" value="<?php echo e(old('wife_phone')); ?>" name="wife_phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Email</label>
                    <input type="email" class="form-control" name="wife_email">
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label w-100">Country</label>
                    <select class="form-select js-choice w-100" id="country1" name="wife_country">
                        <option disabled>Select Country</option>
                        <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e($item->name == 'India' ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">State</label>
                    <select class="form-select js-choice" id="state1" name="wife_state">
                        <option selected disabled>Select State</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">District</label>
                    <select class="form-select js-choice" id="district1" name="wife_district">
                        <option selected disabled>Select District</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">City</label>
                    <select class="form-select js-choice" id="city1" name="wife_city">
                        <option selected disabled>Select City</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="taluka1" class="form-label">Taluka</label>
                    <select class="form-select js-choice" id="taluka1" name="wife_taluka">
                        <option disabled selected>Select Taluka</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="village1" class="form-label">Village</label>
                    <select class="form-select js-choice" id="village1" name="wife_village">
                        <option disabled selected>Select Village</option>
                    </select>
                </div>

                <div class="col-md-6 ">
                    <label for="validationDefault01" class="form-label">Notes/Address</label>
                    <textarea class="form-control" id="notes_address" name="wife_notes_address" rows="2"></textarea>
                </div>

            </div>
        </div>

    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/partials/lead-wife.blade.php ENDPATH**/ ?>