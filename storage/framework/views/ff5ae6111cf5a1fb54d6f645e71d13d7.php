<?php $__env->startSection('pagetitle','Client Report | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <style>
        .avatar-list-stack {
            display: flex;
            align-items: center;
        }

        .avatar-list-stack .avatar {
            border: 2px solid #fff;
            z-index: 1;
            position: relative;
        }

        .avatar-list-stack .avatar:first-child {
            margin-left: 0;
        }

        .avatar-list-stack .avatar.more {
            background-color: #3394df;
            color: #fff;
        }
    </style>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Total Client Reort</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                <li class="breadcrumb-item active">Total Client Report</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <button class="btn btn-secondary mt-md-0" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="ri-equalizer-line"></i> Filter
            </button>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client_report_export')): ?>
            <a href="<?php echo e(url('admin/reports/client?export=csv')); ?>" type="button" class="btn btn-primary">
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
                                <th>KV ID</th>
                                <th>Client Name</th>
                                <th>Caste</th>
                                <th>Researcher Name</th>
                                <th>Agent Name</th>
                                <th>Project Name</th>
                                <th>Date</th>
                                <th>Email Id</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Taluka</th>
                                <th>Village</th>
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
        'action' => url('admin/reports/client'),
        'agents' => $agents,
        'countries' => $countries,
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            function getParam(name) {
                const url = new URL(window.location.href);
                return url.searchParams.get(name);
            }
            
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo e(route('admin.reports.client.datatable')); ?>',
                    data: function(d) {
                        d.agent_name = getParam('agent_name');
                        d.country = getParam('country');
                        d.state = getParam('state');
                        d.district = getParam('district');
                        d.city = getParam('city');
                        d.taluka = getParam('taluka');
                        d.village = getParam('village');
                    }
                },
                columns: [
                    {
                        data: 'ref_id'
                    },
                    {
                        data: 'kulvrisk_id'
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
                        data: 'researcher_name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user.name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'project_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'country',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'state',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'district',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data || '';
                        }
                    },
                    {
                        data: 'city',
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
                    }
                ],
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/reports/total-client.blade.php ENDPATH**/ ?>