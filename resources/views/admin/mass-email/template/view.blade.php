@extends('admin.layouts.app')
@section('pagetitle','View Template | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">View Template</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Mass Email</a></li>
                <li class="breadcrumb-item active"><a href="{{url('admin/mass-email/template')}}">View All Template</a></li>
                <li class="breadcrumb-item active">View Template</li>
            </ol>
        </div>

    </div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body mb-0">
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Template Name :<span class="text-light1"> {{$template->template_name}} </span></p>
                    </div>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Subject :<span class="text-light1"> {{$template->subject}} </span></p>
                    </div>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Basic Information</p>
                    </div>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Subject:<span class="text-light1"> {{$template->subject}} </span></p>
                        <p>{!!$template->description!!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
