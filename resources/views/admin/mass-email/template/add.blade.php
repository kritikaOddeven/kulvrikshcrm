@extends('admin.layouts.app')
@section('pagetitle','Add Template | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Add Template</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Mass Email</a></li>
                <li class="breadcrumb-item active"><a href="{{url('admin/mass-email/template')}}">View All Template</a></li>
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
                <form action="{{url('/admin/mass-email/template/store')}}" method="post">
                    @csrf
                    <div class="card-body mb-0">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="validationDefault01" class="form-label">Template Name <x-required-star /></label>
                                <input type="text" class="form-control" name="template_name" placeholder="Enter Template Name">
                                <span class="text-danger">
                                    @error('template_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label">Subject <x-required-star /></label>
                                <input type="text" class="form-control" name="subject" placeholder="Enter Subject">
                                <span class="text-danger">
                                    @error('subject')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Basic Information <x-required-star /></label>
                                <div class="mb-1 text-muted" style="font-size: 0.95em;">
                                    <strong>Note:</strong> You can use <code>[firstname]</code>, <code>[lastname]</code>, and <code>[fullname]</code> in your template. They will be replaced with the recipient's full name, first name, and last name respectively.
                                </div>
                                <textarea name="description" id="editor" class="editor" placeholder="Description" cols="30" rows="10"></textarea>
                                <span class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{url('admin/mass-email/template')}}" type="button" id="notes" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="notes" class="btn btn-primary"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
