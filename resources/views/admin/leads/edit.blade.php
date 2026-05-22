@extends('admin.layouts.app')
@section('pagetitle', 'Edit Lead | Kulvriksh')
@section('admin-content')
    <style>
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
    {{-- Alert message --}}
    <x-alert />


    <form action="{{ url('admin/leads/update/' . $data->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row py-3 align-items-center justify-content-between gap-2">
            <div class="col-auto">
                <h4 class="page-title">Edit Lead</h4>
                {{-- <p>Agents/View All Agents</p> --}}
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lead</a></li>
                    <li class="breadcrumb-item active"><a href="{{ url('admin/leads') }}">View All Leads</a></li>
                    <li class="breadcrumb-item active">Edit Leads</li>
                </ol>
            </div>
            <div class="col-auto">
                <a href="{{ url('admin/leads') }}" type="button" id="notes" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" id="notes" class="btn btn-primary"> Save</button>
            </div>
        </div>
        <input type="hidden" name="id" id="id" value="{{ $data->id }}">
        <div class="row">
            <div class="col-xl-12">
                <div class="card form-box">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        {{-- lead info --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    Lead Information
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">First Name
                                                <x-required-star />
                                            </label>
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ $data->first_name }}">
                                            <span class="text-danger">
                                                @error('first_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" name="middle_name"
                                                value="{{ $data->middle_name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Last Name
                                                <x-required-star />
                                            </label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ $data->last_name }}">
                                            <span class="text-danger">
                                                @error('last_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">DOB</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="dob"
                                                    value="{{ $data->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    name="marriage_date" value="{{ $data->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Phone No.
                                                <x-required-star />
                                            </label>
                                            <div class="input-group">
                                                <input type="hidden" name="phonecode"
                                                    value="{{ $data->phonecode ?? '+91' }}">
                                                <span class="input-group-text"
                                                    id="phonecode">{{ $data->phonecode ?? '+91' }}</span>
                                                <input type="text" class="form-control" name="phone" maxlength="10"
                                                    value="{{ $data->phone ?? '' }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                            <span class="text-danger">
                                                @error('phone')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Alternate Mobile
                                                number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    id="alternate_phonecode">{{ $data->phonecode ?? '+91' }}</span>
                                                <input type="text" class="form-control" name="alternate_mobile_number"
                                                    value="{{ $data->alternate_mobile_number }}" maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $data->email }}">
                                            <span class="text-danger">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Country
                                                <x-required-star />
                                            </label>
                                            <select class="form-select js-choice lead-edit-country" id="country"
                                                name="country">
                                                <option selected disabled>Select Country</option>
                                                @foreach ($country as $item)
                                                    <option @if ($data->country == $item->id) selected @endif
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger country-error">
                                                @error('country')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">State
                                                <x-required-star />
                                            </label>
                                            {{-- {{dd($data->state)}} --}}
                                            <select class="form-select js-choice lead-edit-state" id="state"
                                                name="state">
                                                <option selected disabled>Select State</option>
                                                @foreach ($states as $stateData)
                                                    <option @if ($data->state == $stateData->id) selected @endif
                                                        value="{{ $stateData->id }}">{{ $stateData->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger state-error">
                                                @error('state')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">District
                                                <x-required-star />
                                            </label>
                                            <select class="form-select js-choice lead-edit-district" id="district"
                                                name="district">
                                                <option selected disabled>Select District</option>
                                                @foreach ($districts as $districtData)
                                                    <option @if ($data->district == $districtData->id) selected @endif
                                                        value="{{ $districtData->id }}">{{ $districtData->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger district-error">
                                                @error('district')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">City<x-required-star /></label>
                                            <select class="form-select js-choice lead-edit-city" id="city"
                                                name="city">
                                                <option selected disabled>Select City</option>
                                                @foreach ($cities as $cityData)
                                                    <option @if ($data->city == $cityData->id) selected @endif
                                                        value="{{ $cityData->id }}">{{ $cityData->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger city-error">
                                                @error('city')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="taluka" class="form-label">Taluka</label>
                                            <select class="form-select js-choice" id="taluka" name="taluka">
                                                <option value="" disabled selected>Select Taluka</option>
                                                @foreach ($talukas as $talukaData)
                                                    <option @if (isset($data->taluka) && $data->taluka == $talukaData->id) selected @endif
                                                        value="{{ $talukaData->id }}">
                                                        {{ $talukaData->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger taluka-error">
                                                @error('taluka')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="village" class="form-label">Village</label>
                                            <select class="form-select js-choice" id="village" name="village">
                                                <option value="" disabled selected>Select Village</option>
                                                @foreach ($villages as $villageData)
                                                    <option @if (isset($data->village) && $data->village == $villageData->id) selected @endif
                                                        value="{{ $villageData->id }}">
                                                        {{ $villageData->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger village-error">
                                                @error('village')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="col-md-6 ">
                                            <label for="validationDefault01" class="form-label">Address</label>
                                            <input type="text" class="form-control" name="notes_address" value="{{ $data->village ?? '' }}">
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Family lineage and heritage --}}
                        @php
                            $family_lineage = $data->lineages()->where('belongs_to', 'lead')->first();
                            $wifeFamily_lineage = $data->lineages()->where('belongs_to', 'wife')->first();
                        @endphp
                        {{-- Family lineage and heritage --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    Family lineage and heritage
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                <input type="hidden" name="belongs_to[]" value="lead">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="lineage" class="form-label">Lineage</label>
                                            <input type="text" class="form-control" id="lineage" name="lineage[]"
                                                value="{{ $family_lineage->lineage ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="caste" class="form-label">Caste</label>
                                            <input type="text" class="form-control" id="caste" name="caste[]"
                                                value="{{ $family_lineage->caste ?? '' }}">

                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="sub_caste" class="form-label">Sub-caste</label>
                                            <input type="text" class="form-control" id="sub_caste" name="sub_caste[]"
                                                value="{{ $family_lineage->sub_caste ?? '' }}">

                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="surname" class="form-label">Surname</label>
                                            <input type="text" class="form-control" id="surname" name="surname[]"
                                                value="{{ $family_lineage->surname ?? '' }}">
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="gotra" class="form-label">Gotra</label>
                                            <input type="text" class="form-control" id="gotra" name="gotra[]"
                                                value="{{ $family_lineage->gotra ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="kuldevi" class="form-label">Kuldevi</label>
                                            <input type="text" class="form-control" id="kuldevi" name="kuldevi[]"
                                                value="{{ $family_lineage->kuldevi ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="kuldevta" class="form-label">Kuldevta</label>
                                            <input type="text" class="form-control" id="kuldevta" name="kuldevta[]"
                                                value="{{ $family_lineage->kuldevta ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="primary_clan" class="form-label">Primary Clan</label>
                                            <input type="text" class="form-control" id="primary_clan"
                                                name="primary_clan[]" value="{{ $family_lineage->primary_clan ?? '' }}">
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="sub_clan" class="form-label">Sub-clan</label>
                                            <input type="text" class="form-control" id="sub_clan" name="sub_clan[]"
                                                value="{{ $family_lineage->sub_clan ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="khap" class="form-label">Khap</label>
                                            <input type="text" class="form-control" id="khap" name="khap[]"
                                                value="{{ $family_lineage->khap ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="rulership" class="form-label">Rulership</label>
                                            <input type="text" class="form-control" id="rulership" name="rulership[]"
                                                value="{{ $family_lineage->rulership ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="spiritual_seat" class="form-label">Spiritual Seat</label>
                                            <input type="text" class="form-control" id="spiritual_seat"
                                                name="spiritual_seat[]"
                                                value="{{ $family_lineage->spiritual_seat ?? '' }}">
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="ancestral_village" class="form-label">Ancestral Village</label>
                                            <input type="text" class="form-control" id="ancestral_village"
                                                maxlength="255" name="ancestral_village[]"
                                                value="{{ $family_lineage->ancestral_village ?? '' }}">
                                        </div>

                                        <div class="col-12 mb-2">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea class="form-control" id="notes" name="notes[]" rows="3">{{ $family_lineage->note ?? '' }}</textarea>
                                        </div>

                                        <div class="col-12 mb-2 text-end">
                                            <button type="submit" name="save" value="panelsStayOpen-collapseThree"
                                                class="btn btn-primary" id="addLineage">Save</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- family member Info --}}
                        @php
                            $family = $data->families->where('belongs_to', 'lead')->keyBy('relation');
                            $wifeFamily = $data->families->where('belongs_to', 'wife')->keyBy('relation');
                            $gg_family = $data->families
                                ->where('belongs_to', 'lead')
                                ->whereIn('relation', ['great-grandfather', 'great-grandmother'])
                                ->groupBy('relation');
                        @endphp

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseTwo">
                                    Family Information
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row">
                                        <!-- Father Details -->
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Father Name</label>
                                            <input type="text" class="form-control" name="family[father][name]"
                                                value="{{ $family['father']->name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[father][birth_date]"
                                                    value="{{ $family['father']->birth_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[father][marriage_date]"
                                                    value="{{ $family['father']->marriage_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[father][death_date]"
                                                    value="{{ $family['father']->death_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <!-- Mother Details -->
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Mother Name</label>
                                            <input type="text" class="form-control" name="family[mother][name]"
                                                value="{{ $family['mother']->name }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[mother][birth_date]"
                                                    value="{{ $family['mother']->birth_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[mother][marriage_date]"
                                                    value="{{ $family['mother']->marriage_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[mother][death_date]"
                                                    value="{{ $family['mother']->death_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <!-- Grandfather Details -->
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Grandfather Name</label>
                                            <input type="text" class="form-control" name="family[grandfather][name]"
                                                value="{{ $family['grandfather']->name }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[grandfather][birth_date]"
                                                    value="{{ $family['grandfather']->birth_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[grandfather][marriage_date]"
                                                    value="{{ $family['grandfather']->marriage_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[grandfather][death_date]"
                                                    value="{{ $family['grandfather']->death_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <!-- Grandmother Details -->
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Grandmother Name</label>
                                            <input type="text" class="form-control" name="family[grandmother][name]"
                                                value="{{ $family['grandmother']->name }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[grandmother][birth_date]"
                                                    value="{{ $family['grandmother']->birth_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[grandmother][marriage_date]"
                                                    value="{{ $family['grandmother']->marriage_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="family[grandmother][death_date]"
                                                    value="{{ $family['grandmother']->death_date }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <!-- Great-Grandfather Details -->
                                        @foreach ($gg_family['great-grandfather'] ?? [] as $gf)
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Great-Grandfather Name</label>
                                                <input type="text" class="form-control" name="ggf_name[]"
                                                    value="{{ $gf->name ?? '' }}">
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Birth Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="ggf_dob[]"
                                                        value="{{ $gf->birth_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Marriage Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="ggf_marriage_date[]"
                                                        value="{{ $gf->marriage_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Death Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="ggf_death_date[]"
                                                        value="{{ $gf->death_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Great-Grandmother Details -->
                                        @foreach ($gg_family['great-grandmother'] ?? [] as $gm)
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Great-Grandmother Name</label>
                                                <input type="text" class="form-control" name="ggm_name[]"
                                                    value="{{ $gm->name ?? '' }}">
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Birth Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="ggm_dob[]"
                                                        value="{{ $gf->birth_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Marriage Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="ggm_marriage_date[]"
                                                        value="{{ $gf->marriage_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label class="form-label">Death Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="ggm_death_date[]"
                                                        value="{{ $gf->death_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Dynamic row will be added here for Great-Grandfather/mother details -->
                                        <div id="dynamicContainer">
                                            <!-- Dynamic content will be added here -->
                                        </div>
                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <div class="col-auto mb-2">
                                                <button id="addMore" class="btn btn-primary">+ Add More</button>
                                            </div>
                                            <div class="col-auto mb-2">
                                                <button id="delete" class="btn btn-danger" style="display: none;"><i
                                                        class="ri-delete-bin-line"></i>
                                                    Delete</button>
                                            </div>
                                        </div>

                                        <!-- Siblings -->
                                        @foreach ($data->siblings->where('belongs_to', 'lead') as $index => $sibling)
                                            <div id="siblingsContainer">
                                                <div class="sibling-row row mb-3" data-index="0">
                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Brother / Sister</label>
                                                        <select class="form-select" name="sibling_relation[]">
                                                            <option disabled selected>Select</option>
                                                            <option
                                                                {{ $sibling->relation === 'brother' ? 'selected' : '' }}
                                                                value="brother">Brother</option>
                                                            <option {{ $sibling->relation === 'sister' ? 'selected' : '' }}
                                                                value="sister">Sister</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="sibling_name[]"
                                                            value="{{ $sibling->name ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Birth Date</label>
                                                        <div class="position-relative">
                                                            <input type="text"
                                                                class="form-control basic-datepicker pe-5"
                                                                placeholder="dd-mm-yyyy" name="sibling_dob[]"
                                                                value="{{ $sibling->birth_date ?? '' }}">
                                                            <i class="ri-calendar-2-line calendar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Death Date</label>
                                                        <div class="position-relative">
                                                            <input type="text"
                                                                class="form-control basic-datepicker pe-5"
                                                                placeholder="dd-mm-yyyy" name="sibling_death_date[]"
                                                                value="{{ $sibling->death_date ?? '' }}">
                                                            <i class="ri-calendar-2-line calendar-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if (!($data->siblings->where('belongs_to', 'lead')->count() > 0))
                                            <!-- Siblings -->
                                            <div class="mt-1" id="siblingsContainer">
                                                <div class="sibling-row row" data-index="0">
                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Brother / Sister</label>
                                                        <select class="form-select" name="sibling_relation[]">
                                                            <option disabled selected>Select</option>
                                                            <option value="brother">Brother</option>
                                                            <option value="sister">Sister</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="sibling_name[]">
                                                    </div>

                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Birth Date</label>
                                                        <div class="position-relative">
                                                            <input type="text"
                                                                class="form-control basic-datepicker pe-5"
                                                                name="sibling_dob[]" placeholder="dd-mm-yyyy">
                                                            <i class="ri-calendar-2-line calendar-icon"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6 mb-2">
                                                        <label class="form-label">Death Date</label>
                                                        <div class="position-relative">
                                                            <input type="text"
                                                                class="form-control basic-datepicker pe-5"
                                                                name="sibling_death_date[]" placeholder="dd-mm-yyyy">
                                                            <i class="ri-calendar-2-line calendar-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Dynamic row will be added here for brother sister details --}}

                                        <div id="broSisContainer">
                                            <!-- Dynamic form rows will be added here -->
                                        </div>
                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <div class="col-auto mb-2">
                                                <button id="addBroSisRow" class="btn btn-primary">+ Add More</button>
                                            </div>
                                            <div class="col-auto mb-2">
                                                <button id="deleteBroSisRow" class="btn btn-danger"
                                                    style="display: none;"><i class="ri-delete-bin-line"></i>
                                                    Delete</button>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label for="notes" class="form-label">Ancestor History Notes</label>
                                            <textarea class="form-control" id="ancestor_notes" name="lead_ancestor_notes" rows="3">{{ $data->lead_ancestor_notes }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 text-end">
                                        <button type="submit" name="save" value="panelsStayOpen-collapseTwo"
                                            class="btn btn-primary" id="addLineage">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- lead wife info --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseFour">
                                    Lead Wife Information
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="wife_first_name"
                                                value="{{ $data->wifeDetail->first_name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" name="wife_middle_name"
                                                value="{{ $data->wifeDetail->middle_name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="wife_last_name"
                                                value="{{ $data->wifeDetail->last_name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">DOB</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_dob"
                                                    value="{{ $data->wifeDetail->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_marriage_date"
                                                    value="{{ $data->wifeDetail->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Death Date</label>
                                            <input type="text" class="form-control basic-datepicker"
                                                placeholder="dd-mm-yyyy" name="wife_death_date"
                                                value="{{ $data->wifeDetail->death_date ?? '' }}">
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Phone No.</label>
                                            <div class="input-group">
                                                <input type="hidden" name="wife_phonecode"
                                                    value="{{ $data->wifeDetail->phonecode ?? '+91' }}">
                                                <span class="input-group-text"
                                                    id="wife_phonecode">{{ $data->wifeDetail->phonecode ?? '+91' }}</span>
                                                <input type="text" class="form-control" name="wife_phone"
                                                    maxlength="10" value="{{ $data->wifeDetail->phone ?? '' }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="wife_email"
                                                value="{{ $data->wifeDetail->email ?? '' }}">
                                        </div>

                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Country</label>
                                            <select class="form-select js-choice" id="country1" name="wife_country">
                                                <option selected disabled>Select Country</option>

                                                @foreach ($country as $wifeCountry)
                                                    <option @if (isset($data->wifeDetail->countries->id) && $data->wifeDetail->countries->id == $wifeCountry->id) selected @endif
                                                        value="{{ $wifeCountry->id }}">{{ $wifeCountry->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">State</label>
                                            <select class="form-select js-choice" id="state1" name="wife_state">
                                                <option selected disabled>Select State</option>
                                                @foreach ($wifeStates as $wifeState)
                                                    <option @if (isset($data->wifeDetail->states->id) && $data->wifeDetail->states->id == $wifeState->id) selected @endif
                                                        value="{{ $wifeState->id }}">{{ $wifeState->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">District</label>
                                            <select class="form-select js-choice" id="district1" name="wife_district">
                                                <option selected disabled>Select District</option>
                                                @foreach ($wifeDistricts as $wifeDistrict)
                                                    <option @if (isset($data->wifeDetail->districts->id) && $data->wifeDetail->districts->id == $wifeDistrict->id) selected @endif
                                                        value="{{ $wifeDistrict->id }}">{{ $wifeDistrict->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">City</label>
                                            <select class="form-select js-choice" id="city1" name="wife_city">
                                                <option selected disabled>Select City</option>
                                                @foreach ($wifeCities as $wifeCity)
                                                    <option @if (isset($data->wifeDetail->cities->id) && $data->wifeDetail->cities->id == $wifeCity->id) selected @endif
                                                        value="{{ $wifeCity->id }}">{{ $wifeCity->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="taluka1" class="form-label">Taluka</label>
                                            <select class="form-select js-choice" id="taluka1" name="wife_taluka">
                                                <option disabled>Select Taluka</option>
                                                @foreach ($wifeTalukas as $wifeTaluka)
                                                    <option @if (isset($data->wifeDetail->talukas->id) && $data->wifeDetail->talukas->id == $wifeTaluka->id) selected @endif
                                                        value="{{ $wifeTaluka->id }}">{{ $wifeTaluka->name }}</option>
                                                @endforeach
                                                {{-- @if (isset($data->wifeDetail) && isset($data->wifeDetail->talukas) && $data->wifeDetail->talukas)
                                                    <option value="{{ $data->wifeDetail->talukas->id }}" selected>
                                                        {{ $data->wifeDetail->talukas->name }}</option>
                                                @endif --}}
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="village1" class="form-label">Village</label>
                                            <select class="form-select js-choice" id="village1" name="wife_village">
                                                <option disabled>Select Village</option>
                                                @foreach ($wifeVillages as $wifeVillage)
                                                    <option @if (isset($data->wifeDetail->villages->id) && $data->wifeDetail->villages->id == $wifeVillage->id) selected @endif
                                                        value="{{ $wifeVillage->id }}">{{ $wifeVillage->name }}</option>
                                                @endforeach
                                                {{-- @if (isset($data->wifeDetail) && isset($data->wifeDetail->villages) && $data->wifeDetail->villages)
                                                    <option value="{{ $data->wifeDetail->villages->id }}" selected>
                                                        {{ $data->wifeDetail->villages->name }}</option>
                                                @endif --}}
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Notes/Address</label>
                                            <textarea class="form-control" id="notes_address" name="wife_notes_address" rows="2">{{ $data->wifeDetail->address ?? '' }} </textarea>
                                        </div>

                                        <div class="col-12 mb-2 text-end">
                                            <button type="submit" name="save" value="panelsStayOpen-collapseFour"
                                                class="btn btn-primary" id="addLineage">Save</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Wife Family lineage and heritage --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseSix">
                                    Wife Family lineage and heritage
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse">
                                <input type="hidden" name="belongs_to[]" value="wife">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label for="lineage" class="form-label">Lineage</label>
                                            <input type="text" class="form-control" id="lineage" name="lineage[]"
                                                value="{{ $wifeFamily_lineage->lineage ?? '' }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="caste" class="form-label">Caste</label>
                                            <input type="text" class="form-control" id="caste" name="caste[]"
                                                value="{{ $wifeFamily_lineage->caste ?? '' }}">

                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="sub_caste" class="form-label">Sub-caste</label>
                                            <input type="text" class="form-control" id="sub_caste" name="sub_caste[]"
                                                value="{{ $wifeFamily_lineage->sub_caste ?? '' }}">

                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="surname" class="form-label">Surname</label>
                                            <input type="text" class="form-control" id="surname" name="surname[]"
                                                value="{{ $wifeFamily_lineage->surname ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label for="gotra" class="form-label">Gotra</label>
                                            <input type="text" class="form-control" id="gotra" name="gotra[]"
                                                value="{{ $wifeFamily_lineage->gotra ?? '' }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="kuldevi" class="form-label">Kuldevi</label>
                                            <input type="text" class="form-control" id="kuldevi" name="kuldevi[]"
                                                value="{{ $wifeFamily_lineage->kuldevi ?? '' }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="kuldevta" class="form-label">Kuldevta</label>
                                            <input type="text" class="form-control" id="kuldevta" name="kuldevta[]"
                                                value="{{ $wifeFamily_lineage->kuldevta ?? '' }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="primary_clan" class="form-label">Primary Clan</label>
                                            <input type="text" class="form-control" id="primary_clan"
                                                name="primary_clan[]"
                                                value="{{ $wifeFamily_lineage->primary_clan ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label for="sub_clan" class="form-label">Sub-clan</label>
                                            <input type="text" class="form-control" id="sub_clan" name="sub_clan[]"
                                                value="{{ $wifeFamily_lineage->sub_clan ?? '' }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="khap" class="form-label">Khap</label>
                                            <input type="text" class="form-control" id="khap" name="khap[]"
                                                value="{{ $wifeFamily_lineage->khap ?? '' }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="rulership" class="form-label">Rulership</label>
                                            <input type="text" class="form-control" id="rulership" name="rulership[]"
                                                value="{{ $wifeFamily_lineage->rulership ?? '' }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="spiritual_seat" class="form-label">Spiritual Seat</label>
                                            <input type="text" class="form-control" id="spiritual_seat"
                                                name="spiritual_seat[]"
                                                value="{{ $wifeFamily_lineage->spiritual_seat ?? '' }}">
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="ancestral_village" class="form-label">Ancestral Village</label>
                                            <input type="text" class="form-control" id="ancestral_village"
                                                maxlength="255" name="ancestral_village[]"
                                                value="{{ $wifeFamily_lineage->ancestral_village ?? '' }}">
                                        </div>

                                        <div class="col-12 mb-2">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea class="form-control" id="notes" name="notes[]" rows="3">{{ $wifeFamily_lineage->note ?? '' }}</textarea>
                                        </div>

                                        <div class="col-12 mb-2 text-end">
                                            <button type="submit" name="save" value="panelsStayOpen-collapseSix"
                                                class="btn btn-primary" id="addLineage">Save</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- wife family information --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseFive">
                                    Wife Family Information
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row">
                                        {{-- father details --}}
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Father Name</label>
                                            <input type="text" class="form-control" name="wife_family[father][name]"
                                                value="{{ $wifeFamily['father']->name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[father][birth_date]"
                                                    value="{{ $wifeFamily['father']->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[father][marriage_date]"
                                                    value="{{ $wifeFamily['father']->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[father][death_date]"
                                                    value="{{ $wifeFamily['father']->death_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        {{-- mother details --}}
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Mother Name</label>
                                            <input type="text" class="form-control" name="wife_family[mother][name]"
                                                value="{{ $wifeFamily['mother']->name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[mother][birth_date]"
                                                    value="{{ $wifeFamily['mother']->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[mother][marriage_date]"
                                                    value="{{ $wifeFamily['mother']->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[mother][death_date]"
                                                    value="{{ $wifeFamily['mother']->death_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        {{-- Grandfather details --}}
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Grandfather's Name</label>
                                            <input type="text" class="form-control"
                                                name="wife_family[grandfather][name]"
                                                value="{{ $wifeFamily['grandfather']->name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[grandfather][birth_date]"
                                                    value="{{ $wifeFamily['grandfather']->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy"
                                                    name="wife_family[grandfather][marriage_date]"
                                                    value="{{ $wifeFamily['grandfather']->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[grandfather][death_date]"
                                                    value="{{ $wifeFamily['grandfather']->death_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        {{-- Grandmother details --}}
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Grandmother's
                                                Name</label>
                                            <input type="text" class="form-control"
                                                name="wife_family[grandmother][name]"
                                                value="{{ $wifeFamily['grandmother']->name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[grandmother][birth_date]"
                                                    value="{{ $wifeFamily['grandmother']->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy"
                                                    name="wife_family[grandmother][marriage_date]"
                                                    value="{{ $wifeFamily['grandmother']->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_family[grandmother][death_date]"
                                                    value="{{ $wifeFamily['grandmother']->death_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        {{-- Great-Grandfather details --}}
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Great-Grandfather's
                                                Name</label>
                                            <input type="text" class="form-control" name="wife_ggf_name[]"
                                                value="{{ $wifeFamily['great-grandfather']->name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_ggf_dob[]"
                                                    value="{{ $wifeFamily['great-grandfather']->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_ggf_marriage_date[]"
                                                    value="{{ $wifeFamily['great-grandfather']->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_ggf_death_date[]"
                                                    value="{{ $wifeFamily['great-grandfather']->death_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                        {{-- Great-Grandmother details --}}
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Great-Grandmother's
                                                Name</label>
                                            <input type="text" class="form-control" name="wife_ggm_name[]"
                                                value="{{ $wifeFamily['great-grandmother']->name ?? '' }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Birth Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_ggm_dob[]"
                                                    value="{{ $wifeFamily['great-grandmother']->birth_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Marriage Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_ggm_marriage_date[]"
                                                    value="{{ $wifeFamily['great-grandmother']->marriage_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-2">
                                            <label for="validationDefault01" class="form-label">Death Date</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control basic-datepicker pe-5"
                                                    placeholder="dd-mm-yyyy" name="wife_ggm_death_date[]"
                                                    value="{{ $wifeFamily['great-grandmother']->death_date ?? '' }}">
                                                <i class="ri-calendar-2-line calendar-icon"></i>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Siblings -->
                                    @foreach ($data->siblings->where('belongs_to', 'wife') as $index => $sibling)
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label for="validationDefault01" class="form-label">Brother /
                                                    Sister</label>
                                                <select class="form-select" id="brother_sister_type"
                                                    name="wife_sibling_relation[]">
                                                    <option selected disabled>Select Type</option>
                                                    <option {{ $sibling->relation === 'brother' ? 'selected' : '' }}
                                                        value="brother">Brother</option>
                                                    <option {{ $sibling->relation === 'sister' ? 'selected' : '' }}
                                                        value="sister">Sister</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label for="validationDefault01" class="form-label">Brother/Sister
                                                    Name</label>
                                                <input type="text" class="form-control" id="validationDefault01"
                                                    name="wife_sibling_name[]" value="{{ $sibling->name ?? '' }}">
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label for="validationDefault01" class="form-label">Birth Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="wife_sibling_dob[]"
                                                        value="{{ $sibling->birth_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 mb-2">
                                                <label for="validationDefault01" class="form-label">Death Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="wife_sibling_death_date[]"
                                                        value="{{ $sibling->death_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    {{-- Dynamic row will be added here for brother sister details --}}

                                    <div id="broWifeSisContainer">
                                        <!-- Dynamic form rows will be added here -->
                                    </div>
                                    <!-- Buttons -->
                                    <div class="row justify-content-between">
                                        <div class="col-auto mb-2">
                                            <button id="addWifeBroSisRow" class="btn btn-primary">+ Add More</button>
                                        </div>
                                        <div class="col-auto mb-2">
                                            <button id="deleteWifeBroSisRow" class="btn btn-danger"
                                                style="display: none;"><i class="ri-delete-bin-line"></i>
                                                Delete</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <label for="notes" class="form-label">Ancestor History Notes</label>
                                            <textarea class="form-control" id="ancestor_notes" name="wife_ancestor_notes" rows="3">{{ $data->wife_ancestor_notes }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2 text-end">
                                        <button type="submit" name="save" value="panelsStayOpen-collapseFive"
                                            class="btn btn-primary" id="addLineage">Save</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Children Information --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseSeven">
                                    Children Information
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    @if ($data->children->count() == 0)
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label for="validationDefault01" class="form-label">Gender</label>
                                                <select class="form-select" id="child_gender" name="child_gender[]">
                                                    <option selected disabled>Select Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationDefault01" class="form-label">Children
                                                    Name</label>
                                                <input type="text" class="form-control" id="validationDefault01"
                                                    name="child_name[]" value="">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationDefault01" class="form-label">Birth Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="child_dob[]" value="">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- add brother's sister's --}}
                                    @foreach ($data->children as $index => $child)
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label for="validationDefault01" class="form-label">Gender</label>
                                                <select class="form-select" id="child_gender" name="child_gender[]">
                                                    <option selected disabled>Select Gender</option>
                                                    <option {{ $child->gender === 'male' ? 'selected' : '' }}
                                                        value="male">Male
                                                    </option>
                                                    <option {{ $child->gender === 'female' ? 'selected' : '' }}
                                                        value="female">
                                                        Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationDefault01" class="form-label">Children
                                                    Name</label>
                                                <input type="text" class="form-control" id="validationDefault01"
                                                    name="child_name[]" value="{{ $child->name ?? '' }}">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationDefault01" class="form-label">Birth Date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control basic-datepicker pe-5"
                                                        placeholder="dd-mm-yyyy" name="child_dob[]"
                                                        value="{{ $child->birth_date ?? '' }}">
                                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Dynamic row will be added here for brother sister details --}}

                                    <div id="childContainer">
                                        <!-- Dynamic form rows will be added here -->
                                    </div>
                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <div class="col-auto mb-2">
                                            <button id="addChildRow" class="btn btn-primary">+ Add More</button>
                                        </div>
                                        <div class="col-auto mb-2">
                                            <button id="deleteChildRow" class="btn btn-danger"
                                                style="display: none;"><i class="ri-delete-bin-line"></i>
                                                Delete</button>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2 text-end">
                                        <button type="submit" name="save" value="panelsStayOpen-collapseSeven"
                                            class="btn btn-primary" id="addLineage">Save</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseEight">
                                    Notes
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse show">
                                <div class="text-end me-4">
                                    <a href="{{ url('admin/leads/' . $data->id . '/attachment') }}"
                                        class="text-end view-all-attachment-text">View All Attachment</a>
                                </div>
                                <div class="accordion-body">


                                    {{-- Existing notes --}}
                                    @foreach ($data->leadNote as $key => $note)
                                        <div class="row note-row mb-3 border-bottom shadow-sm rounded"
                                            data-note-id="{{ $note->id }}">
                                            <div class="col-md-12 mt-2">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <label class="mb-1 form-label">
                                                        <img src="{{ asset(get_profile_image($note->user->profile_image, $note->user->name)) }}"
                                                            class="avatar avatar-sm rounded-circle me-2">
                                                        {{ $note->user->name ?? '' }}
                                                    </label>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="text-end me-2 form-label">{{ $note->created_at->format('D d F, g:i') }}</span>
                                                        @if ($note->added_by == auth()->id() || auth()->user()->hasRole('super-admin'))
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-primary edit-note-btn"
                                                                data-note-id="{{ $note->id }}">
                                                                <i class="ri-edit-line"></i> Edit
                                                            </button>
                                                            {{-- <button type="button" class="btn btn-sm btn-outline-danger delete-note-btn ms-1" data-note-id="{{ $note->id }}">
                                                <i class="ri-delete-bin-line"></i>
                                                </button> --}}
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- View Mode -->
                                                <div class="note-view-mode">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            {{-- <label class="form-label">Content</label> --}}
                                                            <textarea class="form-control" readonly style="min-height: 150px;">{!! $note->content !!}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Mode (Hidden by default) -->
                                                <div class="note-edit-mode" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label">Original Content</label>
                                                            <textarea class="form-control original-content-edit" style="min-height: 150px;">{{ $note->original_content ?? $note->content }}</textarea>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label">Translated Content</label>
                                                            <textarea class="form-control translated-content-edit" style="min-height: 150px;">{!! $note->content !!}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-success save-note-btn"
                                                                data-note-id="{{ $note->id }}">
                                                                <i class="ri-save-line"></i> Save
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-secondary cancel-edit-btn ms-2">
                                                                <i class="ri-close-line"></i> Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="added_by[]"
                                                    value="{{ $note->added_by }}">
                                            </div>
                                            <div class="row mt-2">
                                                {{-- <div class="col-md-6 mb-2">
                                                    <label class="form-label">Attachment</label>
                                                    <input type="file" class="form-control" name="attachment[{{ $key }}][]"
                                        multiple accept="image/*,audio/*,.pdf" max="10485760"
                                        onchange="validateFileSize(this)">
                                        <small class="text-muted">Allowed file types: Images, Audio files, PDF (Max 10MB
                                            total for all files)</small>
                                    </div> --}}
                                                <div class="col-xl-4 mt-2">
                                                    @if (!empty($note->attachments))
                                                        <div class="file-item d-flex align-items-center gap-2">
                                                            @foreach ($note->attachments as $attachment)
                                                                <div class="attachment-item">
                                                                    <a href="{{ asset($attachment['attachment']) }}"
                                                                        target="_blank" class="text-decoration-none">
                                                                        <i
                                                                            class="ri-{{ $attachment['type'] === 'image' ? 'image' : ($attachment['type'] === 'audio' ? 'file-music' : ($attachment['type'] === 'application' ? 'file-pdf' : 'file')) }}-line fs-1"></i>
                                                                    </a>
                                                                    <input type="hidden"
                                                                        name="existing_attachment[{{ $key }}][]"
                                                                        value="{{ $attachment['attachment'] }}">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Language Selection -->
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">From Language</label>
                                            <select class="form-control" id="fromLang" name="original_language">
                                                <option {{ $data->original_language === 'en' ? 'selected' : '' }}
                                                    value="en">
                                                    English</option>
                                                <option {{ $data->original_language === 'hi' ? 'selected' : '' }}
                                                    value="hi">
                                                    Hindi</option>
                                                <option {{ $data->original_language === 'gu' ? 'selected' : '' }}
                                                    value="gu">
                                                    Gujarati</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">To Language</label>
                                            <select class="form-control" id="toLang" name="translated_language">
                                                <option {{ $data->translated_language === 'hi' ? 'selected' : '' }}
                                                    value="hi">
                                                    Hindi</option>
                                                <option {{ $data->translated_language === 'gu' ? 'selected' : '' }}
                                                    value="gu">
                                                    Gujarati</option>
                                                <!-- <option {{ $data->translated_language === 'bn' ? 'selected' : '' }} value="bn">Bengali</option> -->
                                                <option {{ $data->translated_language === 'mr' ? 'selected' : '' }}
                                                    value="mr">
                                                    Marathi</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- New note form --}}
                                    <div class="row note-row mb-3" id="newNoteForm">
                                        <div class="col-md-12 mt-2">
                                            <div class="d-flex justify-content-between mb-1">
                                                <label class="mb-1 form-label">
                                                    <img src="{{ asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name)) }}"
                                                        class="avatar avatar-sm rounded-circle me-2">
                                                    {{ auth()->user()->name }}
                                                </label>
                                                <span class="text-end form-label">Current Date and Time</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Original Content</label>
                                                    <textarea class="form-control translation-input" data-output-id="new-note-translated" rows="4"
                                                        placeholder="Enter original content..."></textarea>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Translated Content</label>
                                                    <textarea class="form-control" id="new-note-translated" style="min-height: 100px;"
                                                        placeholder="Translated content will appear here..."></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3 mt-2">
                                                <div class="col-md-6 mb-2">
                                                    <label class="form-label">Attachment</label>
                                                    <input type="file" class="form-control" id="newNoteAttachments"
                                                        multiple accept="image/*,audio/*,.pdf" max="10485760"
                                                        onchange="validateFileSize(this)">
                                                    <small class="text-muted">Allowed file types: Images, Audio files, PDF
                                                        (Max
                                                        10MB total for all files)</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" id="saveNewNote" class="btn btn-primary">
                                                        <i class="ri-save-line"></i> Save Note
                                                    </button>
                                                    <button type="button" id="clearNewNote"
                                                        class="btn btn-secondary ms-2">
                                                        <i class="ri-refresh-line"></i> Clear
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    {{-- <div class="row justify-content-between">
                                        <div class="col-auto mb-2">
                                            <button id="addNoteRow" class="btn btn-primary">+ Add Note</button>
                                        </div>
                                        <div class="col-auto mb-2">
                                            <button id="deleteNoteRow" class="btn btn-danger" style="display: none;"><i class="ri-delete-bin-line"></i> Delete</button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ url('admin/leads') }}" type="button" id="notes"
                            class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="notes" class="btn btn-primary"> Save</button>
                    </div>
                </div><!-- end card -->
            </div>
        </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    {{-- Form Validation Script --}}
    <script>
        // Global validation functions
        function showError(field, message) {
            // Remove existing error message
            field.siblings('.error-message').remove();
            // field.addClass('is-invalid');
            console.log(field);
            // Add error message below the field
            const errorDiv = $('<div class="error-message text-danger small mt-1"></div>').text(message);
            if (field.hasClass('lead-edit-country')) {
                $('.country-error').html(errorDiv);
            } else if (field.hasClass('lead-edit-state')) {
                $('.state-error').html(errorDiv);
            } else if (field.hasClass('lead-edit-district')) {
                $('.district-error').html(errorDiv);
            }
            else if (field.hasClass('lead-edit-city')) {
                $('.city-error').html(errorDiv);
            } 
            else {
                field.after(errorDiv);
            }
        }

        function clearError(field) {
            field.removeClass('is-invalid');
            field.siblings('.error-message').remove();
        }

        $(document).ready(function() {

            // Function to validate email format
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Function to validate phone number
            function isValidPhone(phone) {
                return phone.length === 10 && /^\d+$/.test(phone);
            }

            // Function to validate date format
            function isValidDate(dateStr) {
                if (!dateStr) return true; // Allow empty dates
                const dateRegex = /^\d{2}-\d{2}-\d{4}$/;
                if (!dateRegex.test(dateStr)) return false;

                const parts = dateStr.split('-');
                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]);
                const year = parseInt(parts[2]);

                const date = new Date(year, month - 1, day);
                return date.getDate() === day && date.getMonth() === month - 1 && date.getFullYear() === year;
            }

            // Form validation function
            function validateForm() {
                let isValid = true;

                // Clear all previous errors
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Required fields validation
                const requiredFields = [{
                        field: $('input[name="first_name"]'),
                        message: 'First name is required'
                    },
                    {
                        field: $('input[name="last_name"]'),
                        message: 'Last name is required'
                    },
                    {
                        field: $('select[name="country"]'),
                        message: 'Country is required'
                    },
                    {
                        field: $('select[name="state"]'),
                        message: 'State is required'
                    },
                    {
                        field: $('select[name="district"]'),
                        message: 'District is required'
                    },
                         {
                        field: $('select[name="city"]'),
                        message: 'City is required'
                    }
                    
                ];

                requiredFields.forEach(function(item) {
                    if (!item.field.val() || item.field.val() === 'Select Country' ||
                        item.field.val() === 'Select State' || item.field.val() === 'Select District' ||
                        item.field.val() === 'Select City') {
                        showError(item.field, item.message);
                        isValid = false;
                    }
                });

                // Phone number validation
                // const phoneField = $('input[name="phone"]');
                // if (phoneField.val()) {
                //     if (!isValidPhone(phoneField.val())) {
                //         showError(phoneField, 'Phone number must be 10 digits');
                //         isValid = false;
                //     }
                // } else {
                //     showError(phoneField, 'Phone number is required');
                //     isValid = false;
                // }

                // Email validation
                const emailField = $('input[name="email"]');
                if (emailField.val() && !isValidEmail(emailField.val())) {
                    showError(emailField, 'Please enter a valid email address');
                    isValid = false;
                }

                return isValid;
            }

            // Form submit handler
            $('form').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = $('.is-invalid').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                    return false;
                }
            });

            // Real-time validation on input change
            $('input, select').on('input change', function() {
                clearError($(this));
            });

        });
    </script>

    <!-- AJAX Notes Script -->
    <script>
        $(document).ready(function() {
            const fromLangEl = document.getElementById('fromLang');
            const toLangEl = document.getElementById('toLang');
            const leadId = {{ $data->id }};

            // CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Translate plain text
            function translateText(text, fromLang, toLang, outputElement) {
                if (!text.trim()) {
                    if (outputElement.tagName === 'TEXTAREA') {
                        outputElement.value = '';
                    } else {
                        outputElement.innerHTML = '';
                    }
                    return;
                }

                console.log(`Translating: "${text}" from ${fromLang} to ${toLang}`);

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
                        console.log('Translation response:', data);
                        if (data?.data?.translations?.[0]) {
                            const translatedText = data.data.translations[0].translatedText;
                            if (outputElement.tagName === 'TEXTAREA') {
                                outputElement.value = translatedText;
                            } else {
                                outputElement.innerHTML = translatedText;
                            }
                            console.log(`Translation successful: "${translatedText}"`);
                        } else {
                            const errorMsg = 'Translation failed.';
                            if (outputElement.tagName === 'TEXTAREA') {
                                outputElement.value = errorMsg;
                            } else {
                                outputElement.innerHTML = errorMsg;
                            }
                            console.log('Translation failed - no data');
                        }
                    })
                    .catch(err => {
                        console.error('Translation error:', err);
                        const errorMsg = 'Error during translation.';
                        if (outputElement.tagName === 'TEXTAREA') {
                            outputElement.value = errorMsg;
                        } else {
                            outputElement.innerHTML = errorMsg;
                        }
                    });
            }

            // Trigger translation
            function handleTranslationInput(e) {
                const textarea = e.target;
                const outputId = textarea.getAttribute('data-output-id');
                const output = document.getElementById(outputId);
                const fromLang = fromLangEl.value;
                const toLang = toLangEl.value;

                console.log(`Translation input triggered:`, {
                    textarea: textarea,
                    outputId: outputId,
                    output: output,
                    fromLang: fromLang,
                    toLang: toLang,
                    text: textarea.value
                });

                if (!output) {
                    console.error(`Output element with id "${outputId}" not found!`);
                    return;
                }

                translateText(textarea.value, fromLang, toLang, output);
            }

            // Attach translation event listener to all current translation textareas
            function attachTranslationListeners() {
                const inputs = document.querySelectorAll('.translation-input');
                inputs.forEach(input => {
                    // Remove existing listeners to prevent duplicates
                    input.removeEventListener('input', handleTranslationInput);
                    input.removeEventListener('keyup', handleTranslationInput);

                    // Add new listeners
                    input.addEventListener('input', handleTranslationInput);
                    input.addEventListener('keyup', handleTranslationInput);
                });

                // Debug: Log how many translation inputs were found
                console.log(`Attached translation listeners to ${inputs.length} elements`);
            }

            // Save new note via AJAX
            $('#saveNewNote').click(function() {
                const originalContent = $('.translation-input[data-output-id="new-note-translated"]').val();
                const translatedContent = $('#new-note-translated').val();
                const attachments = $('#newNoteAttachments')[0].files;

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
                    url: `/admin/leads/${leadId}/notes`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Add the new note to the page
                            addNoteToPage(response.note);

                            // Clear the form
                            clearNewNoteForm();

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

            // Clear new note form
            $('#clearNewNote').click(function() {
                clearNewNoteForm();
            });

            function clearNewNoteForm() {
                $('.translation-input[data-output-id="new-note-translated"]').val('');
                $('#new-note-translated').val('');
                $('#newNoteAttachments').val('');
            }

            // Add note to page
            function addNoteToPage(note) {
                const currentTime = new Date().toLocaleString('en-US', {
                    weekday: 'short',
                    day: 'numeric',
                    month: 'long',
                    hour: 'numeric',
                    minute: 'numeric'
                });

                const noteHtml = `
                    <div class="row note-row mb-3 border-bottom shadow-sm rounded" data-note-id="${note.id}">
                        <div class="col-md-12 mt-2">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="mb-1">
                                    <img src="${note.user_image}" class="avatar avatar-sm rounded-circle me-2">
                                    ${note.user_name}
                                </label>
                                <div class="d-flex align-items-center">
                                    <span class="text-end me-2">${note.created_at}</span>
                                    <button type="button" class="btn btn-sm btn-outline-primary edit-note-btn" data-note-id="${note.id}">
                                        <i class="ri-edit-line"></i> Edit
                                    </button>
                                </div>
                            </div>
                            
                            <!-- View Mode -->
                            <div class="note-view-mode">
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea class="form-control" readonly style="min-height: 150px;">${note.content}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Mode (Hidden by default) -->
                            <div class="note-edit-mode" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Original Content</strong></label>
                                        <textarea class="form-control original-content-edit translation-input" data-output-id="edit-translated-${note.id}" style="min-height: 150px;">${note.original_content}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Translated Content</strong></label>
                                        <textarea class="form-control translated-content-edit" id="edit-translated-${note.id}" style="min-height: 150px;">${note.content}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success save-note-btn" data-note-id="${note.id}">
                                            <i class="ri-save-line"></i> Save
                                        </button>
                                        <button type="button" class="btn btn-secondary cancel-edit-btn ms-2">
                                            <i class="ri-close-line"></i> Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Attachment Section -->
                            <div class="row mt-2">
                                <div class="col-xl-4 mt-2">
                                    ${note.attachments && note.attachments.length > 0 ? `
                                            <div class="file-item d-flex align-items-center gap-2">
                                                ${note.attachments.map(attachment => `
                                                <div class="attachment-item">
                                                    <a href="${attachment.attachment}" target="_blank" class="text-decoration-none">
                                                        <i class="ri-${attachment.icon}-line fs-1"></i>
                                                    </a>
                                                    <input type="hidden" name="existing_attachment[new][]" value="${attachment.attachment}">
                                                </div>
                                            `).join('')}
                                            </div>
                                        ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Insert the new note after the last existing note, before the language selection
                const existingNotes = $('.note-row:not(#newNoteForm)');
                if (existingNotes.length > 0) {
                    // Insert after the last existing note
                    existingNotes.last().after(noteHtml);
                } else {
                    // If no existing notes, insert before the language selection
                    $('.row.mb-4').before(noteHtml);
                }

                // Reattach event listeners
                attachNoteEventListeners();

                // Reattach translation listeners to include the new note
                attachTranslationListeners();

                // Force a small delay to ensure DOM is ready, then trigger translation for the new note
                setTimeout(() => {
                    const newNoteOriginalTextarea = $(`[data-note-id="${note.id}"] .original-content-edit`);
                    if (newNoteOriginalTextarea.length > 0) {
                        newNoteOriginalTextarea.trigger('input');
                    }
                }, 200);
            }

            // Edit note functionality
            $(document).on('click', '.edit-note-btn', function() {
                const noteRow = $(this).closest('.note-row');
                const noteId = noteRow.data('note-id');

                noteRow.find('.note-view-mode').hide();
                noteRow.find('.note-edit-mode').show();

                // Add translation functionality to edit mode textareas
                const originalTextarea = noteRow.find('.original-content-edit');
                const translatedTextarea = noteRow.find('.translated-content-edit');

                // Check if translation classes are already added (for newly added notes)
                if (!originalTextarea.hasClass('translation-input')) {
                    // Add translation input class and data attribute
                    originalTextarea.addClass('translation-input').attr('data-output-id',
                        'edit-translated-' +
                        noteId);
                    translatedTextarea.attr('id', 'edit-translated-' + noteId);
                }

                // Reattach translation listeners
                attachTranslationListeners();

                // Trigger translation for the current content
                setTimeout(() => {
                    originalTextarea.trigger('input');
                    console.log(`Edit mode activated for note ${noteId}, translation triggered`);
                }, 100);
            });

            // Cancel edit
            $(document).on('click', '.cancel-edit-btn', function() {
                const noteRow = $(this).closest('.note-row');
                noteRow.find('.note-edit-mode').hide();
                noteRow.find('.note-view-mode').show();

                // Remove translation classes when canceling (only for existing notes, not newly added ones)
                const originalTextarea = noteRow.find('.original-content-edit');
                const translatedTextarea = noteRow.find('.translated-content-edit');

                // Only remove classes if they were added dynamically (for existing notes)
                if (originalTextarea.hasClass('translation-input') && originalTextarea.attr(
                        'data-output-id')
                    .startsWith('edit-translated-')) {
                    originalTextarea.removeClass('translation-input').removeAttr('data-output-id');
                    translatedTextarea.removeAttr('id');
                }
            });

            // Save edited note
            $(document).on('click', '.save-note-btn', function() {
                const noteId = $(this).data('note-id');
                const noteRow = $(this).closest('.note-row');
                const originalContent = noteRow.find('.original-content-edit').val();
                const translatedContent = noteRow.find('.translated-content-edit').val();

                if (!originalContent.trim() || !translatedContent.trim()) {
                    showAlert('Please fill in both original and translated content', 'error');
                    return;
                }

                $.ajax({
                    url: `/admin/leads/notes/${noteId}`,
                    type: 'PUT',
                    data: {
                        original_content: originalContent,
                        translated_content: translatedContent
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the view mode content (only the translated content is shown)
                            noteRow.find('.note-view-mode textarea').val(response.note.content);

                            // Switch back to view mode
                            noteRow.find('.note-edit-mode').hide();
                            noteRow.find('.note-view-mode').show();

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

            // Delete note
            $(document).on('click', '.delete-note-btn', function() {
                const noteId = $(this).data('note-id');

                if (confirm('Are you sure you want to delete this note?')) {
                    $.ajax({
                        url: `/admin/leads/notes/${noteId}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                $(`.note-row[data-note-id="${noteId}"]`).remove();
                                showAlert('Note deleted successfully!', 'success');
                            } else {
                                showAlert(response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            showAlert(response?.message || 'Error deleting note', 'error');
                        }
                    });
                }
            });

            // Show alert function
            function showAlert(message, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                // Insert alert at the top of the notes section
                $('#panelsStayOpen-collapseEight .accordion-body').prepend(alertHtml);

                // Auto remove after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut();
                }, 5000);
            }

            // Attach event listeners to existing notes
            function attachNoteEventListeners() {
                // Event listeners are already attached via $(document).on()
            }

            // Language dropdown change triggers re-translation
            [fromLangEl, toLangEl].forEach(select => {
                select.addEventListener('change', () => {
                    console.log('Language changed, re-translating all inputs...');
                    document.querySelectorAll('.translation-input').forEach(input => {
                        input.dispatchEvent(new Event('input'));
                    });
                });
            });


            // Manual test function (can be called from console)
            window.testTranslationAPI = function() {
                const testText = 'Hello world';
                const testOutput = document.getElementById('new-note-translated');
                if (testOutput) {
                    console.log('Testing translation API manually...');
                    translateText(testText, 'en', 'hi', testOutput);
                } else {
                    console.error('Test output element not found');
                }
            };

            // Test API key function
            window.testAPIKey = function() {
                console.log('Testing API key...');
                const apiKey = '{{ env('
                        TRANSLATION_API ') }}';
                console.log('API Key length:', apiKey ? apiKey.length : 0);
                console.log('API Key starts with:', apiKey ? apiKey.substring(0, 10) + '...' : 'Not set');

                // Test a simple fetch
                fetch('https://translation.googleapis.com/language/translate/v2?key=' + apiKey, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            q: 'Hello',
                            source: 'en',
                            target: 'hi',
                            format: 'text',
                        }),
                    })
                    .then(res => {
                        console.log('Response status:', res.status);
                        return res.json();
                    })
                    .then(data => {
                        console.log('API Response:', data);
                    })
                    .catch(err => {
                        console.error('API Error:', err);
                    });
            };

            // Initialize
            attachTranslationListeners();
            attachNoteEventListeners();

            // Test translation on page load
            // setTimeout(() => {
            //     testTranslation();
            // }, 1000);
        });
    </script>

    {{-- add row dynamically for great-grandfather/mother details --}}
    <script>
        $(document).ready(function() {
            // Initialize counters for each section
            let count = 1;
            let broSisCount = 1;
            let wifeBroSisCount = 1;
            let childCount = 1;
            let noteCount = 1;

            // Function to show/hide delete button
            function toggleDeleteButton(buttonId, count) {
                if (count > 1) {
                    $(buttonId).show();
                } else {
                    $(buttonId).hide();
                }
            }

            // Great-grandfather/mother section
            $('#addMore').click(function(e) {
                e.preventDefault();
                count++;
                toggleDeleteButton('#delete', count);

                let columnGroup = `
                <div class="row dynamic-group mb-3">
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Great-Grandfather's Name (${count})</label>
                        <input type="text" class="form-control" id="validationDefault01"  name="ggf_name[]" >
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Birth Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_dob[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Marriage Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_marriage_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label for="validationDefault01" class="form-label">Death Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker"  name="ggf_death_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Great-Grandmother's Name (${count})</label>
                        <input type="text" class="form-control" name="ggm_name[]" >
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Birth Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_dob[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Marriage Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_marriage_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        <label class="form-label">Death Date (${count})</label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" name="ggm_death_date[]" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                    </div>
                </div>`;

                $('#dynamicContainer').append(columnGroup);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });

            $('#delete').click(function(e) {
                e.preventDefault();
                if (count > 1) {
                    $('#dynamicContainer .dynamic-group').last().remove();
                    count--;
                    toggleDeleteButton('#delete', count);
                }
            });

            // Lead brother/sister section
            $('#addBroSisRow').click(function(e) {
                e.preventDefault();
                broSisCount++;
                toggleDeleteButton('#deleteBroSisRow', broSisCount);

                let row = `
                    <div class="row dynamic-brosis-group mb-3">
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Brother / Sister (${broSisCount})</label>
                            <select class="form-select" name="sibling_relation[]" >
                                <option selected disabled>Select Type</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Sister</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Brother/Sister Name (${broSisCount})</label>
                            <input type="text" class="form-control" name="sibling_name[]" placeholder="Enter Name" >
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Birth Date (${broSisCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="sibling_dob[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Death Date (${broSisCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="sibling_death_date[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                    </div>
                `;

                $('#broSisContainer').append(row);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });

            $('#deleteBroSisRow').click(function(e) {
                e.preventDefault();
                if (broSisCount > 1) {
                    $('#broSisContainer .dynamic-brosis-group').last().remove();
                    broSisCount--;
                    toggleDeleteButton('#deleteBroSisRow', broSisCount);
                }
            });

            // Wife brother/sister section
            $('#addWifeBroSisRow').click(function(e) {
                e.preventDefault();
                wifeBroSisCount++;
                toggleDeleteButton('#deleteWifeBroSisRow', wifeBroSisCount);

                let row = `
                    <div class="row dynamic-brosis-group mb-3">
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Brother / Sister (${wifeBroSisCount})</label>
                            <select class="form-select" name="wife_sibling_relation[]">
                                <option selected disabled>Select Type</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Sister</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Brother/Sister Name (${wifeBroSisCount})</label>
                            <input type="text" class="form-control" name="wife_sibling_name[]" placeholder="Enter Name">
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Birth Date (${wifeBroSisCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="wife_sibling_dob[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label class="form-label">Death Date (${wifeBroSisCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="wife_sibling_death_date[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                    </div>
                `;

                $('#broWifeSisContainer').append(row);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });

            $('#deleteWifeBroSisRow').click(function(e) {
                e.preventDefault();
                if (wifeBroSisCount > 1) {
                    $('#broWifeSisContainer .dynamic-brosis-group').last().remove();
                    wifeBroSisCount--;
                    toggleDeleteButton('#deleteWifeBroSisRow', wifeBroSisCount);
                }
            });

            // Children section
            $('#addChildRow').click(function(e) {
                e.preventDefault();
                childCount++;
                toggleDeleteButton('#deleteChildRow', childCount);

                let row = `
                    <div class="row dynamic-child-group mb-3">
                        <div class="col-md-4 mb-2">
                            <label for="validationDefault01" class="form-label">Gender (${childCount})</label>
                            <select class="form-select" name="child_gender[]">
                                <option selected disabled>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="validationDefault01" class="form-label">Children Name (${childCount})</label>
                            <input type="text" class="form-control" name="child_name[]">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="validationDefault01" class="form-label">Birth Date (${childCount})</label>
                            <div class="position-relative">
                                <input type="text" class="form-control basic-datepicker" name="child_dob[]" placeholder="dd-mm-yyyy">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>
                    </div>
                `;

                $('#childContainer').append(row);
                flatpickr(".basic-datepicker", {
                    altInput: true,
                    altFormat: "d-m-Y",
                    dateFormat: "Y-m-d"
                });
            });

            $('#deleteChildRow').click(function(e) {
                e.preventDefault();
                if (childCount > 1) {
                    $('#childContainer .dynamic-child-group').last().remove();
                    childCount--;
                    toggleDeleteButton('#deleteChildRow', childCount);
                }
            });

            // Initialize delete buttons state
            toggleDeleteButton('#delete', count);
            toggleDeleteButton('#deleteBroSisRow', broSisCount);
            toggleDeleteButton('#deleteWifeBroSisRow', wifeBroSisCount);
            toggleDeleteButton('#deleteChildRow', childCount);
        });
    </script>

    {{-- Country state and city data --}}

    <script>
        $(document).ready(function() {
            function setupLocationHandlers(prefix = '') {
                // Select elements by prefix
                const countrySelect = document.querySelector(`#country${prefix}`);
                const stateSelect = document.querySelector(`#state${prefix}`);
                const citySelect = document.querySelector(`#city${prefix}`);
                const districtSelect = document.querySelector(`#district${prefix}`);
                const talukaSelect = document.querySelector(`#taluka${prefix}`);
                const villageSelect = document.querySelector(`#village${prefix}`);

                // Use existing Choices instance or initialize if missing
                const countryChoices = countrySelect.choicesInstance;
                const stateChoices = stateSelect ? stateSelect.choicesInstance : null;
                const cityChoices = citySelect ? citySelect.choicesInstance : null;
                const districtChoices = districtSelect ? districtSelect.choicesInstance : null;
                const talukaChoices = talukaSelect ? talukaSelect.choicesInstance : null;
                const villageChoices = villageSelect ? villageSelect.choicesInstance : null;

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

                // Country change event
                $(`#country${prefix}`).on('change', function() {
                    const countryId = this.value;
                    updateChoices(stateChoices, [], 'Loading states...');
                    updateChoices(cityChoices, [], 'Select City');
                    updateChoices(districtChoices, [], 'Select District');
                    updateChoices(talukaChoices, [], 'Select Taluka');
                    updateChoices(villageChoices, [], 'Select Village');

                    $.getJSON(`/admin/settings/get-state/${countryId}`).done(function(states) {
                        updateChoices(stateChoices, states, 'Select State');
                    }).fail(function() {
                        updateChoices(stateChoices, [], 'Select State');
                    });
                });

                // State change event
                $(`#state${prefix}`).on('change', function() {
                    const stateId = this.value;
                    updateChoices(cityChoices, [], 'Loading cities...');
                    updateChoices(districtChoices, [], 'Loading districts...');
                    updateChoices(talukaChoices, [], 'Select Taluka');
                    updateChoices(villageChoices, [], 'Select Village');

                    $.getJSON(`/admin/settings/get-cities/${stateId}`).done(function(cities) {
                        updateChoices(cityChoices, cities, 'Select City');
                    }).fail(function() {
                        updateChoices(cityChoices, [], 'Select City');
                    });

                    $.getJSON(`/admin/settings/get-district/${stateId}`).done(function(districts) {
                        updateChoices(districtChoices, districts, 'Select District');
                    }).fail(function() {
                        updateChoices(districtChoices, [], 'Select District');
                    });
                });

                // City change event to load talukas
                if (citySelect && cityChoices) {
                    $(`#city${prefix}`).on('change', function() {
                        const cityId = this.value;
                        updateChoices(talukaChoices, [], 'Loading talukas...');
                        updateChoices(villageChoices, [], 'Select Village');

                        if (cityId) {
                            $.getJSON(`/admin/settings/get-talukas/${cityId}`).done(function(talukas) {
                                updateChoices(talukaChoices, talukas, 'Select Taluka');
                            }).fail(function() {
                                updateChoices(talukaChoices, [], 'Select Taluka');
                            });
                        }
                    });
                }

                // Taluka change event to load villages
                if (talukaSelect && talukaChoices) {
                    $(`#taluka${prefix}`).on('change', function() {
                        const talukaId = this.value;
                        updateChoices(villageChoices, [], 'Loading villages...');

                        if (talukaId) {
                            $.getJSON(`/admin/settings/get-villages/${talukaId}`).done(function(villages) {
                                updateChoices(villageChoices, villages, 'Select Village');
                            }).fail(function() {
                                updateChoices(villageChoices, [], 'Select Village');
                            });
                        }
                    });
                }
            }

            // Initialize for both sets of dropdowns
            setupLocationHandlers(''); // For #country, #state, #city, #district, #taluka, #village
            setupLocationHandlers('1'); // For #country1, #state1, #city1, #district1, #taluka1, #village1
        });
    </script>

    {{-- Open accordion on page reload --}}
    <script>
        $(document).ready(function() {
            // Step 1: On button click, store the accordion ID in localStorage
            $('button[type="submit"][name="save"]').on('click', function() {
                const targetId = $(this).val();
                localStorage.setItem('openAccordion', targetId);
            });

            // Step 2: After page reload, open the stored accordion
            const openId = localStorage.getItem('openAccordion');
            if (openId) {
                const $target = $('#' + openId);
                if ($target.length) {
                    // Remove 'show' from all others
                    $('.accordion-collapse').removeClass('show');

                    // Add 'show' to stored target
                    $target.addClass('show');
                    $('#panelsStayOpen-collapseOne').addClass('show');
                    $('#panelsStayOpen-collapseEight').addClass('show');

                    // Optional: Scroll to the panel
                    $('html, body').animate({
                        scrollTop: $target.offset().top - 100
                    }, 500);
                }

                // Clear localStorage so it doesn't persist forever
                localStorage.removeItem('openAccordion');
            }
        });
    </script>

    <script>
        $('.lead-edit-country').on('change', function() {
            const countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: `/admin/settings/get-phone-code/${countryId}`,
                    type: 'GET',
                    success: function(response) {
                        $('#phonecode').text(response.phonecode);
                        $('#alternate_phonecode').text(response.phonecode);
                        $('input[name="phonecode"]').val(response.phonecode);
                    }
                });
            } else {
                $('#phonecode').text('');
            }
        });

        // Handle wife country change for phonecode
        $('#country1').on('change', function() {
            const countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: `/admin/settings/get-phone-code/${countryId}`,
                    type: 'GET',
                    success: function(response) {
                        $('#wife_phonecode').text(response.phonecode);
                        $('input[name="wife_phonecode"]').val(response.phonecode);
                    }
                });
            } else {
                $('#wife_phonecode').text('');
            }
        });
    </script>

@endsection
