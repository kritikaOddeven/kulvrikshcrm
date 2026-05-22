<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="true" aria-controls="panelsStayOpen-collapseEight">
            Notes
        </button>
    </h2>
    <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse show">

        <div class="accordion-body">

            <style>
                .cke_notification {
                    display: none !important;
                }
            </style>


            <!-- Language Selection -->
            <div class="row mb-4">
                <div class="col-md-6 mb-2">
                    <label class="form-label">From Language</label>
                    <select class="form-control" id="fromLang" name="original_language">
                        <option value="en">English</option>
                        <option value="hi">Hindi</option>
                        <option value="gu">Gujarati</option>
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">To Language</label>
                    <select class="form-control" id="toLang" name="translated_language">
                        <option value="hi">Hindi</option>
                        <option value="gu">Gujarati</option>
                        <!-- <option value="bn">Bengali</option> -->
                        <option value="mr">Marathi</option>
                        
                    </select>
                </div>
            </div>

            <!-- Notes Container with One Default Row -->
            <div id="noteContainer" class="row">
                <div class="row note-row mb-3">
                    <div class="col-md-6">
                        <label class="mb-1 form-label">
                            <img src="<?php echo e(asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name))); ?>" class="avatar avatar-sm rounded-circle me-2">

                            <?php echo e(auth()->user()->name); ?>

                        </label>
                        <textarea class="form-control translation-input" data-output-id="output-default" rows="4" name="original_content[]"></textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="form-label">Translated Output</label>
                            <span class="text-end form-label">Current Date and Time</span>
                        </div>
                        <textarea name="content[]" class="form-control" id="output-default" style="min-height: 100px;"></textarea>
                    </div>
                </div>

                <div class="row mb-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Attachment</label>
                        <input type="file" class="form-control" name="attachment[0][]" multiple accept="image/*,audio/*,.pdf" max="10485760" onchange="validateFileSize(this)">
                        <small class="text-muted">Allowed file types: Images, Audio files, PDF (Max 10MB total for all files)</small>

                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="row justify-content-between">
                <div class="col-auto mb-2">
                    <button id="addNoteRow" class="btn btn-primary">+ Add Note</button>
                </div>
                <div class="col-auto mb-2">
                    <button id="deleteNoteRow" class="btn btn-danger" style="display: none;"><i class="ri-delete-bin-line"></i> Delete</button>
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

                    fetch('https://translation.googleapis.com/language/translate/v2?key=<?php echo e(env('TRANSLATION_API')); ?>', {
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

                // Add new note
                document.getElementById('addNoteRow').addEventListener('click', function(e) {
                    e.preventDefault();

                    const container = document.getElementById("noteContainer");
                    const uniqueId = 'output-' + Date.now();
                    const noteIndex = document.querySelectorAll('.note-row').length;

                    const newRow = document.createElement("div");
                    newRow.classList.add("row", "note-row", "mb-3");

                    newRow.innerHTML = `
                        <div class="col-md-6">
                            <label class="mb-1 form-label">
                                <img src="<?php echo e(asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name))); ?>" class="avatar avatar-sm rounded-circle me-2">

                                <?php echo e(auth()->user()->name); ?>

                            </label>
                            <textarea name="original_content[]" class="form-control translation-input" data-output-id="${uniqueId}" rows="4"></textarea>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-label">Translated Output</label>
                                <span class="text-end form-label">Current Date and Time</span>
                            </div>
                            <textarea name="content[]" class="form-control" id="${uniqueId}" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="row mb-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Attachment</label>
                                <input type="file" class="form-control" name="attachment[${noteIndex}][]" multiple accept="image/*,audio/*,.pdf" max="10485760" onchange="validateFileSize(this)">
                                <small class="text-muted">Allowed file types: Images, Audio files, PDF (Max 10MB total for all files)</small>
                            </div>
                        </div>
                    `;

                    container.appendChild(newRow);
                    attachTranslationListeners();
                    
                    // Show delete button when we have more than one row
                    document.getElementById('deleteNoteRow').style.display = 'block';
                });

                // Delete last note row
                document.getElementById("deleteNoteRow").addEventListener("click", function(e) {
                    e.preventDefault();
                    const rows = document.querySelectorAll(".note-row");
                    if (rows.length > 1) {
                        rows[rows.length - 1].remove();
                        
                        // Hide delete button when we're back to one row
                        if (document.querySelectorAll('.note-row').length === 1) {
                            this.style.display = 'none';
                        }
                    }
                });

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

        </div>

        
        <div id="noteContainer" class="row">
            <!-- Dynamic form rows will be added here -->
        </div>

    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/partials/lead-note.blade.php ENDPATH**/ ?>