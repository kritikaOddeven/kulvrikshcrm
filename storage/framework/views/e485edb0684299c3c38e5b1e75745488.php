
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
            aria-controls="panelsStayOpen-collapseOne">
            Lead Information
        </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <table class="table info-table">
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->first_name ?? ''); ?></td>
                        <th>Middle Name</th>
                        <td>:</td>

                        <td class="ps-3"><?php echo e($data->middle_name ?? ''); ?></td>
                        <th>Last Name</th>
                        <td>:</td>

                        <td class="ps-3"><?php echo e($data->last_name ?? ''); ?></td>
                        <th>DOB</th>
                        <td>:</td>

                        <td class="ps-3"><?php echo e($data->birth_date ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Marriage Date</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->marriage_date ?? ''); ?></td>
                        <th>Phone No.</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->phone ?? ''); ?></td>
                        <th>Email</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->email ?? ''); ?></td>
                        <th>Country</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->countries->name ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->states->name ?? ''); ?></td>
                        <th>District</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->districts->name ?? ''); ?></td>
                        <th>City</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->cities->name ?? ''); ?></td>
                        <th>Taluka</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->talukas->name ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Village</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->villages->name ?? ''); ?></td>

                        <th>Alternate Mobile number</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e($data->alternate_mobile_number ?? ''); ?></td>
                        
                        <th>Address</th>
                        <td>:</td>
                        <td class="ps-3" colspan="5"><?php echo e($data->notes ?? ''); ?></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/details/lead-info.blade.php ENDPATH**/ ?>