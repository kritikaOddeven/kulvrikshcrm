@extends('admin.layouts.app')
@section('pagetitle', 'IMAP Configuration | Kulvriksh')
@section('admin-content')
    <style>
        .provider-card {
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 0;
            height: 100%;
        }

        .provider-card:hover {
            border-color: #007bff;
            transform: translateY(-2px);
        }

        .provider-card.selected {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        .accordion-item {
            border-radius: 0 !important;
        }
    </style>

    <x-alert />

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">IMAP Configuration</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                <li class="breadcrumb-item active">IMAP Configuration</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">IMAP Configuration</h5>
                </div>
                <div class="card-body">

                    <!-- Provider Selection -->
                    <div class="mb-4">
                        <label class="form-label">Select Email Provider</label>
                        <div class="row">
                            @foreach ($providers as $key => $provider)
                                <div class="col-md-4 mb-2">
                                    <div class="card provider-card {{ $imapSetting && $imapSetting->provider == $key ? 'selected' : '' }}" onclick="selectProvider('{{ $key }}')">
                                        <div class="card-body text-center border-0">
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
                                            <p class="mb-0">{{ $provider['instructions'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form class="form-horizontal" action="{{ url('admin/settings/my-imap/store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="provider" id="selected_provider" value="{{ $imapSetting->provider ?? 'custom' }}">

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">IMAP HOST</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="host" id="imap_host" value="{{ $imapSetting->host ?? '' }}" placeholder="IMAP HOST" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">IMAP PORT</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="port" id="imap_port" value="{{ $imapSetting->port ?? '993' }}" placeholder="IMAP PORT" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">EMAIL ADDRESS</label>
                            </div>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="username" value="{{ $imapSetting->username ?? '' }}" placeholder="EMAIL ADDRESS" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">PASSWORD</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" placeholder="{{ $imapSetting && $imapSetting->password ? '********' : 'PASSWORD' }}">
                                    @if($imapSetting && $imapSetting->password)
                                        <span class="input-group-text text-success" data-bs-toggle="tooltip"  data-bs-placement="right" title="Password is already configured. Leave blank to keep current password.">
                                            <i class="ri-check-line"></i>
                                        </span>
                                    @else
                                        <span class="input-group-text text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter your email password or App Password for Gmail">
                                            <i class="ri-information-line"></i>
                                        </span>
                                    @endif
                                </div>
                                <small class="form-label">For Gmail, use App Password instead of regular password</small>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">ENCRYPTION</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="encryption" id="imap_encryption" required>
                                    <option value="ssl" {{ ($imapSetting->encryption ?? 'ssl') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="tls" {{ ($imapSetting->encryption ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="notls" {{ ($imapSetting->encryption ?? '') == 'notls' ? 'selected' : '' }}>No TLS</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-0 mt-2 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Save Configuration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <!-- Test Connection -->
            @if ($imapSetting)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Test Connection</h5>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-outline-primary w-100" onclick="testImapConnection()">
                            <i class="ri-wifi-line me-1"></i> Test IMAP Connection
                        </button>
                        <div id="test_result" class="mt-2"></div>
                    </div>
                </div>

                <!-- IMAP Status -->
                {{-- <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">IMAP Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Status:</span>
                            <span class="badge {{ $imapSetting->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $imapSetting->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Provider:</span>
                            <span class="fw-semibold">{{ ucfirst($imapSetting->provider) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Host:</span>
                            <span class="text-muted">{{ $imapSetting->host }}:{{ $imapSetting->port }}</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick="toggleImap()">
                                <i class="ri-toggle-line me-1"></i> {{ $imapSetting->is_active ? 'Disable' : 'Enable' }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteImap()">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
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
                        <li class="list-group-item px-0">Enable IMAP in Gmail settings</li>
                        <li class="list-group-item px-0">Use App Password instead of regular password</li>
                    </ul>
                    <br>
                    <h6 class="form-label">For Outlook</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">Use your regular email and password</li>
                        <li class="list-group-item px-0">Enable IMAP in Outlook settings</li>
                    </ul>
                    <br>
                    <h6 class="form-label">For Yahoo</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">Enable 2-factor authentication</li>
                        <li class="list-group-item px-0">Generate App Password</li>
                        <li class="list-group-item px-0">Enable IMAP in Yahoo settings</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectProvider(provider) {
            // Remove selected class from all cards
            document.querySelectorAll('.provider-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');

            // Update hidden input
            document.getElementById('selected_provider').value = provider;

            // Update form fields based on provider
            const providers = @json($providers);
            const config = providers[provider];

            if (config) {
                document.getElementById('imap_host').value = config.host;
                document.getElementById('imap_port').value = config.port;
                document.getElementById('imap_encryption').value = config.encryption;
            }
        }

        function testImapConnection() {
            const resultDiv = document.getElementById('test_result');
            resultDiv.innerHTML = '<div class="alert alert-info">Testing IMAP connection...</div>';

            fetch('{{ url('admin/settings/my-imap/test') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
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

        function toggleImap() {
            fetch('{{ url('admin/settings/my-imap/toggle') }}', {
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

        function deleteImap() {
            if (confirm('Are you sure you want to delete your IMAP configuration?')) {
                fetch('{{ url('admin/settings/my-imap/delete') }}', {
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
        }
    </script>
@endsection
