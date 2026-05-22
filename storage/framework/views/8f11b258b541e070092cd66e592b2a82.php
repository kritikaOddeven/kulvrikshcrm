<?php $__env->startSection('pagetitle', 'Add Researcher Report | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Add Research Reports</h4>
            
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashborad</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo e(url('admin/research-reports')); ?>">View All Research Reports</a></li>
                <li class="breadcrumb-item active">Add Research Reports</li>
            </ol>
        </div>
    </div>
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

    <div class="row">
        <div class="col-xl-12">
            <form action="<?php echo e(url('admin/research-reports/store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 ms-auto mb-2">
                                <select class="form-control" id="toLang" name="translated_language">
                                    <option value="en" <?php echo e($report->translated_language == 'en' ? 'selected' : ''); ?>>English</option>
                                    <option value="hi" <?php echo e($report->translated_language == 'hi' ? 'selected' : ''); ?>>Hindi</option>
                                    <option value="gu" <?php echo e($report->translated_language == 'gu' ? 'selected' : ''); ?>>Gujarati</option>
                                    <option value="mr" <?php echo e($report->translated_language == 'mr' ? 'selected' : ''); ?>>Marathi</option>
                                    
                                </select>
                            </div>

                            <div class="col-md-6 text-end">
                                <button class="btn btn-primary">Apply</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <input type="hidden" name="client_id" value="<?php echo e(request()->id); ?>">
                        <div class="mb-2">
                            <label for="top_tagline" class="form-label">Top Tagline (तिथि )</label>
                            <textarea name="top_tagline" class="form-control" maxlength="350" placeholder="Description"><?php echo e($report->top_tagline ?? ''); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" class="form-control" placeholder="Enter Name" value="<?php echo e($report->name ?? ''); ?> <?php echo e($report->lead->first_name ?? ''); ?> <?php echo e($report->lead->middle_name ?? ''); ?> <?php echo e($report->lead->last_name ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="lineage" class="form-label">Lineage</label>
                                <input name="lineage" class="form-control" placeholder="Enter Lineage" value="<?php echo e($lineage->lineage ?? $report->lineage); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="caste" class="form-label">Caste</label>
                                <input name="caste" class="form-control" placeholder="Enter Caste" value="<?php echo e($report->caste ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="subspecies" class="form-label">SubCaste</label>
                                <input name="subspecies" class="form-control" placeholder="Enter Subspecies" value="<?php echo e($report->subspecies ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="surname" class="form-label">Surname</label>
                                <input name="surname" class="form-control" placeholder="Enter Surname" value="<?php echo e($lineage->surname ?? $report->surname); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="credit" class="form-label">Branch</label>
                                <input name="credit" class="form-control" placeholder="Enter Credit" value="<?php echo e($report->credit ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="gotra" class="form-label">Gotra</label>
                                <input name="gotra" class="form-control" placeholder="Enter Gotra" value="<?php echo e($lineage->gotra ?? $report->gotra); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="pravar" class="form-label">Pravar</label>
                                <input name="pravar" class="form-control" placeholder="Enter Pravar" value="<?php echo e($report->pravar ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="vedas" class="form-label">Vedas</label>
                                <input name="vedas" class="form-control" placeholder="Enter Vedas" value="<?php echo e($report->vedas ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="upaveda" class="form-label">Upaveda</label>
                                <input name="upaveda" class="form-control" placeholder="Enter Upaveda" value="<?php echo e($report->upaveda ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="branch" class="form-label">Shakha</label>
                                <input name="branch" class="form-control" placeholder="Enter Branch" value="<?php echo e($report->branch ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="peak" class="form-label">Sikha</label>
                                <input name="peak" class="form-control" placeholder="Enter Peak" value="<?php echo e($report->peak ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="formula" class="form-label">Sutra</label>
                                <input name="formula" class="form-control" placeholder="Enter Formula" value="<?php echo e($report->formula ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="gotra_devi" class="form-label">Gotra Devi</label>
                                <input name="gotra_devi" class="form-control" placeholder="Enter Gotra Devi" value="<?php echo e($report->gotra_devi ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="ishta_devi" class="form-label">Ishta Devi</label>
                                <input name="ishta_devi" class="form-control" placeholder="Enter Ishta Devi" value="<?php echo e($report->ishta_devi ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="ishtadev" class="form-label">Ishtadev</label>
                                <input name="ishtadev" class="form-control" placeholder="Enter Ishtadev" value="<?php echo e($report->ishtadev ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="kuldevi" class="form-label">Kuldevi</label>
                                <input name="kuldevi" class="form-control" placeholder="Enter Kuldevi" value="<?php echo e($lineage->kuldevi ?? $report->kuldevi); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="kuldevata" class="form-label">Kuldevata</label>
                                <input name="kuldevata" class="form-control" placeholder="Enter Kuldevata" value="<?php echo e($lineage->kuldevta ?? $report->kuldevata); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="supportive_mother" class="form-label">Sahayak Dev</label>
                                <input name="supportive_mother" class="form-control" placeholder="Enter Supportive Mother" value="<?php echo e($report->supportive_mother ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="river" class="form-label">River</label>
                                <input name="river" class="form-control" placeholder="Enter River" value="<?php echo e($report->river ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="ancestor_shrine" class="form-label">Ancestor Shrine</label>
                                <input name="ancestor_shrine" class="form-control" placeholder="Enter Ancestor Shrine" value="<?php echo e($report->ancestor_shrine ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="tirth_purohit" class="form-label">Tirth Purohit</label>
                                <input name="tirth_purohit" class="form-control" placeholder="Enter Tirth Purohit" value="<?php echo e($report->tirth_purohit ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="original_location" class="form-label">Original Location</label>
                                <input name="original_location" class="form-control" placeholder="Enter Original Location" value="<?php echo e($report->original_location ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="kuldevi_dash" class="form-label">Kuldevi Dosh</label>
                                <input name="kuldevi_dash" class="form-control" placeholder="Enter Kuldevi Dosh" value="<?php echo e($report->kuldevi_dash ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="patriarchy" class="form-label">Pitru Dosh</label>
                                <input name="patriarchy" class="form-control" placeholder="Enter Patriarchy" value="<?php echo e($report->patriarchy ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="image" class="form-label">Image Upload</label>
                                <input type="file" name="image" class="form-control">
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kul_tagline" class="form-label">Kul Tag Line</label>
                            <textarea name="kul_tagline" class="form-control" placeholder="Description" maxlength="100"><?php echo e($report->kul_tagline ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title (कुलदेवी  नैवेध)</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title" maxlength="100" value="<?php echo e($report->title ?? ''); ?>">
                        </div>

                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="Description"><?php echo e($report->description ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="history_title" class="form-label">History Title</label>
                            <input type="text" name="history_title" class="form-control" placeholder="Enter History Title" maxlength="100" value="<?php echo e($report->history_title ?? ''); ?>">
                        </div>

                        <div class="mb-2">
                            <label for="history_description" class="form-label">History Description</label>
                            <textarea name="history_description" class="form-control" placeholder="History Description"><?php echo e($report->history_description ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(url('admin/research-reports/view/' . request()->id)); ?>" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/researchers/reports/edit-report.blade.php ENDPATH**/ ?>