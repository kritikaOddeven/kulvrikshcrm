@extends('admin.layouts.app')
@section('pagetitle', 'My SMTP Configuration | Kulvriksh')
@section('admin-content')
    <style>
        .accordion-item {
            border-radius: 0 !important;
        }

        .provider-card {
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 0;
            height: 100%;
        }

        .provider-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .provider-card.selected {
            border: 1px solid #007bff;
            background-color: #f8f9ff;
        }
    </style>

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">My SMTP Configuration</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                <li class="breadcrumb-item active"><a href="#">My SMTP Configuration</a></li>
            </ol>
        </div>
    </div>

    <x-alert />

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">SMTP Configuration</h5>
                </div>
                <div class="card-body">

                    <!-- Provider Selection -->
                    <div class="mb-4">
                        <label class="form-label">Select Email Provider</label>
                        <div class="row">
                            @foreach ($providers as $key => $provider)
                                <div class="col-md-4 mb-2">
                                    <div class="card provider-card {{ $smtpSetting && $smtpSetting->provider == $key ? 'selected' : '' }}" onclick="selectProvider('{{ $key }}', this)">
                                        <div class="card-body text-center">
                                            <div class="mb-2">
                                                @if ($key == 'gmail')
                                                    <i class="ri-mail-line fs-2 text-danger"></i>
                                                @elseif($key == 'outlook')
                                                    <i class="ri-mail-line fs-2 text-primary"></i>
                                                @elseif($key == 'zoho')
                                                    <i class="ri-mail-line fs-2 text-info"></i>
                                                @elseif($key == 'yahoo')
                                                    <i class="ri-mail-line fs-2 text-warning"></i>
                                                @else
                                                    <i class="ri-settings-3-line fs-2 text-secondary"></i>
                                                @endif
                                            </div>
                                            <h6 class="mb-1 form-label">{{ $provider['name'] }}</h6>
                                            <p class="mb-0">{{ $provider['instructions'] }}</pl>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form class="form-horizontal" action="{{ url('admin/settings/my-smtp/store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="provider" id="selected_provider" value="{{ $smtpSetting->provider ?? 'custom' }}">

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL HOST</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="host" id="smtp_host" value="{{ $smtpSetting->host ?? '' }}" placeholder="MAIL HOST" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL PORT</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="port" id="smtp_port" value="{{ $smtpSetting->port ?? '587' }}" placeholder="MAIL PORT" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL USERNAME</label>
                            </div>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="username" value="{{ $smtpSetting->username ?? '' }}" placeholder="MAIL USERNAME" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL PASSWORD</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="password" placeholder="{{ $smtpSetting && $smtpSetting->password ? '********' : 'MAIL PASSWORD' }}">
                                    @if($smtpSetting && $smtpSetting->password)
                                        <span class="input-group-text text-success" data-bs-toggle="tooltip"  data-bs-placement="right" title="Password is already configured. Leave blank to keep current password.">
                                            <i class="ri-check-line"></i>
                                        </span>
                                    @else
                                        <span class="input-group-text text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter your email password or App Password for Gmail">
                                            <i class="ri-information-line"></i>
                                        </span>
                                    @endif
                                </div>
                                <small class="text-muted">For Gmail, use App Password instead of regular password</small>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL ENCRYPTION</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="encryption" id="smtp_encryption" required>
                                    <option value="tls" {{ ($smtpSetting->encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ ($smtpSetting->encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL FROM ADDRESS</label>
                            </div>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="from_address" value="{{ $smtpSetting->from_address ?? '' }}" placeholder="MAIL FROM ADDRESS" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL FROM NAME</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="from_name" value="{{ $smtpSetting->from_name ?? '' }}" placeholder="MAIL FROM NAME" required>
                            </div>
                        </div>

                        <div class="form-group mb-0 mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Save Configuration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md0-12">
            <!-- Test Email -->
            @if ($smtpSetting)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Test Email</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Test Email Address</label>
                            <input type="email" class="form-control" id="test_email" placeholder="Enter email to test">
                            <span class="text-danger" style="display: none;" id="test_email_validation">Please enter a test email address</span>
                        </div>
                        <button type="button" class="btn btn-outline-primary w-100" onclick="sendTestEmail()">
                            <i class="ri-send-plane-line me-1"></i> Send Test Email
                        </button>
                        <div id="test_result" class="mt-2"></div>
                    </div>
                </div>

                <!-- SMTP Status -->
                {{-- <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">SMTP Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Status:</span>
                            <span class="badge bg-{{ $smtpSetting->is_active ? 'success' : 'danger' }}">
                                {{ $smtpSetting->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-{{ $smtpSetting->is_active ? 'warning' : 'success' }} w-100" 
                                    onclick="toggleSmtp()">
                                {{ $smtpSetting->is_active ? 'Disable' : 'Enable' }} SMTP
                            </button>
                        </div>
                    </div>
                </div> --}}

                <!-- Delete Configuration -->
                {{-- <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-danger">Danger Zone</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Delete your SMTP configuration permanently.</p>
                        <button type="button" class="btn btn-outline-danger w-100" onclick="deleteSmtp()">
                            <i class="ri-delete-bin-line me-1"></i> Delete Configuration
                        </button>
                    </div>
                </div> --}}
            @endif

            <!-- Instructions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Instructions</h5>
                </div>
                <div class="card-body">
                    <h6 class="form-label">For Gmail</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">Enable 2-factor authentication</li>
                        <li class="list-group-item px-0">Generate App Password</li>
                        <li class="list-group-item px-0">Use App Password instead of regular password</li>
                    </ul>
                    <br>
                    <h6 class="form-label">For Outlook</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">Use your regular email and password</li>
                        <li class="list-group-item px-0">Enable "Less secure app access" if needed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        function selectProvider(provider, card) {
            // Update selected provider
            document.getElementById('selected_provider').value = provider;

            // Update UI - remove selected class from all cards
            document.querySelectorAll('.provider-card').forEach(cardElement => {
                cardElement.classList.remove('selected');
            });

            // Add selected class to clicked card
            card.classList.add('selected');

            // Auto-fill provider settings
            const providers = @json($providers);
            if (providers[provider]) {
                document.getElementById('smtp_host').value = providers[provider].host;
                document.getElementById('smtp_port').value = providers[provider].port;
                document.getElementById('smtp_encryption').value = providers[provider].encryption;
            }
        }

        function sendTestEmail() {
            $('#test_email_validation').css('display', 'none');

            const email = document.getElementById('test_email').value;

            if (!email) {
                $('#test_email_validation').css('display', 'block');
                return;
            }

            const resultDiv = document.getElementById('test_result');
            resultDiv.innerHTML = '<div class="alert alert-info">Sending test email...</div>';

            fetch('{{ url('admin/settings/my-smtp/test') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        test_email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                    } else {
                        resultDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
                });
        }

        function toggleSmtp() {
            fetch('{{ url('admin/settings/my-smtp/toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        }

        function deleteSmtp() {
            if (confirm('Are you sure you want to delete your SMTP configuration? This action cannot be undone.')) {
                window.location.href = '{{ url('admin/settings/my-smtp/delete') }}';
            }
        }
    </script>
@endsection
