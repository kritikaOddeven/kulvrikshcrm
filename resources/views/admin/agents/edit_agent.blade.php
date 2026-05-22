<div class="modal fade " id="editAgentModal" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="agentEditForm" action="{{ route('admin.agents.update') }}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <input type="hidden" name="agent_id" id="agent_id">
                    <div class="col-md-12">
                        <label class="form-label">Name<x-required-star /></label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email<x-required-star /></label>
                        <input type="email" class="form-control" id="email" name="email">
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number <x-required-star/></label>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <span class="text-danger">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control edit-password" id="password" name="password">
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control confirm_password" id="confirm_password" name="confirm_password">
                        <span class="password_error" style="color:red; font-size: 14px;"></span>
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="form-label">Role <x-required-star /></label>
                        <select class="form-select" name="role" id="role">
                            <option disabled>Choose...</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">
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
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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
                    <button type="submit" name="submit" id="agentEditSubmit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function validatePasswordMatch() {
            const password = $('.edit-password').val().trim();
            const confirmPassword = $('.confirm_password').val().trim();
            const $error = $('.password_error');
            const $submitBtn = $('#agentEditSubmit');

            if (!confirmPassword) {
                $error.text('').hide();
                $submitBtn.prop('disabled', true);
                return;
            }

            if (password !== confirmPassword) {
                $error.text('Passwords do not match').show();
                $submitBtn.prop('disabled', true);
            } else {
                $error.text('').hide();
                $submitBtn.prop('disabled', false);
            }
        }

        $('.edit-password, .confirm_password').on('input', validatePasswordMatch);
    });
</script>


<script>
    $('.editbtn').on('click', function() {
        $('#editAgentModal').modal('show');

        // console.log("Edit button clicked"); // Debug log
        var agent_id = $(this).data('value');
        // console.log("Agent ID: ", agent_id);
        $.ajax({
            url: "{{ url('admin/agents/edit/') }}" + '/' + agent_id,
            type: 'GET',
            success: function(response) {
                console.log(response, response.roles[0].name)

                $('#agent_id').val(response.id);
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#phone').val(response.phone);
                $('#role').val(response.roles[0].name);
                $('#status').val(response.status);

            }

        });
    });
</script>
