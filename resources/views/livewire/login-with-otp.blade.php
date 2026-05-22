<div class="pt-0" x-data="{
    init() {
        if (localStorage.getItem('remember') === 'true') {
            @this.set('email', localStorage.getItem('email'));
            @this.set('password', localStorage.getItem('password'));
            @this.set('remember', true);
        }
    },
    save() {
        if (@this.get('remember')) {
            localStorage.setItem('email', @this.get('email'));
            localStorage.setItem('password', @this.get('password'));
            localStorage.setItem('remember', 'true');
        } else {
            localStorage.removeItem('email');
            localStorage.removeItem('password');
            localStorage.removeItem('remember');
        }
    }
}" x-init="init" @save-login-data.window="save()">

    @if ($step === 'login')
        <form wire:submit.prevent="login" class="my-4">
            <div class="form-group mb-3">
                <label for="emailaddress" class="form-label">Email address <x-required-star /> </label>
                <input class="form-control" type="email" id="emailaddress"  wire:model.defer="email" placeholder="Enter your email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <div class="form-group mb-3">
                    <label for="password" class="form-label">
                        Password <x-required-star />
                    </label>

                    <div class="input-group">
                        <input type="{{ $showPassword ? 'text' : 'password' }}" class="form-control" id="password"  wire:model.defer="password" placeholder="Enter your password">


                        <button type="button" class="btn btn-outline-dark" wire:click="$toggle('showPassword')">
                            @if ($showPassword)
                                <i class="ri-eye-off-line"></i>
                            @else
                                <i class="ri-eye-line"></i>
                            @endif
                        </button>
                    </div>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
                    <a class='forgot-text' href='{{ url('forgot-password') }}'>Forgot password?</a>
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
    @elseif ($step === 'otp')
        <form wire:submit.prevent="verifyOtp" class="my-4">
            <div class="form-group mb-3">
                <label for="otp" class="form-label">Enter OTP <x-required-star /></label>
                <input class="form-control" type="text" id="otp" required wire:model.defer="otp" placeholder="Enter the OTP sent to your email">
                @error('otp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
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
    @endif
</div>
