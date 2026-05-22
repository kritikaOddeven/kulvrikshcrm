<?php $__env->startSection('pagetitle', 'View-Email | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <style>
        .list-group-item {
            border: none;
            border-bottom: 1px solid #eee;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .email-item {
            transition: background-color 0.2s ease;
        }

        .email-item:hover {
            background-color: #f8f9fa;
        }

        .email-item.unread {
            background-color: #f0f8ff;
            font-weight: 600;
        }

        .email-item.unread:hover {
            background-color: #e6f3ff;
        }

        .star-icon {
            color: #ffc107;
        }

        .star-icon:hover {
            color: #ffca2c;
        }

        .attachment-icon {
            color: #6c757d;
        }

        .folder-item {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .folder-item:hover {
            background-color: #f8f9fa;
        }

        .folder-item.active {
            background-color: #007bff;
            color: white;
        }

        .pagination-info {
            margin-right: 10px;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .loading {
            text-align: center;
            padding: 40px;
        }

        .loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .no-config {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        /* Fetching Popup Styles */
        .fetching-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .fetching-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .fetching-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        .fetching-text {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .fetching-subtext {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .fetching-progress {
            width: 100%;
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .fetching-progress-bar {
            height: 100%;
            background-color: #007bff;
            width: 0%;
            transition: width 0.3s ease;
        }

        .fetching-status {
            font-size: 12px;
            color: #888;
        }

        .swal2-popup.swal2-modal.swal2-icon-warning {
            padding: 0 15px 0px !important;
        }
    </style>

    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View Email</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Mass Email</a></li>
                <li class="breadcrumb-item active">View Email</li>
            </ol>
        </div>
        <div class="mt-3 mt-sm-0 col-auto">
            <?php if(!auth()->user()->hasImapConfigured()): ?>
                <a href="<?php echo e(url('admin/settings/my-imap')); ?>" class="btn btn-primary">
                    <i class="ri-settings-3-line me-1"></i> Configure IMAP
                </a>
            <?php else: ?>
                <button type="button" class="btn btn-outline-primary" onclick="refreshEmails()">
                    <i class="ri-refresh-line me-1"></i> Refresh
                </button>
            <?php endif; ?>
        </div>
    </div>

    <?php if(!auth()->user()->hasImapConfigured()): ?>
        <div class="card">
            <div class="card-body no-config">
                <i class="ri-mail-settings-line fs-1 text-muted mb-3"></i>
                <h5>IMAP Configuration Required</h5>
                <p class="text-muted">Please configure your IMAP settings to view emails.</p>
                <a href="<?php echo e(url('admin/settings/my-imap')); ?>" class="btn btn-primary">
                    <i class="ri-settings-3-line me-1"></i> Configure IMAP Settings
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush rounded-2" id="folders-list">
                            <div class="list-group-item folder-item <?php echo e($folder === 'INBOX' ? 'active' : ''); ?>" data-folder="INBOX">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="ri-inbox-line me-2"></i> Inbox</div>
                                    <span class="badge bg-primary rounded-pill" id="inbox-count"><?php echo e($emailCounts['INBOX'] ?? 0); ?></span>
                                </div>
                            </div>
                            <div class="list-group-item folder-item <?php echo e($folder === 'SENT' ? 'active' : ''); ?>" data-folder="SENT">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="ri-send-plane-fill me-2"></i> Sent</div>
                                    <span class="badge bg-secondary rounded-pill" id="sent-count"><?php echo e($emailCounts['SENT'] ?? 0); ?></span>
                                </div>
                            </div>
                            
                            <div class="list-group-item folder-item <?php echo e($folder === 'STARRED' ? 'active' : ''); ?>" data-folder="STARRED">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="ri-star-fill me-2"></i> Starred</div>
                                    <span class="badge bg-warning rounded-pill" id="starred-count"><?php echo e($emailCounts['STARRED'] ?? 0); ?></span>
                                </div>
                            </div>
                            <div class="list-group-item folder-item <?php echo e($folder === 'TRASH' ? 'active' : ''); ?>" data-folder="TRASH">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="ri-delete-bin-line me-2"></i> Trash</div>
                                    <span class="badge bg-danger rounded-pill" id="trash-count"><?php echo e($emailCounts['TRASH'] ?? 0); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0" id="current-folder"><?php echo e(ucfirst(strtolower($folder))); ?></h4>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" class="form-control form-control-sm" id="search-input" placeholder="Search emails" style="width: 200px;" value="<?php echo e($search); ?>">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="searchEmails()">
                                        <i class="ri-search-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Controls -->
                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <input type="checkbox" id="select-all" />
                                <span>Select All</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshEmails()">
                                    <i class="ri-refresh-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="mark-read-btn" onclick="markSelectedAsRead()" disabled>
                                    <i class="ri-check-line"></i> Mark Read (<span id="selected-count">0</span>)
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="delete-btn" onclick="deleteSelected()" disabled>
                                    <i class="ri-delete-bin-line"></i> Delete (<span id="selected-count-2">0</span>)
                                </button>
                            </div>

                        </div>

                        <!-- Email List -->
                        <div id="email-list">
                            <?php if($emails->count() > 0): ?>
                                <?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    // echo '<pre>';
                                    // print_r($email);
                                    // die;
                                    ?>
                                    <div class="email-item list-group-item <?php echo e(!$email->is_read ? 'unread' : ''); ?>" data-email-id="<?php echo e($email->id); ?>" onclick="viewEmailDetails(<?php echo e($email->id); ?>, event)">
                                        <div class="row align-items-center p-2 px-3">
                                            <div class="col-auto">
                                                <input type="checkbox" class="email-checkbox" value="<?php echo e($email->id); ?>" onclick="event.stopPropagation()">
                                            </div>
                                            <div class="col-auto">
                                                <i class="ri-star-<?php echo e($email->is_starred ? 'fill star-icon' : 'line'); ?>" onclick="toggleStar(<?php echo e($email->id); ?>, this); event.stopPropagation()"></i>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold text-truncate"><?php echo e($email->from_name ?: $email->from_email); ?></div>
                                                        <div class="text-muted small text-truncate text-wrap-400"><?php echo e($email->to_name); ?></div>
                                                        <div class="text-muted small text-truncate text-wrap-400"><?php echo e($email->subject); ?></div>

                                                        
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="text-muted small"><?php echo e($email->formatted_date); ?></div>
                                                        <?php if($email->has_attachments): ?>
                                                            <i class="ri-attachment-2 attachment-icon"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="ri-inbox-line fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No emails found</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Pagination Info -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    Showing <?php echo e($emails->firstItem() ?? 0); ?> to <?php echo e($emails->lastItem() ?? 0); ?> of <?php echo e($emails->total()); ?> emails
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <span id="pagination-info" class="pagination-info"><?php echo e($emails->firstItem() ?? 0); ?>-<?php echo e($emails->lastItem() ?? 0); ?>/<?php echo e($emails->total() ?? 0); ?></span>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="previousPage()" id="prev-btn" <?php echo e($emails->previousPageUrl() ? '' : 'disabled'); ?>>
                                            <i class="ri-arrow-left-s-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="nextPage()" id="next-btn" <?php echo e($emails->nextPageUrl() ? '' : 'disabled'); ?>>
                                            <i class="ri-arrow-right-s-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Fetching Popup Modal -->
    <div id="fetchingModal" class="fetching-modal">
        <div class="fetching-content">
            <div class="fetching-spinner"></div>
            <div class="fetching-text">Fetching Emails...</div>
            <div class="fetching-subtext">Retrieving latest 10 emails per folder from the last day</div>
            <div class="fetching-progress">
                <div class="fetching-progress-bar" id="progressBar"></div>
            </div>
            <div class="fetching-status" id="fetchingStatus">Connecting to IMAP server...</div>
        </div>
    </div>

    <script>
        let currentFolder = '<?php echo e($folder); ?>';
        let currentPage = <?php echo e($page); ?>;
        let searchQuery = '<?php echo e($search); ?>';
        let selectedEmails = [];
        let totalPages = <?php echo e($emails->lastPage()); ?>;
        let totalRecords = <?php echo e($emails->total()); ?>;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
            updateSelectAllState();
        });

        function setupEventListeners() {
            // Folder click events
            const folderItems = document.querySelectorAll('.folder-item');
            folderItems.forEach(item => {
                item.addEventListener('click', function() {
                    const folder = this.getAttribute('data-folder');
                    switchFolder(folder);
                });
            });

            // Search input event
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchEmails();
                    }
                });
            }

            // Select all checkbox
            const selectAllCheckbox = document.getElementById('select-all');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.email-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                        if (this.checked) {
                            if (!selectedEmails.includes(checkbox.value)) {
                                selectedEmails.push(checkbox.value);
                            }
                        } else {
                            selectedEmails = [];
                        }
                    });
                    updateSelectAllState();
                });
            }

            // Individual email checkboxes
            const emailCheckboxes = document.querySelectorAll('.email-checkbox');
            emailCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (!selectedEmails.includes(this.value)) {
                            selectedEmails.push(this.value);
                        }
                    } else {
                        const index = selectedEmails.indexOf(this.value);
                        if (index > -1) {
                            selectedEmails.splice(index, 1);
                        }
                    }
                    updateSelectAllState();
                });
            });
        }

        function updateSelectAllState() {
            const selectAllCheckbox = document.getElementById('select-all');
            const emailCheckboxes = document.querySelectorAll('.email-checkbox');
            const markReadBtn = document.getElementById('mark-read-btn');
            const deleteBtn = document.getElementById('delete-btn');
            const selectedCount = document.getElementById('selected-count');
            const selectedCount2 = document.getElementById('selected-count-2');

            if (emailCheckboxes.length === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
                markReadBtn.disabled = true;
                deleteBtn.disabled = true;
                selectedCount.textContent = '0';
                selectedCount2.textContent = '0';
                return;
            }

            const checkedCount = selectedEmails.length;
            const totalCount = emailCheckboxes.length;

            // Update select all checkbox state
            if (checkedCount === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            } else if (checkedCount === totalCount) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            }

            // Update button states
            markReadBtn.disabled = checkedCount === 0;
            deleteBtn.disabled = checkedCount === 0;

            // Update selected count displays
            selectedCount.textContent = checkedCount;
            selectedCount2.textContent = checkedCount;
        }

        function switchFolder(folder) {
            currentFolder = folder;
            currentPage = 1;
            searchQuery = '';

            // Update URL and reload page to fetch fresh data
            const url = new URL(window.location);
            url.searchParams.set('folder', currentFolder);
            url.searchParams.set('page', '1');
            url.searchParams.delete('search');

            // Reload the page to fetch fresh data
            window.location.href = url.toString();
        }

        function searchEmails() {
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchQuery = searchInput.value;
            }
            currentPage = 1;

            // Update URL and reload page to fetch fresh data
            const url = new URL(window.location);
            url.searchParams.set('search', searchQuery);
            url.searchParams.set('page', '1');

            // Reload the page to fetch fresh data
            window.location.href = url.toString();
        }

        function refreshEmails() {
            // Show fetching popup
            showFetchingPopup();

            // Simulate progress updates with different status messages
            let progress = 0;
            const statusMessages = [
                'Connecting to IMAP server...',
                'Fetching emails from INBOX...',
                'Fetching emails from SENT folder...',
                'Fetching emails from TRASH folder...',
                'Processing starred emails...',
                'Updating email counts...'
            ];
            let messageIndex = 0;

            const progressInterval = setInterval(() => {
                progress += Math.random() * 12;
                if (progress > 85) progress = 85;

                // Update status message every few seconds
                if (progress > messageIndex * 15 && messageIndex < statusMessages.length - 1) {
                    messageIndex++;
                }

                updateFetchingStatus(statusMessages[messageIndex], progress);
            }, 400);

            // Disable refresh button during fetching
            const refreshButtons = document.querySelectorAll('button[onclick="refreshEmails()"]');
            refreshButtons.forEach(btn => btn.disabled = true);

            fetch('<?php echo e(url('admin/mass-email/view-email/refresh')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    clearInterval(progressInterval);

                    if (data.success) {
                        updateFetchingStatus('Processing fetched emails...', 95);

                        // Update email counts
                        if (data.email_counts) {
                            document.getElementById('inbox-count').textContent = data.email_counts.INBOX || 0;
                            document.getElementById('sent-count').textContent = data.email_counts.SENT || 0;
                            // document.getElementById('drafts-count').textContent = data.email_counts.DRAFTS || 0;
                            document.getElementById('starred-count').textContent = data.email_counts.STARRED || 0;
                            document.getElementById('trash-count').textContent = data.email_counts.TRASH || 0;
                        }

                        updateFetchingStatus('Emails fetched successfully!', 100);

                        // Show success message
                        setTimeout(() => {
                            hideFetchingPopup();

                            // Create detailed success message
                            let detailedMessage = data.message;
                            // if (data.folders) {
                            //     detailedMessage += '\n\nDetails:';
                            //     Object.keys(data.folders).forEach(folder => {
                            //         const folderData = data.folders[folder];
                            //         if (folderData.success) {
                            //             detailedMessage += `\n• ${folder}: ${folderData.count} emails`;
                            //         } else {
                            //             detailedMessage += `\n• ${folder}: ${folderData.message}`;
                            //         }
                            //     });
                            // }

                            showSuccessMessage(detailedMessage);
                            // Reload the page to show updated emails
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }, 1500);
                    } else {
                        hideFetchingPopup();
                        showErrorMessage(data.message);
                    }
                })
                .catch(error => {
                    console.log('Error:', error);
                    clearInterval(progressInterval);
                    hideFetchingPopup();
                    showErrorMessage('Failed to fetch emails. Please try again.');
                })
                .finally(() => {
                    // Re-enable refresh buttons
                    refreshButtons.forEach(btn => btn.disabled = false);
                });
        }

        function showFetchingPopup() {
            document.getElementById('fetchingModal').style.display = 'block';
            document.getElementById('progressBar').style.width = '0%';
        }

        function hideFetchingPopup() {
            document.getElementById('fetchingModal').style.display = 'none';
        }

        function updateFetchingStatus(status, progress) {
            document.getElementById('fetchingStatus').textContent = status;
            document.getElementById('progressBar').style.width = progress + '%';
        }

        function showSuccessMessage(message) {
            // You can use SweetAlert2 or any other notification library
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                alert(message);
            }
        }

        function showErrorMessage(message) {
            // You can use SweetAlert2 or any other notification library
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                alert(message);
            }
        }

        function toggleStar(emailId, element) {
            fetch('<?php echo e(url('admin/mass-email/view-email/toggle-star')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        message_id: emailId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (data.is_starred) {
                            element.classList.remove('ri-star-line');
                            element.classList.add('ri-star-fill', 'star-icon');
                        } else {
                            element.classList.remove('ri-star-fill', 'star-icon');
                            element.classList.add('ri-star-line');
                        }
                        // Reload page to update counts
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function markSelectedAsRead() {
            console.log('markSelectedAsRead called, selectedEmails:', selectedEmails);
            if (selectedEmails.length === 0) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Emails Selected',
                        text: 'Please select emails to mark as read',
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert('Please select emails to mark as read');
                }
                return;
            }

            // Show loading state
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Marking as Read...',
                    text: `Marking ${selectedEmails.length} email${selectedEmails.length > 1 ? 's' : ''} as read`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            fetch('<?php echo e(url('admin/mass-email/view-email/mark-read')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        message_ids: selectedEmails
                    })
                })
                .then(response => {
                    console.log('Mark read response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Mark read response data:', data);
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Marked as Read!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload page to show updated state
                                window.location.reload();
                            });
                        } else {
                            alert('Emails marked as read successfully!');
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
                            alert('Error: ' + (data.message || 'Unknown error'));
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking as read:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error marking emails as read: ' + error.message
                        });
                    } else {
                        alert('Error marking emails as read: ' + error.message);
                    }
                });
        }

        function deleteSelected() {
            console.log('deleteSelected called, selectedEmails:', selectedEmails);
            if (selectedEmails.length === 0) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Emails Selected',
                        text: 'Please select emails to delete',
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert('Please select emails to delete');
                }
                return;
            }

            // Use SweetAlert for confirmation
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Delete Emails?',
                    text: `Are you sure you want to delete ${selectedEmails.length} selected email${selectedEmails.length > 1 ? 's' : ''}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        performDelete();
                    }
                });
            } else {
                // Fallback to regular confirm if SweetAlert is not available
                if (confirm('Are you sure you want to delete the selected emails?')) {
                    performDelete();
                }
            }
        }

        function performDelete() {
            fetch('<?php echo e(url('admin/mass-email/view-email/delete')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        message_ids: selectedEmails
                    })
                })
                .then(response => {
                    console.log('Delete response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Delete response data:', data);
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload page to show updated state
                                window.location.reload();
                            });
                        } else {
                            alert('Emails deleted successfully!');
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
                            alert('Error: ' + (data.message || 'Unknown error'));
                        }
                    }
                })
                .catch(error => {
                    console.error('Error deleting emails:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error deleting emails: ' + error.message
                        });
                    } else {
                        alert('Error deleting emails: ' + error.message);
                    }
                });
        }

        function viewEmailDetails(emailId, event) {
            // Don't open if clicking on checkbox or star
            if (event.target.type === 'checkbox' || event.target.classList.contains('ri-star')) {
                return;
            }

            // Navigate to the email details page
            window.location.href = `<?php echo e(url('admin/mass-email/view-email/show')); ?>/${emailId}`;
        }

        function previousPage() {
            if (currentPage > 1) {
                currentPage--;

                // Update URL and reload page to fetch fresh data
                const url = new URL(window.location);
                url.searchParams.set('page', currentPage.toString());

                // Reload the page to fetch fresh data
                window.location.href = url.toString();
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;

                // Update URL and reload page to fetch fresh data
                const url = new URL(window.location);
                url.searchParams.set('page', currentPage.toString());

                // Reload the page to fetch fresh data
                window.location.href = url.toString();
            }
        }

        function testRoutes() {
            console.log('Testing routes...');

            // Test mark-read route
            fetch('<?php echo e(url('admin/mass-email/view-email/mark-read')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        message_ids: []
                    })
                })
                .then(response => {
                    console.log('Mark-read route test - Status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Mark-read route test - Response:', data);
                })
                .catch(error => {
                    console.error('Mark-read route test - Error:', error);
                });

            // Test delete route
            fetch('<?php echo e(url('admin/mass-email/view-email/delete')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        message_ids: []
                    })
                })
                .then(response => {
                    console.log('Delete route test - Status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Delete route test - Response:', data);
                })
                .catch(error => {
                    console.error('Delete route test - Error:', error);
                });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/mass-email/view-email/index.blade.php ENDPATH**/ ?>