@extends('admin.layouts.app')
@section('pagetitle', 'Address Setting | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Address Settings</h4>
            <p>Address Settings</p>
        </div>
    </div>


    <div class="row">
        {{-- Alert message --}}
        <x-alert />
        <div class="col-lg-12 col-md-12">
            <div class="card bg-light">
                <div class="card-bady">
                    <ul class="nav nav-pills nav-justified bg-light" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-country" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="mdi mdi-country-account"></i></span>
                                <span class="d-none d-sm-block">Country Setting</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-state" role="tab" aria-selected="false" tabindex="-1">
                                <span class="d-block d-sm-none"><i class="mdi mdi-account-outline"></i></span>
                                <span class="d-none d-sm-block">State Setting</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-district" role="tab" aria-selected="false" tabindex="-1">
                                <span class="d-block d-sm-none"><i class="mdi mdi-email-outline"></i></span>
                                <span class="d-none d-sm-block">District Setting</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-city" role="tab" aria-selected="false" tabindex="-1">
                                <span class="d-block d-sm-none"><i class="mdi mdi-cog"></i></span>
                                <span class="d-none d-sm-block">City Settings</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-taluka" role="tab" aria-selected="false" tabindex="-1">
                                <span class="d-block d-sm-none"><i class="mdi mdi-cog"></i></span>
                                <span class="d-none d-sm-block">Taluka Settings</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-village" role="tab" aria-selected="false" tabindex="-1">
                                <span class="d-block d-sm-none"><i class="mdi mdi-cog"></i></span>
                                <span class="d-none d-sm-block">Village Settings</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 text-muted mt-md-0">
                        {{-- country --}}
                        <div class="tab-pane  active show" id="navpills2-country" role="tabpanel">
                            @can('add_country')
                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Add Country</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.settings.countries.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label"> Country Name
                                                        <x-required-star />
                                                    </label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control" type="text" name="country_name" value="">
                                                        <span class="text-danger">
                                                            @error('name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label"> Phone Code <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control" type="text" name="phonecode" value="">
                                                        <span class="text-danger">
                                                            @error('phonecode')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xl-12 text-end">
                                                <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endcan
                            <div class="card">
                                <div class="card-body card-body2">
                                    <table id="datatable" class="table table-responsive">
                                        <thead class="table-info">
                                            <tr>
                                                <th>Country Name</th>
                                                <th>Phone Code</th>
                                                <th data-orderable="false">Action</th>
                                            </tr>
                                        </thead>

                                        {{-- boday data --}}
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- state --}}

                        <div class="tab-pane" id="navpills2-state" role="tabpanel">
                            @can('add_state')
                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Add State</h4>
                                    </div>
                                </div>
                                <div class="card-body mb-0">
                                    <form action="{{ route('admin.settings.states.store') }}" method="POST" class="needs-validation">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Country Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="country_id_state" name="country_id">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" {{ $country->name == 'India' ? 'selected' : '' }}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger country-error">
                                                            @error('country_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">State Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control" type="text" name="state_name" value="">
                                                        <span class="text-danger">
                                                            @error('state_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-lg-12 col-xl-12 text-end">
                                                <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end col -->
                            @endcan

                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title"> State List</h4>
                                    </div>
                                </div>
                                <div class="card-body card-body2">
                                    <table id="state-datatable" class="table table-responsive">
                                        <thead class="table-info">
                                            <tr>
                                                <th>Country Name</th>
                                                <th>State Name</th>
                                                <th data-orderable="false">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- district --}}
                        <div class="tab-pane" id="navpills2-district" role="tabpanel">
                            @can('add_district')
                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Add District</h4>
                                    </div>
                                </div>
                                <div class="card-body mb-0">
                                    <form action="{{ route('admin.settings.districts.store') }}" method="POST" class="needs-validation">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Country Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="country_id_district" name="country_id">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" {{ $country->name == 'India' ? 'selected' : '' }}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger country-error">
                                                            @error('country_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">State Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="state_id_district" name="state_id">
                                                            <option value="">Select State</option>
                                                        </select>
                                                        <span class="text-danger state-error">
                                                            @error('state_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">District Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control" type="text" name="district_name" value="">
                                                        <span class="text-danger">
                                                            @error('district_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xl-12 text-end">
                                                <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end col -->
                            @endcan

                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">District List</h4>
                                    </div>
                                </div>
                                <div class="card-body card-body2">
                                    <table id="district-datatable" class="table table-responsive">
                                        <thead class="table-info">
                                            <tr>
                                                <th>State Name</th>
                                                <th>District Name</th>
                                                <th data-orderable="false">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- city --}}
                        <div class="tab-pane" id="navpills2-city" role="tabpanel">
                            @can('add_city')
                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Add City</h4>
                                    </div>
                                </div>
                                <div class="card-body mb-0">
                                    <form action="{{ route('admin.settings.cities.store') }}" method="POST" class="needs-validation">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Country Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="country_id_city" name="country_id">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" {{ $country->name == 'India' ? 'selected' : '' }}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger country-error">
                                                            @error('country_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">State Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="state_id_city" name="state_id">
                                                            <option value="">Select State</option>
                                                        </select>
                                                        <span class="text-danger state-error">
                                                            @error('state_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">City Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control" type="text" name="city_name" value="">
                                                        <span class="text-danger">
                                                            @error('city_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xl-12 text-end">
                                                <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end col -->
                            @endcan

                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">City List</h4>
                                    </div>
                                </div>
                                <div class="card-body card-body2">
                                    <table id="city-datatable" class="table table-responsive">
                                        <thead class="table-info">
                                            <tr>
                                                <th>State Name</th>
                                                <th>City Name</th>
                                                <th data-orderable="false">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- taluka --}}
                        <div class="tab-pane" id="navpills2-taluka" role="tabpanel">
                            @can('add_taluka')
                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Add Taluka</h4>
                                    </div>
                                </div>
                                <div class="card-body mb-0">
                                    <form action="{{ route('admin.settings.talukas.store') }}" method="POST" class="needs-validation">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Country Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="country_id_taluka" name="country_id">
                                                            <option disabled>Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" {{ $country->name == 'India' ? 'selected' : '' }}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger country-error">
                                                            @error('country_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">State Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="state_id_taluka" name="state_id">
                                                            <option value="">Select State</option>
                                                        </select>
                                                        <span class="text-danger state-error">
                                                            @error('state_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">City Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="city_id_taluka" name="city_id">
                                                            <option value="">Select City</option>
                                                        </select>
                                                        <span class="text-danger state-error">
                                                            @error('city_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Taluka Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control" type="text" name="taluka_name" value="">
                                                        <span class="text-danger">
                                                            @error('taluka_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xl-12 text-end">
                                                <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end col -->
                            @endcan

                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Taluka List</h4>
                                    </div>
                                </div>
                                <div class="card-body card-body2">
                                    <table id="taluka-datatable" class="table table-responsive">
                                        <thead class="table-info">
                                            <tr>
                                                <th>State Name</th>
                                                <th>City Name</th>
                                                <th>Taluka Name</th>
                                                <th data-orderable="false">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- village --}}
                        <div class="tab-pane" id="navpills2-village" role="tabpanel">
                            @can('add_village')
                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Add Village</h4>
                                    </div>
                                </div>
                                <div class="card-body mb-0">
                                    <form action="{{ route('admin.settings.villages.store') }}" method="POST" class="needs-validation">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Country Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="country_id_village" name="country_id">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" {{ $country->name == 'India' ? 'selected' : '' }}>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger country-error">
                                                            @error('country_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">State Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="state_id_village" name="state_id">
                                                            <option value="">Select State</option>
                                                        </select>
                                                        <span class="text-danger state-error">
                                                            @error('state_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">City Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="city_id_village" name="city_id">
                                                            <option value="">Select City</option>
                                                        </select>
                                                        <span class="text-danger state-error">
                                                            @error('city_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Taluka Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <select class="form-select js-choice" id="taluka_id_village" name="taluka_id">
                                                            <option value="">Select Taluka</option>
                                                        </select>
                                                        <span class="text-danger state-error">
                                                            @error('taluka_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Village Name <x-required-star /></label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control" type="text" name="village_name" value="">
                                                        <span class="text-danger">
                                                            @error('village_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xl-12 text-end">
                                                <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end col -->
                            @endcan

                            <div class="card">
                                <div class="card-header">
                                    <div class="profile">
                                        <h4 class="card-title">Village List</h4>
                                    </div>
                                </div>
                                <div class="card-body card-body2">
                                    <table id="village-datatable" class="table table-responsive">
                                        <thead class="table-info">
                                            <tr>
                                                <th>State Name</th>
                                                <th>City Name</th>
                                                <th>Taluka Name</th>
                                                <th>Village Name</th>
                                                <th data-orderable="false">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modals --}}
    {{-- Country Edit Modal --}}
    <div class="modal fade" id="editCountryModal" tabindex="-1" aria-labelledby="editCountryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCountryModalLabel">Edit Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCountryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Country Name <x-required-star /></label>
                            <input type="text" class="form-control" id="edit_country_name" name="country_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Code <x-required-star /></label>
                            <input type="text" class="form-control" id="edit_phonecode" name="phonecode" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- State Edit Modal --}}
    <div class="modal fade" id="editStateModal" tabindex="-1" aria-labelledby="editStateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStateModalLabel">Edit State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStateForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Country <x-required-star /></label>
                            <select class="form-select" id="edit_state_country_id" name="country_id" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State Name <x-required-star /></label>
                            <input type="text" class="form-control" id="edit_state_name" name="state_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- District Edit Modal --}}
    <div class="modal fade" id="editDistrictModal" tabindex="-1" aria-labelledby="editDistrictModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDistrictModalLabel">Edit District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDistrictForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Country <x-required-star /></label>
                            <select class="form-select" id="edit_district_country_id" name="country_id" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State <x-required-star /></label>
                            <select class="form-select" id="edit_district_state_id" name="state_id" required>
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">District Name <x-required-star /></label>
                            <input type="text" class="form-control" id="edit_district_name" name="district_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- City Edit Modal --}}
    <div class="modal fade" id="editCityModal" tabindex="-1" aria-labelledby="editCityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCityModalLabel">Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCityForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Country <x-required-star /></label>
                            <select class="form-select" id="edit_city_country_id" name="country_id" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State <x-required-star /></label>
                            <select class="form-select" id="edit_city_state_id" name="state_id" required>
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City Name <x-required-star /></label>
                            <input type="text" class="form-control" id="edit_city_name" name="city_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Taluka Edit Modal --}}
    <div class="modal fade" id="editTalukaModal" tabindex="-1" aria-labelledby="editTalukaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTalukaModalLabel">Edit Taluka</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTalukaForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Country <x-required-star /></label>
                            <select class="form-select" id="edit_taluka_country_id" name="country_id" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State <x-required-star /></label>
                            <select class="form-select" id="edit_taluka_state_id" name="state_id" required>
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <x-required-star /></label>
                            <select class="form-select" id="edit_taluka_city_id" name="city_id" required>
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Taluka Name <x-required-star /></label>
                            <input type="text" class="form-control" id="edit_taluka_name" name="taluka_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Village Edit Modal --}}
    <div class="modal fade" id="editVillageModal" tabindex="-1" aria-labelledby="editVillageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVillageModalLabel">Edit Village</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editVillageForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Country <x-required-star /></label>
                            <select class="form-select" id="edit_village_country_id" name="country_id" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State <x-required-star /></label>
                            <select class="form-select" id="edit_village_state_id" name="state_id" required>
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <x-required-star /></label>
                            <select class="form-select" id="edit_village_city_id" name="city_id" required>
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Taluka <x-required-star /></label>
                            <select class="form-select" id="edit_village_taluka_id" name="taluka_id" required>
                                <option value="">Select Taluka</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Village Name <x-required-star /></label>
                            <input type="text" class="form-control" id="edit_village_name" name="village_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Country, State, City, Taluka, Village Handling --}}
    <script>
        $(document).ready(function() {
            // Initialize dropdowns when page loads
            function initializeDropdowns() {
                // Set India as default country for all forms
                $('select[id^="country_id"]').each(function() {
                    if ($(this).find('option[value!=""]').length > 0) {
                        const indiaOption = $(this).find('option').filter(function() {
                            return $(this).text().trim() === 'India';
                        });
                        if (indiaOption.length > 0) {
                            $(this).val(indiaOption.val()).trigger('change');
                        }
                    }
                });
            }

            function setupLocationHandlers(prefix = '') {
                // Select elements by prefix
                const countrySelect = document.querySelector(`#country_id${prefix}`);
                const stateSelect = document.querySelector(`#state_id${prefix}`);
                const citySelect = document.querySelector(`#city_id${prefix}`);
                const talukaSelect = document.querySelector(`#taluka_id${prefix}`);

                if (!countrySelect) return;

                // Use existing Choices instance or initialize if missing
                const countryChoices = countrySelect.choicesInstance;
                const stateChoices = stateSelect ? stateSelect.choicesInstance : null;
                const cityChoices = citySelect ? citySelect.choicesInstance : null;
                const talukaChoices = talukaSelect ? talukaSelect.choicesInstance : null;

                function updateChoices(choicesInstance, data, placeholder) {
                    if (!choicesInstance) return;
                    choicesInstance.clearStore();
                    const choices = [{
                        value: '',
                        label: `-- ${placeholder} --`,
                        selected: true,
                        disabled: true
                    }];
                    data.forEach(item => {
                        choices.push({
                            value: item.id,
                            label: item.name,
                            selected: false
                        });
                    });
                    choicesInstance.setChoices(choices, 'value', 'label', false);
                }

                // Function to load states for a country
                function loadStatesForCountry(countryId) {
                    if (stateChoices) updateChoices(stateChoices, [], 'Loading states...');
                    if (cityChoices) updateChoices(cityChoices, [], 'Select City');
                    if (talukaChoices) updateChoices(talukaChoices, [], 'Select Taluka');

                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        if (stateChoices) updateChoices(stateChoices, states, 'Select State');
                    }).fail(function() {
                        if (stateChoices) updateChoices(stateChoices, [], 'Select State');
                    });
                }

                // Country change event
                $(`#country_id${prefix}`).on('change', function() {
                    const countryId = this.value;
                    if (countryId) {
                        loadStatesForCountry(countryId);
                    }
                });

                // State change event
                if (stateSelect && stateChoices) {
                    $(`#state_id${prefix}`).on('change', function() {
                        const stateId = this.value;
                        if (cityChoices) updateChoices(cityChoices, [], 'Loading cities...');
                        if (talukaChoices) updateChoices(talukaChoices, [], 'Select Taluka');

                        if (stateId) {
                            $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                                if (cityChoices) updateChoices(cityChoices, cities, 'Select City');
                            }).fail(function() {
                                if (cityChoices) updateChoices(cityChoices, [], 'Select City');
                            });
                        }
                    });
                }

                // City change event
                if (citySelect && cityChoices) {
                    $(`#city_id${prefix}`).on('change', function() {
                        const cityId = this.value;
                        if (talukaChoices) updateChoices(talukaChoices, [], 'Loading talukas...');

                        if (cityId) {
                            $.getJSON(`/admin/settings/get-talukas/${cityId}`).done(function(talukas) {
                                if (talukaChoices) updateChoices(talukaChoices, talukas, 'Select Taluka');
                            }).fail(function() {
                                if (talukaChoices) updateChoices(talukaChoices, [], 'Select Taluka');
                            });
                        }
                    });
                }

                // Taluka change event
                if (talukaSelect && talukaChoices) {
                    $(`#taluka_id${prefix}`).on('change', function() {
                        const talukaId = this.value;
                        // You can add village loading here if needed
                    });
                }
            }

            // Handle edit form submissions
            $('#editCountryForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editCountryModal').modal('hide');
                            $('#datatable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'Country updated successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            });

            $('#editStateForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editStateModal').modal('hide');
                            $('#state-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'State updated successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            });

            $('#editDistrictForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editDistrictModal').modal('hide');
                            $('#district-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'District updated successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            });

            $('#editCityForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editCityModal').modal('hide');
                            $('#city-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'City updated successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            });

            $('#editTalukaForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editTalukaModal').modal('hide');
                            $('#taluka-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'Taluka updated successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            });

            $('#editVillageForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editVillageModal').modal('hide');
                            $('#village-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'Village updated successfully',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            });

            // Initialize for all sets of dropdowns
            setupLocationHandlers(''); // For main forms
            setupLocationHandlers('_state'); // For state form
            setupLocationHandlers('_district'); // For district form
            setupLocationHandlers('_city'); // For city form
            setupLocationHandlers('_taluka'); // For taluka form
            setupLocationHandlers('_village'); // For village form

            // Initialize dropdowns after a short delay to ensure Choices.js is loaded
            setTimeout(initializeDropdowns, 500);

            // Edit and Delete functionality
            setupEditDeleteHandlers();
        });

        function setupEditDeleteHandlers() {
            // Country edit/delete
            $(document).on('click', '.edit-country', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const phonecode = $(this).data('phonecode');

                $('#edit_country_name').val(name);
                $('#edit_phonecode').val(phonecode);
                $('#editCountryForm').attr('action', `/admin/settings/countries/update/${id}`);
                $('#editCountryModal').modal('show');
            });

            $(document).on('click', '.delete-country', function() {
                const id = $(this).data('id');
                const button = this;
                
                // Call the existing deleteAccount function from sweetalert2.js
                deleteAccount(button, id);
            });

            // Handle delete confirmation from SweetAlert
            $(document).on('click', '#deleteForm_country', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/admin/settings/countries/delete/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#datatable').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Country has been deleted.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error deleting country',
                        });
                    }
                });
            });

            // State edit/delete
            $(document).on('click', '.edit-state', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const countryId = $(this).data('country-id');

                $('#edit_state_name').val(name);
                $('#edit_state_country_id').val(countryId);
                $('#editStateForm').attr('action', `/admin/settings/states/update/${id}`);
                $('#editStateModal').modal('show');
            });

            $(document).on('click', '.delete-state', function() {
                const id = $(this).data('id');
                const button = this;
                button.dataset.title = 'Delete State';
                button.dataset.description = 'Are you sure you want to delete this state? This action cannot be undone.';
                
                Swal.fire({
                    title: 'Delete State?',
                    text: 'Are you sure you want to delete this state? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/settings/states/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#state-datatable').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message || 'State has been deleted.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error deleting state',
                                });
                            }
                        });
                    }
                });
            });

            // District edit/delete
            $(document).on('click', '.edit-district', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const stateId = $(this).data('state-id');
                const countryId = $(this).data('country-id');

                $('#edit_district_name').val(name);
                $('#edit_district_country_id').val(countryId).trigger('change');
                
                // Load states then set the selected state
                $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                    $('#edit_district_state_id').empty().append('<option value="">Select State</option>');
                    states.forEach(state => {
                        $('#edit_district_state_id').append(`<option value="${state.id}" ${state.id == stateId ? 'selected' : ''}>${state.name}</option>`);
                    });
                });
                
                $('#editDistrictForm').attr('action', `/admin/settings/districts/update/${id}`);
                $('#editDistrictModal').modal('show');
            });

            $(document).on('click', '.delete-district', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Delete District?',
                    text: 'Are you sure you want to delete this district? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/settings/districts/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#district-datatable').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message || 'District has been deleted.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error deleting district',
                                });
                            }
                        });
                    }
                });
            });

            // City edit/delete
            $(document).on('click', '.edit-city', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const stateId = $(this).data('state-id');
                const countryId = $(this).data('country-id');

                $('#edit_city_name').val(name);
                $('#edit_city_country_id').val(countryId).trigger('change');
                
                // Load states then set the selected state
                $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                    $('#edit_city_state_id').empty().append('<option value="">Select State</option>');
                    states.forEach(state => {
                        $('#edit_city_state_id').append(`<option value="${state.id}" ${state.id == stateId ? 'selected' : ''}>${state.name}</option>`);
                    });
                });
                
                $('#editCityForm').attr('action', `/admin/settings/cities/update/${id}`);
                $('#editCityModal').modal('show');
            });

            $(document).on('click', '.delete-city', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Delete City?',
                    text: 'Are you sure you want to delete this city? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/settings/cities/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#city-datatable').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message || 'City has been deleted.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error deleting city',
                                });
                            }
                        });
                    }
                });
            });

            // Taluka edit/delete
            $(document).on('click', '.edit-taluka', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const cityId = $(this).data('city-id');
                const stateId = $(this).data('state-id');
                const countryId = $(this).data('country-id');

                $('#edit_taluka_name').val(name);
                $('#edit_taluka_country_id').val(countryId).trigger('change');
                
                // Load states, cities then set selections
                $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                    $('#edit_taluka_state_id').empty().append('<option value="">Select State</option>');
                    states.forEach(state => {
                        $('#edit_taluka_state_id').append(`<option value="${state.id}" ${state.id == stateId ? 'selected' : ''}>${state.name}</option>`);
                    });
                    
                    // Load cities after states
                    $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                        $('#edit_taluka_city_id').empty().append('<option value="">Select City</option>');
                        cities.forEach(city => {
                            $('#edit_taluka_city_id').append(`<option value="${city.id}" ${city.id == cityId ? 'selected' : ''}>${city.name}</option>`);
                        });
                    });
                });
                
                $('#editTalukaForm').attr('action', `/admin/settings/talukas/update/${id}`);
                $('#editTalukaModal').modal('show');
            });

            $(document).on('click', '.delete-taluka', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Delete Taluka?',
                    text: 'Are you sure you want to delete this taluka? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/settings/talukas/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#taluka-datatable').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message || 'Taluka has been deleted.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error deleting taluka',
                                });
                            }
                        });
                    }
                });
            });

            // Village edit/delete
            $(document).on('click', '.edit-village', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const talukaId = $(this).data('taluka-id');
                const cityId = $(this).data('city-id');
                const stateId = $(this).data('state-id');
                const countryId = $(this).data('country-id');

                $('#edit_village_name').val(name);
                $('#edit_village_country_id').val(countryId).trigger('change');
                
                // Load states, cities, talukas then set selections
                $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                    $('#edit_village_state_id').empty().append('<option value="">Select State</option>');
                    states.forEach(state => {
                        $('#edit_village_state_id').append(`<option value="${state.id}" ${state.id == stateId ? 'selected' : ''}>${state.name}</option>`);
                    });
                    
                    // Load cities after states
                    $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                        $('#edit_village_city_id').empty().append('<option value="">Select City</option>');
                        cities.forEach(city => {
                            $('#edit_village_city_id').append(`<option value="${city.id}" ${city.id == cityId ? 'selected' : ''}>${city.name}</option>`);
                        });
                        
                        // Load talukas after cities
                        $.getJSON(`/admin/settings/get-talukas/${cityId}`).done(function(talukas) {
                            $('#edit_village_taluka_id').empty().append('<option value="">Select Taluka</option>');
                            talukas.forEach(taluka => {
                                $('#edit_village_taluka_id').append(`<option value="${taluka.id}" ${taluka.id == talukaId ? 'selected' : ''}>${taluka.name}</option>`);
                            });
                        });
                    });
                });
                
                $('#editVillageForm').attr('action', `/admin/settings/villages/update/${id}`);
                $('#editVillageModal').modal('show');
            });

            $(document).on('click', '.delete-village', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Delete Village?',
                    text: 'Are you sure you want to delete this village? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/settings/villages/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#village-datatable').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message || 'Village has been deleted.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error deleting village',
                                });
                            }
                        });
                    }
                });
            });

            // Handle dropdown changes in edit modals
            $('#edit_district_country_id').on('change', function() {
                const countryId = $(this).val();
                if (countryId) {
                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        $('#edit_district_state_id').empty().append('<option value="">Select State</option>');
                        states.forEach(state => {
                            $('#edit_district_state_id').append(`<option value="${state.id}">${state.name}</option>`);
                        });
                    });
                }
            });

            $('#edit_city_country_id').on('change', function() {
                const countryId = $(this).val();
                if (countryId) {
                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        $('#edit_city_state_id').empty().append('<option value="">Select State</option>');
                        states.forEach(state => {
                            $('#edit_city_state_id').append(`<option value="${state.id}">${state.name}</option>`);
                        });
                    });
                }
            });

            $('#edit_taluka_country_id').on('change', function() {
                const countryId = $(this).val();
                if (countryId) {
                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        $('#edit_taluka_state_id').empty().append('<option value="">Select State</option>');
                        states.forEach(state => {
                            $('#edit_taluka_state_id').append(`<option value="${state.id}">${state.name}</option>`);
                        });
                    });
                }
            });

            $('#edit_taluka_state_id').on('change', function() {
                const stateId = $(this).val();
                if (stateId) {
                    $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                        $('#edit_taluka_city_id').empty().append('<option value="">Select City</option>');
                        cities.forEach(city => {
                            $('#edit_taluka_city_id').append(`<option value="${city.id}">${city.name}</option>`);
                        });
                    });
                }
            });

            $('#edit_village_country_id').on('change', function() {
                const countryId = $(this).val();
                if (countryId) {
                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        $('#edit_village_state_id').empty().append('<option value="">Select State</option>');
                        states.forEach(state => {
                            $('#edit_village_state_id').append(`<option value="${state.id}">${state.name}</option>`);
                        });
                    });
                }
            });

            $('#edit_village_state_id').on('change', function() {
                const stateId = $(this).val();
                if (stateId) {
                    $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                        $('#edit_village_city_id').empty().append('<option value="">Select City</option>');
                        cities.forEach(city => {
                            $('#edit_village_city_id').append(`<option value="${city.id}">${city.name}</option>`);
                        });
                    });
                }
            });

            $('#edit_village_city_id').on('change', function() {
                const cityId = $(this).val();
                if (cityId) {
                    $.getJSON(`/admin/settings/get-talukas/${cityId}`).done(function(talukas) {
                        $('#edit_village_taluka_id').empty().append('<option value="">Select Taluka</option>');
                        talukas.forEach(taluka => {
                            $('#edit_village_taluka_id').append(`<option value="${taluka.id}">${taluka.name}</option>`);
                        });
                    });
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            function getParam(name) {
                const url = new URL(window.location.href);
                return url.searchParams.get(name);
            }

            // Countries DataTable
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.settings.countries.datatable') }}',
                    data: function(d) {
                        d.name = getParam('name');
                    }
                },
                columns: [{
                        data: 'name',
                        title: 'Country Name'
                    },
                    {
                        data: 'phonecode',
                        title: 'Phone Code'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // States DataTable
            $('#state-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.settings.states.datatable') }}',
                    data: function(d) {
                        d.name = getParam('name');
                    }
                },
                columns: [{
                        data: 'country_name',
                        title: 'Country Name'
                    },
                    {
                        data: 'name',
                        title: 'State Name'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Districts DataTable
            $('#district-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.settings.districts.datatable') }}',
                    data: function(d) {
                        d.name = getParam('name');
                    }
                },
                columns: [{
                        data: 'state_name',
                        title: 'State Name'
                    },
                    {
                        data: 'name',
                        title: 'District Name'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Cities DataTable
            $('#city-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.settings.cities.datatable') }}',
                    data: function(d) {
                        d.name = getParam('name');
                    }
                },
                columns: [{
                        data: 'state_name',
                        title: 'State Name'
                    },
                    {
                        data: 'name',
                        title: 'City Name'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Talukas DataTable
            $('#taluka-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.settings.talukas.datatable') }}',
                    data: function(d) {
                        d.name = getParam('name');
                    }
                },
                columns: [{
                        data: 'state_name',
                        title: 'State Name'
                    },
                    {
                        data: 'city_name',
                        title: 'City Name'
                    },
                    {
                        data: 'name',
                        title: 'Taluka Name'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Villages DataTable
            $('#village-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.settings.villages.datatable') }}',
                    data: function(d) {
                        d.name = getParam('name');
                    }
                },
                columns: [{
                        data: 'state_name',
                        title: 'State Name'
                    },
                    {
                        data: 'city_name',
                        title: 'City Name'
                    },
                    {
                        data: 'taluka_name',
                        title: 'Taluka Name'
                    },
                    {
                        data: 'name',
                        title: 'Village Name'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
