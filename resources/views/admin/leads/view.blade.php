@extends('admin.layouts.app')
@section('pagetitle','View Lead | Kulvriksh')
@section('admin-content')
    <style>
        .info-table th, .info-table td { border: none; }
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

    @include('admin.leads.details.header-actions', ['data' => $data])

    <div class="row">
        <div class="col-xl-12">
            <div class="card lead-view-box">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    @include('admin.leads.details.lead-info', ['data' => $data])
                    @include('admin.leads.details.lineage-info', ['data' => $data])
                    @include('admin.leads.details.family-info', ['data' => $data])
                    @include('admin.leads.details.wife-info', ['data' => $data])
                    @include('admin.leads.details.wife-lineage-info', ['data' => $data])
                    @include('admin.leads.details.wife-family-info', ['data' => $data])
                    @include('admin.leads.details.children-info', ['data' => $data])
                    @include('admin.leads.details.lead-notes', ['data' => $data])
                </div>
            </div>
        </div>
    </div>

    @include('admin.leads.modals.lead-to-client-modal')
@endsection
