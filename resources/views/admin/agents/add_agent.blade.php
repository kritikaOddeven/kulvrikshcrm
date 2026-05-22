<!-- Modal -->
<div class="modal fade" id="exampleModalPopovers" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Add Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="agentForm" action="{{ route('admin.agents.store') }}" method="POST">
                @csrf

                <div class="modal-body row g-3">

                    <div class="col-md-12">
                        <label for="name" class="form-label">Name <x-required-star /></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <x-required-star /></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number<x-required-star /></label>
                        <input type="text" class="form-control" name="phone" maxlength="10" value="{{ old('phone') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <span class="text-danger">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password <x-required-star /></label>
                        <input type="password" class="form-control password" name="password">
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        <span id="password_error" style="color:red; font-size: 14px;"></span>
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="form-label">Role <x-required-star /></label>
                        <select class="form-select" name="role">
                            <option disabled selected>Choose...</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('role')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <span class="text-danger">
                            @error('status')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="agentAddSubmit" class="btn btn-primary" disabled>Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Prevent modal from closing if there are validation errors -->
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let modal = new bootstrap.Modal(document.getElementById('exampleModalPopovers'));
            modal.show();
        });
    </script>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function checkPasswordMatch() {
            const password = $('.password').val().trim();
            const confirmPassword = $('#confirm_password').val().trim();
            const $error = $('#password_error');
            const $submitBtn = $('#agentAddSubmit');

            if (!password && !confirmPassword) {
                $error.text('');
                $submitBtn.prop('disabled', true);
                return;
            }

            if (confirmPassword && password !== confirmPassword) {
                $error.text('Passwords do not match');
                $submitBtn.prop('disabled', true);
            } else if (confirmPassword && password === confirmPassword) {
                $error.text('');
                $submitBtn.prop('disabled', false);
            } else {
                // Confirm password is empty or in progress
                $error.text('');
                $submitBtn.prop('disabled', true);
            }
        }

        $('.password, #confirm_password').on('input', checkPasswordMatch);
    });
</script>
