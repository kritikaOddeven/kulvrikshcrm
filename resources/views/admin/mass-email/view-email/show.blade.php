@extends('admin.layouts.app')
@section('pagetitle', 'Email Details | Kulvriksh')
@section('admin-content')
    <style>
        .email-header {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .email-content {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .email-body {
            line-height: 1.6;
            color: #333;
        }

        .email-body img {
            max-width: 100%;
            height: auto;
        }

        .attachment-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 10px;
            background: #f8f9fa;
        }

        .attachment-icon {
            margin-right: 10px;
            color: #6c757d;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .email-metadata {
            font-size: 0.9rem;
        }

        .email-metadata strong {
            color: #495057;
        }

        .swal2-popup.swal2-modal.swal2-icon-warning {
    padding: 0 15px 0px !important;
}

    </style>

    <div class="row mt-lg-3">
        <div class="col-md-12">

            <div class="back-button">
                <a href="{{ url('admin/mass-email/view-email') }}" class="btn btn-outline-secondary">
                    <i class="ri-arrow-left-line me-1"></i> Back to Email List
                </a>
            </div>

            <div class="row py-3 align-items-sm-center justify-content-between gap-2">
                <div class="col-auto">
                    <h4 class="page-title">Email Details</h4>
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ url('admin/mass-email/view-email') }}">View Email</a></li>
                        <li class="breadcrumb-item active">Email Details</li>
                    </ol>
                </div>
                <div class="mt-3 mt-sm-0 col-auto">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="toggleStar({{ $email->id }})">
                            <i class="ri-star-{{ $email->is_starred ? 'fill' : 'line' }} me-1"></i>
                            {{ $email->is_starred ? 'Unstar' : 'Star' }}
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteEmail({{ $email->id }})">
                            <i class="ri-delete-bin-line me-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Email Header -->
                            <div class="email-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="email-metadata mb-2">
                                            <strong>From:</strong>
                                            <span>{{ $email->from_name ? $email->from_name . ' (' . $email->from_email . ')' : $email->from_email }}</span>
                                        </div>
                                        <div class="email-metadata mb-2">
                                            <strong>To:</strong>
                                            <span>{{ $email->to_name ? $email->to_name . ' (' . $email->to_email . ')' : $email->to_email }}</span>
                                        </div>
                                        @if ($email->cc)
                                            <div class="email-metadata mb-2">
                                                <strong>CC:</strong> <span>{{ $email->cc }}</span>
                                            </div>
                                        @endif
                                        @if ($email->bcc)
                                            <div class="email-metadata mb-2">
                                                <strong>BCC:</strong> <span>{{ $email->bcc }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="email-metadata mb-2">
                                            <strong>Subject:</strong> <span>{{ $email->subject }}</span>
                                        </div>
                                        <div class="email-metadata mb-2">
                                            <strong>Date:</strong> <span>{{ $email->date_received ? $email->date_received->format('F j, Y \a\t g:i A') : 'Unknown' }}</span>
                                        </div>
                                        <div class="email-metadata mb-2">
                                            <strong>Folder:</strong> <span class="badge bg-primary">{{ $email->folder }}</span>
                                        </div>
                                        @if ($email->has_attachments)
                                            <div class="email-metadata mb-2">
                                                <strong>Attachments:</strong>
                                                <span class="badge bg-warning">
                                                    <i class="ri-attachment-2 me-1"></i>
                                                    {{ $email->attachments ? count($email->attachments) : 0 }} file(s)
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Attachments -->
                            @if ($email->has_attachments && $email->attachments && is_array($email->attachments))
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Attachments</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($email->attachments as $attachment)
                                            <div class="attachment-item">
                                                <i class="ri-file-line attachment-icon"></i>
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold">{{ $attachment['name'] ?? 'Unknown file' }}</div>
                                                    <div class="text-muted small">
                                                        {{ isset($attachment['size']) ? number_format($attachment['size'] / 1024, 2) . ' KB' : 'Unknown size' }}
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" onclick="downloadAttachment('{{ $attachment['name'] ?? '' }}')">
                                                    <i class="ri-download-line"></i> Download
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Email Content -->
                            <div class="email-content">
                                <h6 class="mb-3">Message Content:</h6>
                                <div class="email-body" id="email-body-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        function toggleStar(emailId) {
            // Show loading state
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Updating Star Status...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            fetch('{{ url('admin/mass-email/view-email/toggle-star') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message_id: emailId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload the page to update the star status
                                window.location.reload();
                            });
                        } else {
                            // Reload the page to update the star status
                            window.location.reload();
                        }
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Unknown error occurred'
                            });
                        } else {
                            alert('Error: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while updating star status'
                        });
                    } else {
                        alert('An error occurred while updating star status');
                    }
                });
        }

        function deleteEmail(emailId) {
            // Use SweetAlert for confirmation
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Delete Email?',
                    text: 'Are you sure you want to delete this email? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        performDeleteEmail(emailId);
                    }
                });
            } else {
                // Fallback to regular confirm if SweetAlert is not available
                if (confirm('Are you sure you want to delete this email?')) {
                    performDeleteEmail(emailId);
                }
            }
        }

        function performDeleteEmail(emailId) {
            // Show loading state
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Deleting Email...',
                    text: 'Please wait while we delete the email',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            fetch('{{ url('admin/mass-email/view-email/delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message_ids: [emailId]
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Email has been deleted successfully',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Redirect back to email list
                                window.location.href = '{{ url('admin/mass-email/view-email') }}';
                            });
                        } else {
                            alert('Email deleted successfully!');
                            window.location.href = '{{ url('admin/mass-email/view-email') }}';
                        }
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Unknown error occurred'
                            });
                        } else {
                            alert('Error: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while deleting the email'
                        });
                    } else {
                        alert('An error occurred while deleting the email');
                    }
                });
        }

        function downloadAttachment(filename) {
            // This would need to be implemented based on how attachments are stored
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'Download Feature',
                    text: 'Download functionality for ' + filename + ' would be implemented here',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Download functionality for ' + filename + ' would be implemented here');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var emailHtml = @json($email->body_html ?? $email->body_plain ?? $email->body ?? '');
            var container = document.getElementById('email-body-container');
            var iframe = document.createElement('iframe');
            iframe.style.width = '100%';
            iframe.style.minHeight = '800px';
            iframe.style.border = 'none';
            container.appendChild(iframe);
            iframe.contentDocument.open();
            iframe.contentDocument.write(emailHtml);
            iframe.contentDocument.close();
        });
    </script>
@endsection
