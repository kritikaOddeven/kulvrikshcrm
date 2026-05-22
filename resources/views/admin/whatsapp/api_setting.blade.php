@extends('admin.layouts.app')
@section('pagetitle', 'Add Whatsapp Api Key | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Add Api Key</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp Message</a></li>
                <li class="breadcrumb-item active">Add API Key</li>
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
                <form action="{{ url('/admin/whatsapp/api/store') }}" method="post">
                    @csrf
                    <div class="card-body mb-0">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="validationDefault01" class="form-label">Api key <x-required-star /></label>
                                <input type="text" class="form-control" name="api_key" placeholder="Enter Api key" value="{{ old('api_key') }}">
                                <span class="text-danger">
                                    @error('api_key')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="validationDefault01" class="form-label">Security key <x-required-star /></label>
                                <input type="text" class="form-control" name="security_key" placeholder="Enter Security Key" value="{{ old('security_key') }}">
                                <span class="text-danger">
                                    @error('security_key')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ url('admin/whatsapp/api') }}" type="button" id="notes" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="notes" class="btn btn-primary"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
