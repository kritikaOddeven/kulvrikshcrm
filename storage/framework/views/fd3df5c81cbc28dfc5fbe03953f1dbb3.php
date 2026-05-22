<?php $__env->startSection('pagetitle','Lead report | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <style>
        .select2-container--open {
            z-index: 999999 !important;
        }
    </style>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Total Lead Report</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                <li class="breadcrumb-item active">Total Lead Report</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <button class="btn btn-secondary mt-md-0" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="ri-equalizer-line"></i> Filter
            </button>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_report_export')): ?>
            <a href="<?php echo e(url('admin/reports/lead?export=csv')); ?>" type="button" class="btn btn-primary">
                <i class="ri-download-2-line"></i> Export to CSV
            </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">

                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>Ref. Id</th>
                                <th>Agent Name</th>
                                <th>Client Name</th>
                                <th>Caste</th>
                                <th>Date</th>
                                <th>Phone No.</th>
                                <th>Email Id</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Taluka</th>
                                <th>Village</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?php echo $__env->make('components.filter-modal', [
        'id' => 'filterModal',
        'title' => 'Filter',
        'action' => url('admin/reports/lead'),
        'agents' => $agents,
        'countries' => $countries,
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            function getParam(name) {
                const url = new URL(window.location.href);
                return url.searchParams.get(name);
            }
            
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo e(route('admin.reports.lead.datatable')); ?>',
                    data: function(d) {
                        d.agent_name = getParam('agent_name');
                        d.country = getParam('country');
                        d.state = getParam('state');
                        d.district = getParam('district');
                        d.city = getParam('city');
                        d.taluka = getParam('taluka');
                        d.village = getParam('village');
                        d.date_range = getParam('date_range');
                    }
                },
                columns: [
                    {
                        data: 'ref_id'
                    },
                    {
                        data: 'user.name',
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'client_name'
                    },
                    {
                        data: 'caste',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'created_date'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'country_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'state_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'district_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'city_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'taluka',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'village',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'status',
                        orderable: true,
                        searchable: false
                    }
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/reports/total-lead.blade.php ENDPATH**/ ?>