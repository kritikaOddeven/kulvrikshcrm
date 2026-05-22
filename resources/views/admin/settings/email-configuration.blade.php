@extends('admin.layouts.app')
@section('pagetitle','Mail Configuration | Kulvriksh')
@section('admin-content')
    <style>
        .accordion-item {
            border-radius: 0 !important;
        }
    </style>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Mail Configuration</h4>
            {{-- <p>Agents/View All Agents</p> --}}
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Mail Configuration</a></li>
                <li class="breadcrumb-item active"><a href="#">View SMTP Configuration</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">SMTP Settings</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ url('admin/settings/smtp/update') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3 row">
                            <label class="col-md-4 form-label">Type</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="type" value="smtp" placeholder="MAIL TYPE">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL HOST</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="host" value="{{ $settings['host'] ?? '' }}" placeholder="MAIL HOST">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL PORT</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="port" value="{{ $settings['port'] ?? '' }}" placeholder="MAIL PORT">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL USERNAME</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="username" value="{{ $settings['username'] ?? '' }}" placeholder="MAIL USERNAME">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL PASSWORD</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="password" value="{{ $settings['password'] ?? '' }}" placeholder="MAIL PASSWORD">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL ENCRYPTION</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="encryption" value="{{ $settings['encryption'] ?? '' }}" placeholder="MAIL ENCRYPTION">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL FROM ADDRESS</label>
                            </div>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="from_address" value="{{ $settings['from_address'] ?? '' }}" placeholder="MAIL FROM ADDRESS">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-label">MAIL FROM NAME</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="from_name" value="{{ $settings['from_name'] ?? '' }}" placeholder="MAIL FROM NAME">
                            </div>
                        </div>

                        <div class="form-group mb-0 mt-2 text-end">
                            <button type="submit" name="submit" value="smtp" class="btn btn-primary">Save Configuration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            @livewire('smtp-test')

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Instruction</h5>
                </div>
                <div class="card-body">
                    <h6 class="form-label">For Non-SSL</h6>
                    <ul class="list-group">
                        <li class="list-group-item text-dark">Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver</li>
                        <li class="list-group-item text-dark">Set Mail Host according to your server Mail Client Manual Settings</li>
                        <li class="list-group-item text-dark">Set Mail port as 587</li>
                        <li class="list-group-item text-dark">Set Mail Encryption as ssl if you face issue with tls</li>
                    </ul>
                    <br>
                    <h6 class="form-label">For SSL</h6>
                    <ul class="list-group mar-no">
                        <li class="list-group-item text-dark">Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver</li>
                        <li class="list-group-item text-dark">Set Mail Host according to your server Mail Client Manual Settings</li>
                        <li class="list-group-item text-dark">Set Mail port as 465</li>
                        <li class="list-group-item text-dark">Set Mail Encryption as ssl</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
