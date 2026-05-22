@extends('admin.layouts.app')
@section('pagetitle', 'Add Whatsapp Template | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Add Template</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp Message</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('admin/whatsapp/template') }}">View All Template</a></li>
                <li class="breadcrumb-item active">Add Template</li>
            </ol>
        </div>

        <style>
            .cke_notification {
                display: none !important;
            }
        </style>
    </div>


    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <form action="{{ url('/admin/whatsapp/template/store') }}" method="post">
                    @csrf
                    <div class="card-body mb-0">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="validationDefault01" class="form-label">Template Name <x-required-star /></label>
                                <input type="text" class="form-control" name="template_name" placeholder="Enter Template Name" value="{{ old('template_name') }}">
                                <span class="text-danger">
                                    @error('template_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="validationDefault01" class="form-label">Template API Name</label>
                                <input type="text" class="form-control" name="template_api_name" placeholder="Enter Template API Name" value="{{ old('template_api_name') }}">
                                <span class="text-danger">
                                    @error('template_api_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="validationDefault01" class="form-label">Template Type</label>
                                <select class="form-select" id="template_type" name="template_type">
                                    <option value="">Text Message Only</option>
                                    <option value="text_with_document" {{ old('template_type') == 'text_with_document' ? 'selected' : '' }}>Text Message only with Document</option>
                                    <option value="text_with_image" {{ old('template_type') == 'text_with_image' ? 'selected' : '' }}>Text Message only with Image</option>
                                    <option value="text_with_video" {{ old('template_type') == 'text_with_video' ? 'selected' : '' }}>Text Message only with Video</option>
                                    <option value="text_with_button" {{ old('template_type') == 'text_with_button' ? 'selected' : '' }}>Text Message only with Button</option>
                                    <option value="list_message" {{ old('template_type') == 'list_message' ? 'selected' : '' }}>List Message</option>
                                </select>
                                <span class="text-danger">
                                    @error('template_type')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Message Text <x-required-star /></label>
                                <div class="mb-1 text-muted" style="font-size: 0.95em;">
                                    <strong>Note:</strong> You can use <code>[firstname]</code>, <code>[lastname]</code>, <code>[fullname]</code>, and <code>[name]</code> in your template. They will be replaced with the recipient's details.
                                </div>
                                <textarea name="message_text" class="form-control" placeholder="Message Text" rows="6">{{ old('message_text') }}</textarea>
                                <span class="text-danger">
                                    @error('message_text')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-12 mb-2 d-none" id="document_field">
                                <label for="validationDefault04" class="form-label">Document Upload</label>
                                <input type="file" class="form-control" id="image" name="document" accept=".doc, .docx">
                                <small class="text-danger">Maximum upload file size: 5MB. Accepted formats: doc, docx.</small>
                            </div>

                            <div class="col-md-12 mb-2 d-none" id="image_field">
                                <label for="validationDefault04" class="form-label">Image Upload</label>
                                <input type="file" class="form-control" id="image" name="image" accept=".png, .jpg, .jpeg">
                                <small class="text-danger">Maximum upload file size: 5MB. Accepted formats: PNG, JPG.</small>
                            </div>

                            <div class="col-md-12 mb-2 d-none" id="video_field">
                                <label for="validationDefault04" class="form-label">Video Upload</label>
                                <input type="file" class="form-control" id="image" name="video" accept="video/*">
                                <small class="text-danger">Maximum upload file size: 5MB. Accepted formats: PNG, JPG.</small>
                            </div>


                            <div class="col-md-12 mb-2">
                                <label class="form-label">Template Footer</label>
                                <textarea name="template_footer" class="form-control" placeholder="Template Footer" rows="3">{{ old('template_footer') }}</textarea>
                                <span class="text-danger">
                                    @error('template_footer')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ url('admin/whatsapp/template') }}" type="button" id="notes" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="notes" class="btn btn-primary"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const templateTypeSelect = document.getElementById('template_type');
            const documentField = document.getElementById('document_field');
            const imageField = document.getElementById('image_field');
            const videoField = document.getElementById('video_field');
            
            // Function to toggle fields
            function toggleFields() {
                let type = templateTypeSelect.value;

                // Hide all fields
                documentField.classList.add('d-none');
                imageField.classList.add('d-none');
                videoField.classList.add('d-none');

                // Show according to selected type
                if (type === 'text_with_document') {
                    documentField.classList.remove('d-none');
                } else if (type === 'text_with_image') {
                    imageField.classList.remove('d-none');
                } else if (type === 'text_with_video') {
                    videoField.classList.remove('d-none');
                }
            }

            // Add event listener
            templateTypeSelect.addEventListener('change', toggleFields);
            
            // Initialize on page load (for form validation errors)
            toggleFields();
        });
    </script>

@endsection
