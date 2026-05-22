@extends('admin.layouts.app')
@section('pagetitle', 'View Researcher | Kulvriksh')
@section('admin-content')
    <style>
        .info-table th,
        .info-table td {
            border: none;
        }

        .avatar-initials {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #6c757d;
            color: #fff;
            font-weight: bold;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 14px;
            text-transform: uppercase;
        }
    </style>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">View Researcher</h4>
            {{-- <p>Agents/View All Agents</p> --}}
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Researcher</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('admin/researcher') }}">View All Researcher</a></li>
                <li class="breadcrumb-item active">View Researcher</li>
            </ol>
        </div>
         @can('researcher_edit_client')
                <a href="{{ url('admin/clients/edit/' . $data->id) }}" class="btn btn-primary mr-1" title="edit"><i class="ri-edit-line"></i> Edit Client</a>
            @endcan
    </div>
    <div class="row">
        {{-- Alert message --}}
        <x-alert />
        <div class="col-xl-12">
            <div class="card lead-view-box">
                <div class="accordion" id="accordionPanelsStayOpenExample">

                    <div class="accordion-item">

                        <div id="panelsStayOpen-collapse" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <table class="table info-table">
                                    @php
                                        $assign_researchers = getResearchersWithNames(json_decode($data->researcher_ids ?? '[]', true))['researchers'];
                                        $projectData = getProjectsWithNames('parent', json_decode($data->project_ids ?? '[]', true));
                                        $subProjectData = getProjectsWithNames('subproject', json_decode($data->sub_project_ids ?? '[]', true));
                                    @endphp
                                    <tbody>
                                        <tr>
                                            <th>KV ID</th>
                                            <td>:</td>
                                            <td class="ps-3">{{ $data->kulvrisk_id ?? '' }}</td>

                                            <th>Researhcer Name</th>
                                            <td>:</td>
                                            <td class="ps-3">
                                                <div>
                                                    @foreach ($assign_researchers as $researcher)
                                                        <span class="me-2">{{ $researcher->name }}</span>
                                                    @endforeach
                                                </div>
                                            </td>

                                            <th>Payment Mode</th>
                                            <td>:</td>
                                            <td class="ps-3">{{ $data->payment_mode ? paymentMode($data->payment_mode) : '' }}</td>

                                            <th>Image</th>
                                            <td>:</td>
                                            <td class="ps-3">
                                                @if (!empty($data->image_path) && file_exists(public_path($data->image_path)))
                                                    @php
                                                        $extension = strtolower(pathinfo($data->image_path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                                        <a href="{{ asset($data->image_path) }}" target="_blank">
                                                            <img src="{{ asset($data->image_path) }}" alt="Image" width="50">
                                                        </a>
                                                    @elseif ($extension === 'pdf')
                                                        <a href="{{ asset($data->image_path) }}" target="_blank">
                                                            <img src="{{ asset('assets/admin/images/pdf.png') }}" alt="PDF File" width="50">
                                                        </a>
                                                    @else
                                                        <p>Unsupported file type</p>
                                                    @endif
                                                @else
                                                    <p>No file available</p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Project</th>
                                            <td>:</td>
                                            <td class="ps-3">{{ $projectData['names'] }}</td>

                                            <th>Sub Project</th>
                                            <td>:</td>
                                            <td class="ps-3">{{ $subProjectData['names'] }}</td>
                                            <th>Start Date</th>
                                            <td>:</td>
                                            <td class="ps-3">{{ $data->start_date ?? '' }}</td>
                                            <th>End Date</th>
                                            <td>:</td>
                                            <td class="ps-3">{{ $data->end_date ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    @include('admin.leads.details.lead-info', ['data' => $data->lead])
                    @include('admin.leads.details.lineage-info', ['data' => $data->lead])
                    @include('admin.leads.details.family-info', ['data' => $data->lead])
                    @include('admin.leads.details.wife-info', ['data' => $data->lead])
                    @include('admin.leads.details.wife-family-info', ['data' => $data->lead])
                    @include('admin.leads.details.wife-lineage-info', ['data' => $data->lead])
                    @include('admin.leads.details.children-info', ['data' => $data->lead])

                    {{-- Notes --}}
                    <div class="accordion-item">

                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="true" aria-controls="panelsStayOpen-collapseEight">
                                Notes
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="row">

                                    <ul class="nav nav-underline " role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#conversation" role="tab" aria-selected="true">
                                                <span class="d-none d-sm-block">Conversation</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#researcherview" role="tab" aria-selected="false" tabindex="-1">
                                                <span class="d-none d-sm-block">Researcher View</span>
                                            </a>
                                        </li>

                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="conversation" role="tabpanel">
                                            @foreach ($data->lead->leadNote as $item)
                                                <div class="col-md-12 mb-2">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <label class="d-flex align-items-center mb-2 form-label">
                                                            <img src="{{ asset(get_profile_image($item->user->profile_image, $item->user->name)) }}" class="avatar avatar-sm rounded-circle me-2">
                                                            {{ $item->user->name ?? '' }}
                                                        </label>
                                                        <span class="text-end form-label">{{ $item->created_at->format('D d F, g:i') }}</span>
                                                    </div>

                                                    <p name="content" rows="10" readonly>{{ strip_tags($item->content) }}</p>
                                                </div>
                                            @endforeach

                                            {{-- researcher conversation --}}
                                            
                                            <div class="row">
                                                <h5 class="form-label"><u>Researcher Conversation</u></h5>
                                                @foreach ($data->conversation as $item)
                                                    @php
                                                        $nameParts = explode(' ', $item->user->name ?? '');
                                                        $initials = '';
                                                        if (count($nameParts) > 0) {
                                                            $initials .= strtoupper(substr($nameParts[0], 0, 1));
                                                            if (count($nameParts) > 1) {
                                                                $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                                            }
                                                        }
                                                    @endphp
                                                    <input type="hidden" name="added_by[]" value="{{ $item->added_by }}">

                                                    <div class="col-md-12 mb-2" data-note-id="{{ $item->id }}">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <label class="d-flex align-items-center mb-2 form-label">
                                                                <img src="{{ asset(get_profile_image($item->user->profile_image, $item->user->name)) }}" class="avatar avatar-sm rounded-circle me-2">
                                                                {{ $item->user->name ?? '' }}
                                                            </label>
                                                            <div class="d-flex align-items-center">
                                                                <span class="text-end me-2">{{ $item->created_at->format('D d F, g:i') }}</span>
                                                                @if($item->added_by == auth()->id() || auth()->user()->hasRole('super-admin'))
                                                                    <button type="button" class="btn btn-sm btn-outline-primary edit-researcher-note-btn" data-note-id="{{ $item->id }}">
                                                                        <i class="ri-edit-line"></i> Edit
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- View Mode -->
                                                        <div class="researcher-note-view-mode">
                                                            <p name="content" rows="10" readonly>{{ strip_tags($item->content) }}</p>
                                                            @if ($item->attachment)
                                                                <div class="file-item d-flex align-items-center gap-2 mt-2">
                                                                    <div class="attachment-item">
                                                                        <a href="{{ asset($item->attachment) }}" target="_blank" class="text-decoration-none">
                                                                            <i class="ri-file-line fs-1"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Edit Mode (Hidden by default) -->
                                                        <div class="researcher-note-edit-mode" style="display: none;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="form-label"><strong>Original Content</strong></label>
                                                                    <textarea class="form-control original-content-edit" style="min-height: 150px;">{{ $item->original_content ?? $item->content }}</textarea>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label"><strong>Translated Content</strong></label>
                                                                    <textarea class="form-control translated-content-edit" style="min-height: 150px;">{{ $item->content }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <button type="button" class="btn btn-success save-researcher-note-btn" data-note-id="{{ $item->id }}">
                                                                        <i class="ri-save-line"></i> Save
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary cancel-researcher-edit-btn ms-2">
                                                                        <i class="ri-close-line"></i> Cancel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            <!-- Language Selection -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label">From Language</label>
                                                    <select class="form-control" id="fromLang">
                                                        <option value="en">English</option>
                                                        <option value="hi">Hindi</option>
                                                        <option value="gu">Gujarati</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">To Language</label>
                                                    <select class="form-control" id="toLang">
                                                        <option value="hi">Hindi</option>
                                                        <option value="gu">Gujarati</option>
                                                        <!-- <option value="bn">Bengali</option> -->
                                                        <option value="mr">Marathi</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- New Note Form -->
                                            <div class="row note-row mb-3" id="newResearcherNoteForm">
                                                <div class="col-md-12 mt-2">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <label class="mb-1">
                                                            <img src="{{ asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name)) }}" class="avatar avatar-sm rounded-circle me-2">
                                                            {{ auth()->user()->name }}
                                                        </label>
                                                        <span class="text-end">Current Date and Time</span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label"><strong>Original Content</strong></label>
                                                            <textarea class="form-control translation-input" data-output-id="new-researcher-note-translated" rows="4" placeholder="Enter original content..."></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"><strong>Translated Content</strong></label>
                                                            <textarea class="form-control" id="new-researcher-note-translated" style="min-height: 100px;" placeholder="Translated content will appear here..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mt-2">
                                                        <div class="col-md-6">
                                                            <label class="">Attachment</label>
                                                            <input type="file" class="form-control" id="newResearcherNoteAttachments" multiple accept="image/*,audio/*,.pdf" max="10485760" onchange="validateFileSize(this)">
                                                            <small class="text-muted">Allowed file types: Images, Audio files, PDF (Max 10MB total for all files)</small>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" id="saveNewResearcherNote" class="btn btn-primary">
                                                                <i class="ri-save-line"></i> Save Note
                                                            </button>
                                                            <button type="button" id="clearNewResearcherNote" class="btn btn-secondary ms-2">
                                                                <i class="ri-refresh-line"></i> Clear
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end researcher conversation --}}
                                        </div>

                                        <div class="tab-pane" id="researcherview" role="tabpanel">

                                            @foreach ($data->researcherView as $item)
                                                @php
                                                    $nameParts = explode(' ', $item->user->name ?? '');
                                                    $initials = '';
                                                    if (count($nameParts) > 0) {
                                                        $initials .= strtoupper(substr($nameParts[0], 0, 1));
                                                        if (count($nameParts) > 1) {
                                                            $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                                        }
                                                    }
                                                @endphp
                                                <div class="col-lg-12 mb-2">
                                                    <label class="d-flex align-items-center mb-2">
                                                        <img src="{{ asset(get_profile_image($item->user->profile_image, $item->user->name)) }}" class="avatar avatar-sm rounded-circle me-2">
                                                        {{ $item->user->name ?? '' }}
                                                    </label>
                                                    <p name="content" rows="10" readonly>{{ strip_tags($item->content) }}</p>
                                                </div>
                                            @endforeach
                                            <!-- Language Selection -->
                                            @if (!($data->researcherView->count() > 0))
                                                <form action="{{ url('admin/researcher/store-view/') }}" method="post">
                                                    @csrf
                                                    <div class="row mb-3">
                                                        <input type="hidden" name="type" id="viewType" value="view">
                                                        <input type="hidden" name="clientId" id="clientId" value="{{ $data->id }}">

                                                        <div class="col-md-6">
                                                            <label for="fromLangView">From Language</label>
                                                            <select class="form-control" id="fromLangView">
                                                                <option value="en">English</option>
                                                                <option value="hi">Hindi</option>
                                                                <option value="gu">Gujarati</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="toLangView">To Language</label>
                                                            <select class="form-control" id="toLangView">
                                                                <option value="hi">Hindi</option>
                                                                <option value="gu">Gujarati</option>
                                                                <option value="bn">Bengali</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div id="noteContainerView" class="row">
                                                        <div class="row note-row mb-3">
                                                            <div class="col-md-6">
                                                                <img src="{{ asset(get_profile_image(auth()->user()->profile_image, auth()->user()->name)) }}" class="avatar avatar-sm rounded-circle me-2">
                                                                {{ auth()->user()->name ?? '' }}
                                                                <textarea class="form-control translation-input-view" data-output-id="output-view-default" rows="4"></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="mb-3"><strong>Translated Output</strong></label>
                                                                <textarea name="content[]" class="form-control" id="output-view-default" style="min-height: 100px;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer text-end m-2">
                                                        <button type="submit" id="saveViewNotes" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            @endif
                                            <div class="text-center">
                                                <a href="{{ url('admin/researcher/create-report/' . $data->id) }}" value="true" class="btn btn-success">Create Researcher Report</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Translation Script -->
    <script>
        const fromLangEl = document.getElementById('fromLang');
        const toLangEl = document.getElementById('toLang');

        // Translate plain text
        function translateText(text, fromLang, toLang, outputElement) {
            if (!text.trim()) {
                outputElement.innerHTML = '';
                return;
            }

            fetch('https://translation.googleapis.com/language/translate/v2?key={{ env('TRANSLATION_API') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        q: text,
                        source: fromLang,
                        target: toLang,
                        format: 'text',
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data?.data?.translations?.[0]) {
                        outputElement.innerHTML = data.data.translations[0].translatedText;
                    } else {
                        outputElement.innerHTML = 'Translation failed.';
                    }
                })
                .catch(err => {
                    console.error(err);
                    outputElement.innerHTML = 'Error during translation.';
                });
        }

        // Trigger translation
        function handleTranslationInput(e) {
            const textarea = e.target;
            const outputId = textarea.getAttribute('data-output-id');
            const output = document.getElementById(outputId);
            const fromLang = fromLangEl.value;
            const toLang = toLangEl.value;
            translateText(textarea.value, fromLang, toLang, output);
        }

        // Attach translation event listener to all current translation textareas
        function attachTranslationListeners() {
            const inputs = document.querySelectorAll('.translation-input');
            inputs.forEach(input => {
                input.removeEventListener('input', handleTranslationInput); // Prevent multiple
                input.addEventListener('input', handleTranslationInput);
            });
        }

        // Language dropdown change triggers re-translation
        [fromLangEl, toLangEl].forEach(select => {
            select.addEventListener('change', () => {
                document.querySelectorAll('.translation-input').forEach(input => {
                    input.dispatchEvent(new Event('input'));
                });
            });
        });

        // Initialize
        attachTranslationListeners();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fromLang = document.getElementById('fromLangView');
            const toLang = document.getElementById('toLangView');

            function translateText(text, from, to, outputEl) {
                if (!text.trim()) {
                    outputEl.value = '';
                    return;
                }

                fetch(`https://translation.googleapis.com/language/translate/v2?key={{ env('TRANSLATION_API') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            q: text,
                            source: from,
                            target: to,
                            format: 'text',
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        const translated = data?.data?.translations?.[0]?.translatedText;
                        outputEl.value = translated || 'Translation failed.';
                    })
                    .catch(err => {
                        console.error(err);
                        outputEl.value = 'Error during translation.';
                    });
            }

            function handleInputChange(e) {
                const input = e.target;
                const outputId = input.getAttribute('data-output-id');
                const output = document.getElementById(outputId);
                const from = fromLang.value;
                const to = toLang.value;

                if (output) {
                    translateText(input.value, from, to, output);
                }
            }

            function attachViewInputListeners() {
                const inputs = document.querySelectorAll('.translation-input-view');
                inputs.forEach(input => {
                    input.removeEventListener('input', handleInputChange);
                    input.addEventListener('input', handleInputChange);
                });
            }

            // Re-translate all when language changes
            [fromLang, toLang].forEach(langSelect => {
                langSelect.addEventListener('change', () => {
                    document.querySelectorAll('.translation-input-view').forEach(input => {
                        input.dispatchEvent(new Event('input'));
                    });
                });
            });

            attachViewInputListeners();
        });
    </script>

    <!-- Researcher Note Management Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const clientId = {{ $data->id }};
            const leadId = {{ $data->lead->id }};

            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // File size validation function
            function validateFileSize(input) {
                const maxSize = 10 * 1024 * 1024; // 10MB
                const files = input.files;
                let totalSize = 0;

                for (let i = 0; i < files.length; i++) {
                    totalSize += files[i].size;
                }

                if (totalSize > maxSize) {
                    alert('Total file size exceeds 10MB limit');
                    input.value = '';
                    return false;
                }
                return true;
            }

            // Show alert function
            function showAlert(message, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                // Insert alert at the top of the conversation section
                $('#conversation').prepend(alertHtml);
                
                // Auto remove after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut();
                }, 5000);
            }

            // Translate text function for researcher notes
            function translateResearcherText(text, fromLang, toLang, outputElement) {
                if (!text.trim()) {
                    outputElement.value = '';
                    return;
                }

                fetch('https://translation.googleapis.com/language/translate/v2?key={{ env('TRANSLATION_API') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        q: text,
                        source: fromLang,
                        target: toLang,
                        format: 'text',
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data?.data?.translations?.[0]) {
                        outputElement.value = data.data.translations[0].translatedText;
                    } else {
                        outputElement.value = 'Translation failed.';
                    }
                })
                .catch(err => {
                    console.error(err);
                    outputElement.value = 'Error during translation.';
                });
            }

            // Handle translation input for researcher notes
            function handleResearcherTranslationInput(e) {
                const textarea = e.target;
                const outputId = textarea.getAttribute('data-output-id');
                const output = document.getElementById(outputId);
                const fromLang = document.getElementById('fromLang').value;
                const toLang = document.getElementById('toLang').value;
                
                if (output) {
                    translateResearcherText(textarea.value, fromLang, toLang, output);
                }
            }

            // Attach translation listeners for researcher notes
            function attachResearcherTranslationListeners() {
                const inputs = document.querySelectorAll('.translation-input');
                inputs.forEach(input => {
                    input.removeEventListener('input', handleResearcherTranslationInput);
                    input.addEventListener('input', handleResearcherTranslationInput);
                });
            }

            // Save new researcher note
            $('#saveNewResearcherNote').click(function() {
                const originalContent = $('.translation-input[data-output-id="new-researcher-note-translated"]').val();
                const translatedContent = $('#new-researcher-note-translated').val();
                const attachments = $('#newResearcherNoteAttachments')[0].files;

                if (!originalContent.trim() || !translatedContent.trim()) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please enter note content',
                        icon: 'error',
                        timer: 3000,
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                const formData = new FormData();
                formData.append('original_content', originalContent);
                formData.append('translated_content', translatedContent);
                
                for (let i = 0; i < attachments.length; i++) {
                    formData.append('attachments[]', attachments[i]);
                }

                $.ajax({
                    url: `/admin/researcher/${clientId}/notes`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Add the new note to the page
                            addResearcherNoteToPage(response.note);
                            
                            // Clear the form
                            clearNewResearcherNoteForm();
                            
                            // Show success message
                            showAlert('Note added successfully!', 'success');
                        } else {
                            showAlert(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showAlert(response?.message || 'Error adding note', 'error');
                    }
                });
            });

            // Clear new researcher note form
            $('#clearNewResearcherNote').click(function() {
                clearNewResearcherNoteForm();
            });

            function clearNewResearcherNoteForm() {
                $('.translation-input[data-output-id="new-researcher-note-translated"]').val('');
                $('#new-researcher-note-translated').val('');
                $('#newResearcherNoteAttachments').val('');
            }

            // Add researcher note to page
            function addResearcherNoteToPage(note) {
                const currentTime = new Date().toLocaleString('en-US', {
                    weekday: 'short',
                    day: 'numeric',
                    month: 'long',
                    hour: 'numeric',
                    minute: 'numeric'
                });

                const noteHtml = `
                    <div class="col-md-12 mb-2" data-note-id="${note.id}">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="d-flex align-items-center mb-2 form-label">
                                <img src="${note.user_image}" class="avatar avatar-sm rounded-circle me-2">
                                ${note.user_name}
                            </label>
                            <div class="d-flex align-items-center">
                                <span class="text-end me-2">${note.created_at}</span>
                                <button type="button" class="btn btn-sm btn-outline-primary edit-researcher-note-btn" data-note-id="${note.id}">
                                    <i class="ri-edit-line"></i> Edit
                                </button>
                            </div>
                        </div>
                        
                        <!-- View Mode -->
                        <div class="researcher-note-view-mode">
                            <p name="content" rows="10" readonly>${note.content}</p>
                            ${note.attachments && note.attachments.length > 0 ? `
                                <div class="file-item d-flex align-items-center gap-2 mt-2">
                                    ${note.attachments.map(att => `
                                        <div class="attachment-item">
                                            <a href="${att.attachment}" target="_blank" class="text-decoration-none">
                                                <i class="ri-${att.icon}-line fs-1"></i>
                                            </a>
                                        </div>
                                    `).join('')}
                                </div>
                            ` : ''}
                        </div>

                        <!-- Edit Mode (Hidden by default) -->
                        <div class="researcher-note-edit-mode" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Original Content</strong></label>
                                    <textarea class="form-control original-content-edit" style="min-height: 150px;">${note.original_content || note.content}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Translated Content</strong></label>
                                    <textarea class="form-control translated-content-edit" style="min-height: 150px;">${note.content}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success save-researcher-note-btn" data-note-id="${note.id}">
                                        <i class="ri-save-line"></i> Save
                                    </button>
                                    <button type="button" class="btn btn-secondary cancel-researcher-edit-btn ms-2">
                                        <i class="ri-close-line"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Insert the new note after the last existing researcher note, before the language selection
                const existingResearcherNotes = $('.col-md-12.mb-2[data-note-id]');
                if (existingResearcherNotes.length > 0) {
                    // Insert after the last existing researcher note
                    existingResearcherNotes.last().after(noteHtml);
                } else {
                    // If no existing researcher notes, insert before the language selection
                    $('.row.mb-4').before(noteHtml);
                }
                
                // Reattach event listeners
                attachResearcherNoteEventListeners();
                
                // Reattach translation listeners
                attachResearcherTranslationListeners();
            }

            // Edit researcher note functionality
            $(document).on('click', '.edit-researcher-note-btn', function() {
                const noteRow = $(this).closest('.col-md-12.mb-2');
                const noteId = noteRow.data('note-id');
                
                noteRow.find('.researcher-note-view-mode').hide();
                noteRow.find('.researcher-note-edit-mode').show();
                
                // Add translation functionality to edit mode textareas
                const originalTextarea = noteRow.find('.original-content-edit');
                const translatedTextarea = noteRow.find('.translated-content-edit');
                
                // Check if translation classes are already added
                if (!originalTextarea.hasClass('translation-input')) {
                    // Add translation input class and data attribute
                    originalTextarea.addClass('translation-input').attr('data-output-id', 'edit-translated-' + noteId);
                    translatedTextarea.attr('id', 'edit-translated-' + noteId);
                }
                
                // Reattach translation listeners
                attachResearcherTranslationListeners();
                
                // Trigger translation for the current content
                setTimeout(() => {
                    originalTextarea.trigger('input');
                }, 100);
            });

            // Cancel edit
            $(document).on('click', '.cancel-researcher-edit-btn', function() {
                const noteRow = $(this).closest('.col-md-12.mb-2');
                noteRow.find('.researcher-note-edit-mode').hide();
                noteRow.find('.researcher-note-view-mode').show();
                
                // Remove translation classes when canceling edit mode
                const originalTextarea = noteRow.find('.original-content-edit');
                const translatedTextarea = noteRow.find('.translated-content-edit');
                originalTextarea.removeClass('translation-input').removeAttr('data-output-id');
                translatedTextarea.removeAttr('id');
            });

            // Save edited researcher note
            $(document).on('click', '.save-researcher-note-btn', function() {
                const noteId = $(this).data('note-id');
                const noteRow = $(this).closest('.col-md-12.mb-2');
                const originalContent = noteRow.find('.original-content-edit').val();
                const translatedContent = noteRow.find('.translated-content-edit').val();

                if (!originalContent.trim() || !translatedContent.trim()) {
                    showAlert('Please fill in both original and translated content', 'error');
                    return;
                }

                $.ajax({
                    url: `/admin/researcher/notes/${noteId}`,
                    type: 'PUT',
                    data: {
                        original_content: originalContent,
                        translated_content: translatedContent
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the view mode content
                            noteRow.find('.researcher-note-view-mode p').text(response.note.content);
                            
                            // Switch back to view mode
                            noteRow.find('.researcher-note-edit-mode').hide();
                            noteRow.find('.researcher-note-view-mode').show();
                            
                            // Remove translation classes when switching back to view mode
                            const originalTextarea = noteRow.find('.original-content-edit');
                            const translatedTextarea = noteRow.find('.translated-content-edit');
                            originalTextarea.removeClass('translation-input').removeAttr('data-output-id');
                            translatedTextarea.removeAttr('id');
                            
                            showAlert('Note updated successfully!', 'success');
                        } else {
                            showAlert(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showAlert(response?.message || 'Error updating note', 'error');
                    }
                });
            });

            // Language dropdown change triggers re-translation for researcher notes
            $('#fromLang, #toLang').on('change', function() {
                document.querySelectorAll('.translation-input').forEach(input => {
                    input.dispatchEvent(new Event('input'));
                });
            });

            // Attach event listeners to existing researcher notes
            function attachResearcherNoteEventListeners() {
                // Event listeners are already attached via document.on('click') above
            }

            // Initialize
            attachResearcherNoteEventListeners();
            attachResearcherTranslationListeners();
        });
    </script>
@endsection
