<?php $__env->startSection('pagetitle', 'Client | Kulvriksh'); ?>
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
    <div class="row py-3 align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Clients</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active">View All Clients</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <button class="btn btn-secondary mt-md-0 me-2" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="ri-equalizer-line"></i> Filter
            </button>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_client')): ?>
                <a href="<?php echo e(url('/admin/clients/create')); ?>" type="button" class="btn btn-primary">+ Add Client</a>
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
                                <th>KV Id</th>
                                <th>Client Name</th>
                                <th>Caste</th>
                                <th>Researcher Name</th>
                                <th>Agent Name</th>
                                <th>Project Name</th>
                                <th>Date</th>
                                <th>Email Id</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>District</th>
                                <th>City</th>
                                <th>Taluka</th>
                                <th>Village</th>
                                <th data-orderable="false">Action</th>
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
        'action' => url('admin/clients'),
        'agents' => $agents,
        'countries' => $countries,
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    
    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('admin.clients.modals.assing-researcher', ['client' => $client, 'researchers' => $researchers], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script>
        $(document).ready(function() {
            function getParam(name) {
                const url = new URL(window.location.href);
                return url.searchParams.get(name);
            }
        
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                order: [[7, 'desc']], // Sort by Date column (index 7) in descending order
                ajax: {
                    url: '<?php echo e(route('admin.clients.datatable')); ?>',
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
                    { data: 'ref_id',  name: 'clients.id', },
                    { data: 'kulvrisk_id' },
                    { data: 'client_name', render: data => data || '' },
                    { data: 'caste', orderable: true, searchable: true, render: data => data || '' },
                    { data: 'researcher_name', orderable: true, searchable: true },
                    { data: 'user.name', render: data => data || '' },
                    { data: 'project_name', orderable: true, searchable: true, render: data => data || '' },
                    { data: 'date' },
                    { data: 'email', name: 'lead.email' },
                    { data: 'phone', orderable: true, searchable: true },
                    { data: 'lead.countries.name', render: data => data || '' },
                    { data: 'lead.states.name', render: data => data || '' },
                    { data: 'lead.districts.name', render: data => data || '' },
                    { data: 'lead.cities.name', render: data => data || '' },
                    { data: 'taluka_name', render: data => data || '' },
                    { data: 'village_name', render: data => data || '' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        
            // ✅ Reinitialize buttons & modals after each DataTable redraw
            table.on('draw.dt', function() {
        
                // Rebind delete buttons
                $(document).off('click', '.delete-icon-btn').on('click', '.delete-icon-btn', function() {
                    const id = $(this).closest('form').attr('id').replace('deleteForm_', '');
                    deleteAccount(this, id);
                });
        
                // Rebind Bootstrap modal triggers
                $(document).off('click', '[data-bs-toggle="modal"]').on('click', '[data-bs-toggle="modal"]', function(e) {
                    const target = $(this).data('bs-target');
                    if (target) $(target).modal('show');
                });
        
                // (Optional) Re-enable tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
            });
        });
        
        // ✅ Make deleteAccount globally available
        window.deleteAccount = function(btn, id) {
            if (confirm('Are you sure you want to delete this client?')) {
                document.getElementById('deleteForm_' + id).submit();
            }
        };
        </script>
        

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/clients/index.blade.php ENDPATH**/ ?>