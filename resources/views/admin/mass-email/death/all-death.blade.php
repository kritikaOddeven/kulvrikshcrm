@extends('admin.layouts.app')
@section('pagetitle','All-Death | Kulvriksh')
@section('admin-content')
<style>
    .choices__inner{
        background-color: #fff !important;
    }
</style>
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">All Death Anniversaries</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Mass Email</a></li>
                <li class="breadcrumb-item active">All Death Anniversaries</li>
            </ol>
        </div>
        <div class="col-auto">
           <div class="d-flex justify-content-end align-items-center gap-2">
                @can('send_birthday_email')
                    <button id="openCampaignModal" class="btn btn-primary" disabled>Send</button>
                @endcan
                <x-filter :countries="$countries" />
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Alert message --}}
        <x-alert />
        <div class="col-12">
            <div class="card">
                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Name</th>
                                <th>Relation</th>
                                <th>Death Date</th>
                                <th>Email Id</th>
                                <th>Phone Number</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($anniversaries as $anniversary)
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" value="{{ $anniversary['id'] }}" data-email="{{ $anniversary['email'] }}" data-name="{{ $anniversary['name'] }}" data-id="{{ $anniversary['id'] }}" data-type="{{ $anniversary['type'] }}" data-relation="{{ $anniversary['relation'] }}"></td>
                                    <td>{{ $anniversary['name'] }}</td>
                                    <td>{{ $anniversary['relation'] }}</td>
                                    <td>{{ $anniversary['death_date'] ? \Carbon\Carbon::parse($anniversary['death_date'])->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $anniversary['email'] ?? '-' }}</td>
                                    <td>{{ $anniversary['phone'] ?? '-' }}</td>
                                    <td>{{ $anniversary['country'] ?? '' }}</td>
                                    <td>{{ $anniversary['state'] ?? '' }}</td>
                                    <td>{{ $anniversary['city'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
     @include('admin.mass-email.campaign.send-campaign-modal')
@endsection 