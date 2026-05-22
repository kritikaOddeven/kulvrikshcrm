<?php $__env->startSection('pagetitle','Profile | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="page-title">Profile</h4>
        <p>Profile</p>
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
        <!-- <img src="<?php echo e(asset('assets/admin/images/small/user-image.jpg')); ?>" class="rounded-top-2 img-fluid" alt="image data"> -->
        <div class="profile-backbox"></div>
        <div class="hando-main-sections">
            <form action="<?php echo e(route('admin.profile.update-image')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="hando-profile-main position-relative">
                    <img src="<?php echo e(asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name))); ?>"
                        class="rounded-circle img-fluid avatar-xxl img-thumbnail float-start" alt="Profile Image"
                        id="profileImagePreview">

                    <label for="profileImageInput" class="sil-profile_main-pic-change img-thumbnail position-absolute"
                        style="top: 80px; left: auto; cursor: pointer; right: 0;">
                        <i class="ri-camera-ai-line text-white"></i>
                    </label>

                    <input type="file" name="profile_image" id="profileImageInput" accept=".png, .jpg, .jpeg"
                        style="display: none;" onchange="this.form.submit()">
                </div>

            </form>
            <div class="overflow-hidden">
                <h4 class="card-title"><?php echo e($user->name); ?></h4>
                <span class="fs-15">India</span></span>
            </div>
        </div>
        <?php $__errorArgs = ['profile_image'];
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


<div class="row">
    <div class="col-lg-3 col-md-12">
        <div class="card">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_profile')): ?>
                <a class="nav-link <?php echo e(!session('password_error') ? 'active' : ''); ?>" id="v-pills-profile-tab"
                    data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                    aria-selected="<?php echo e(!session('password_error') ? 'true' : 'false'); ?>">Personal Information</a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update_password')): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_profile')): ?>

                <a class="nav-link <?php echo e(session('password_error') ? 'active' : ''); ?>" id="v-pills-password-tab"
                    data-bs-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password"
                    aria-selected="<?php echo e(session('password_error') ? 'true' : 'false'); ?>" tabindex="-1">Change Password</a>

                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-12">

        <div class="tab-content p-0 text-muted mt-md-0" id="v-pills-tabContent">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_profile')): ?>
            <div class="tab-pane fade <?php echo e(!session('password_error') ? 'active show' : ''); ?>" id="v-pills-profile"
                role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="profile">
                            <h4 class="card-title">Personal Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.update.profile')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Name
                                            <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="text" name="name"
                                                value="<?php echo e($user->name); ?>">
                                            <span class="text-danger">
                                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <?php echo e($message); ?>

                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Role
                                            <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <?php
                                            $roleName = $user->roles->pluck('name')->first() ?? '';
                                            $formattedRoleName = ucwords(str_replace(['_', '-'], ' ', $roleName));
                                            ?>
                                            <input class="form-control" type="text" disabled name=""
                                                value="<?php echo e($formattedRoleName ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Phone</label>
                                        <div class="col-lg-12 col-xl-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-phone-line"></i></span>
                                                <input class="form-control" type="text" placeholder="Phone" name="phone"
                                                    value="<?php echo e($user->phone); ?>" maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Email
                                            <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-mail-line"></i></span>
                                                <input type="text" class="form-control" value="<?php echo e($user->email); ?>"
                                                    placeholder="Email" name="email">
                                                <span class="text-danger">
                                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <?php echo e($message); ?>

                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update_profile')): ?>
                                <div class="col-lg-12 col-xl-12 text-end">
                                    <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update_password')): ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_profile')): ?>
            <div class="tab-pane fade <?php echo e(session('password_error') ? 'active show' : ''); ?>" id="v-pills-password"
                role="tabpanel" aria-labelledby="v-pills-password-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="profile">
                            <h4 class="card-title">Change Password</h4>
                        </div>
                    </div>

                    <div class="card-body mb-0">
                        <form action="<?php echo e(route('admin.update.password')); ?>" method="POST" class="needs-validation">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" value="<?php echo e($user->email); ?>">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Old Password
                                            <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="password" name="current_password"
                                                placeholder="Old Password">
                                            <?php $__errorArgs = ['current_password'];
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
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">New Password
                                            <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="password" id="new_password"
                                                name="new_password" placeholder="New Password">
                                            <?php $__errorArgs = ['new_password'];
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
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Confirm Password<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="password" id="confirm_password"
                                                name="password_confirmation" placeholder="Confirm Password">
                                            <span id="password_error" style="color:red; font-size: 14px;"></span>
                                            <?php $__errorArgs = ['password_confirmation'];
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
                                </div>
                                <div class="col-lg-12 col-xl-12 text-end">
                                    <button type="submit" class="btn btn-primary mb-2 mb-md-0">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
              <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        const errorSpan = document.getElementById('password_error');

        confirmPassword.addEventListener('input', function() {
            if (newPassword.value !== confirmPassword.value) {
                errorSpan.textContent = "Passwords do not match.";
            } else {
                errorSpan.textContent = "";
            }
        });
    });
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/profile.blade.php ENDPATH**/ ?>