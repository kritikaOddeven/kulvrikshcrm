<?php $__env->startSection('pagetitle', 'View Report | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <style>
        .info-table th,
        .info-table td {
            border: none;
        }

        .avatar-initials {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #6c757d;
            color: #fff;
            font-weight: bold;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 14px;
            text-transform: uppercase;
        }
    </style>
    <div class="row py-3 align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View Researcher</h4>
            
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/researcher')); ?>">Researcher</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo e(url('admin/research-reports')); ?>">View All Researcher Report</a></li>
                <li class="breadcrumb-item active">View Research Report</li>
            </ol>
        </div>
        <?php if(!$data->deleted_at): ?>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_researcher_report_whatsapp')): ?>
                <a href="" type="button" class="whatsapp-icon-btn"><i class="ri-whatsapp-line"></i></a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_researcher_report_email')): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('send-lead-email', ['lead' => $data->lead]);

$__html = app('livewire')->mount($__name, $__params, $data->lead->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preview_researcher_report')): ?>
                <?php if($data->report && $data->report->exists()): ?>
                    <a href="<?php echo e(url('admin/research-reports/pdf1/' . $data->id) . '?preview=true'); ?>" type="button" data-bs-toggle="tooltip" title="preview" class="btn btn-success"><i class="ri-printer-line"></i> Preview</a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fill_researcher_report_form')): ?>
                <a href="<?php echo e(url('admin/research-reports/edit/' . $data->id)); ?>" class="btn btn-primary mr-1" data-bs-toggle="tooltip" title="edit"><i class="ri-edit-line"></i> Fill Form</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card lead-view-box">
                <div class="accordion" id="accordionPanelsStayOpenExample">

                    <div class="accordion-item">

                        <div id="panelsStayOpen-collapse" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <table class="table info-table">
                                    <tbody>
                                        <?php
                                            $assign_researchers = getResearchersWithNames(json_decode($data->researcher_ids ?? '[]', true))['researchers'];
                                            $projectData = getProjectsWithNames('parent', json_decode($data->project_ids ?? '[]', true));
                                            $subProjectData = getProjectsWithNames('subproject', json_decode($data->sub_project_ids ?? '[]', true));
                                        ?>
                                        <tr>
                                            <th>KV ID</th>
                                            <td>:</td>
                                            <td class="ps-3"><?php echo e($data->kulvrisk_id ?? ''); ?></td>

                                            <th>Researhcer Name</th>
                                            <td>:</td>
                                            <td class="ps-3">
                                                <div>
                                                    <?php $__currentLoopData = $assign_researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="me-2"><?php echo e($researcher->name); ?></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </td>

                                            <th>Payment Mode</th>
                                            <td>:</td>
                                            <td class="ps-3"><?php echo e($data->payment_mode ? paymentMode($data->payment_mode) : ''); ?></td>

                                            <th>Image</th>
                                            <td>:</td>
                                            <td class="ps-3">
                                                <?php if(!empty($data->image_path) && file_exists(public_path($data->image_path))): ?>
                                                    <?php
                                                        $extension = strtolower(pathinfo($data->image_path, PATHINFO_EXTENSION));
                                                    ?>

                                                    <?php if(in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                                                        <a href="<?php echo e(asset($data->image_path)); ?>" target="_blank">
                                                            <img src="<?php echo e(asset($data->image_path)); ?>" alt="Image" width="50">
                                                        </a>
                                                    <?php elseif($extension === 'pdf'): ?>
                                                        <a href="<?php echo e(asset($data->image_path)); ?>" target="_blank">
                                                            <img src="<?php echo e(asset('assets/admin/images/pdf.png')); ?>" alt="PDF File" width="50">
                                                        </a>
                                                    <?php else: ?>
                                                        <p>Unsupported file type</p>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <p>No file available</p>
                                                <?php endif; ?>
                                        </tr>
                                        <tr>
                                            <th>Project</th>
                                            <td>:</td>
                                            <td class="ps-3"><?php echo e($projectData['names']); ?></td>

                                            <th>Sub Project</th>
                                            <td>:</td>
                                            <td class="ps-3"><?php echo e($subProjectData['names']); ?></td>
                                            <th>Start Date</th>
                                            <td>:</td>
                                            <td class="ps-3"><?php echo e($data->start_date ?? ''); ?></td>
                                            <th>End Date</th>
                                            <td>:</td>
                                            <td class="ps-3"><?php echo e($data->end_date ?? ''); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <?php echo $__env->make('admin.leads.details.lead-info', ['data' => $data->lead], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.lineage-info', ['data' => $data->lead], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.family-info', ['data' => $data->lead], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.wife-info', ['data' => $data->lead], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.wife-family-info', ['data' => $data->lead], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.wife-lineage-info', ['data' => $data->lead], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.children-info', ['data' => $data->lead], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    
                    <div class="accordion-item">

                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="true" aria-controls="panelsStayOpen-collapseEight">
                                Notes
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="row">


                                    <?php $__currentLoopData = $data->lead->leadNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-12 mb-2">
                                            <div class="d-flex justify-content-between mb-1">
                                                <label class="d-flex align-items-center mb-2 form-label">
                                                    <img src="<?php echo e(asset(get_profile_image($item->user->profile_image, $item->user->name))); ?>" class="avatar avatar-sm rounded-circle me-2">
                                                    <?php echo e($item->user->name ?? ''); ?>

                                                </label>
                                                <span class="text-end form-label"><?php echo e($item->created_at->format('D d F, g:i')); ?></span>
                                            </div>

                                            <p name="content" rows="10" readonly><?php echo e(strip_tags($item->content)); ?></p>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <div class="row">
                                        <h5 class="form-label"><u>Researcher Conversation</u></h5>
                                        <?php $__currentLoopData = $data->conversation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $nameParts = explode(' ', $item->user->name ?? '');
                                                $initials = '';
                                                if (count($nameParts) > 0) {
                                                    $initials .= strtoupper(substr($nameParts[0], 0, 1));
                                                    if (count($nameParts) > 1) {
                                                        $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                                    }
                                                }
                                            ?>
                                            <div class="col-md-12 mb-2">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <label class="d-flex align-items-center mb-2 form-label">
                                                        <img src="<?php echo e(asset(get_profile_image($item->user->profile_image, $item->user->name))); ?>" class="avatar avatar-sm rounded-circle me-2">
                                                        <?php echo e($item->user->name ?? ''); ?>

                                                    </label>
                                                    <span class="text-end form-label"><?php echo e($item->created_at->format('D d F, g:i')); ?></span>
                                                </div>
                                                <p name="content" rows="10" readonly><?php echo e(strip_tags($item->content)); ?></p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <div class="row">
                                        <h5 class="form-label"><u>Researcher View</u></h5>

                                        <?php $__currentLoopData = $data->researcherView; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $nameParts = explode(' ', $item->user->name ?? '');
                                                $initials = '';
                                                if (count($nameParts) > 0) {
                                                    $initials .= strtoupper(substr($nameParts[0], 0, 1));
                                                    if (count($nameParts) > 1) {
                                                        $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                                    }
                                                }
                                            ?>
                                            <div class="col-md-12 mb-2">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <label class="d-flex align-items-center mb-2 form-label">
                                                        <img src="<?php echo e(asset(get_profile_image($item->user->profile_image, $item->user->name))); ?>" class="avatar avatar-sm rounded-circle me-2">
                                                        <?php echo e($item->user->name ?? ''); ?>

                                                    </label>
                                                    <span class="text-end form-label"><?php echo e($item->created_at->format('D d F, g:i')); ?></span>
                                                </div>
                                                <p name="content" rows="10" readonly><?php echo e(strip_tags($item->content)); ?></p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/researchers/reports/view.blade.php ENDPATH**/ ?>