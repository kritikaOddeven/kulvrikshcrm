<div class="pt-0" x-data="{
    init() {
        if (localStorage.getItem('remember') === 'true') {
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('email', localStorage.getItem('email'));
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('password', localStorage.getItem('password'));
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('remember', true);
        }
    },
    save() {
        if (window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('remember')) {
            localStorage.setItem('email', window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('email'));
            localStorage.setItem('password', window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('password'));
            localStorage.setItem('remember', 'true');
        } else {
            localStorage.removeItem('email');
            localStorage.removeItem('password');
            localStorage.removeItem('remember');
        }
    }
}" x-init="init" @save-login-data.window="save()">

    <!--[if BLOCK]><![endif]--><?php if($step === 'login'): ?>
        <form wire:submit.prevent="login" class="my-4">
            <div class="form-group mb-3">
                <label for="emailaddress" class="form-label">Email address <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
<?php endif; ?> </label>
                <input class="form-control" type="email" id="emailaddress"  wire:model.defer="email" placeholder="Enter your email">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="form-group mb-3">
                <div class="form-group mb-3">
                    <label for="password" class="form-label">
                        Password <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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

                    <div class="input-group">
                        <input type="<?php echo e($showPassword ? 'text' : 'password'); ?>" class="form-control" id="password"  wire:model.defer="password" placeholder="Enter your password">


                        <button type="button" class="btn btn-outline-dark" wire:click="$toggle('showPassword')">
                            <!--[if BLOCK]><![endif]--><?php if($showPassword): ?>
                                <i class="ri-eye-off-line"></i>
                            <?php else: ?>
                                <i class="ri-eye-line"></i>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </button>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>


            </div>


            <div class="form-group d-flex mb-3 align-items-center">
                <div class="col-sm-6">
                    <div class="form-check form-switch mt-1">
                        <input class="form-check-input permission-checkbox mt-0" type="checkbox" id="checkbox-signin" wire:model="remember" @change="save()">
                        <label class="form-check-label forgot-text" for="checkbox-signin">Remember me</label>
                    </div>
                </div>
                <div class="col-sm-6 text-end">
                    <a class='forgot-text' href='<?php echo e(url('forgot-password')); ?>'>Forgot password?</a>
                </div>
            </div>

            <div class="form-group mb-0 row">
                <div class="col-12">
                    <div class="d-grid">
                        <button class="btn btn-primary fw-semibold" type="submit" wire:loading.attr="disabled" wire:target="login">
                            <span wire:loading.remove wire:target="login">Sign In</span>
                            <span wire:loading wire:target="login">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>

                    </div>
                </div>
            </div>
        </form>
    <?php elseif($step === 'otp'): ?>
        <form wire:submit.prevent="verifyOtp" class="my-4">
            <div class="form-group mb-3">
                <label for="otp" class="form-label">Enter OTP <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                <input class="form-control" type="text" id="otp" required wire:model.defer="otp" placeholder="Enter the OTP sent to your email">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="form-group mb-0 row">
                <div class="col-12">
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="verifyOtp">
                            <span wire:loading.remove wire:target="verifyOtp">Verify OTP</span>
                            <span wire:loading wire:target="verifyOtp">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>

                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/livewire/login-with-otp.blade.php ENDPATH**/ ?>