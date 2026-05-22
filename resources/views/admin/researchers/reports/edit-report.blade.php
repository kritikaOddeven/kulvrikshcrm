@extends('admin.layouts.app')
@section('pagetitle', 'Add Researcher Report | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Add Research Reports</h4>
            {{-- <p>Agents/View All Agents</p> --}}
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashborad</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('admin/research-reports') }}">View All Research Reports</a></li>
                <li class="breadcrumb-item active">Add Research Reports</li>
            </ol>
        </div>
    </div>
    <x-alert />

    <div class="row">
        <div class="col-xl-12">
            <form action="{{ url('admin/research-reports/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 ms-auto mb-2">
                                <select class="form-control" id="toLang" name="translated_language">
                                    <option value="en" {{ $report->translated_language == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="hi" {{ $report->translated_language == 'hi' ? 'selected' : '' }}>Hindi</option>
                                    <option value="gu" {{ $report->translated_language == 'gu' ? 'selected' : '' }}>Gujarati</option>
                                    <option value="mr" {{ $report->translated_language == 'mr' ? 'selected' : '' }}>Marathi</option>
                                    
                                </select>
                            </div>

                            <div class="col-md-6 text-end">
                                <button class="btn btn-primary">Apply</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <input type="hidden" name="client_id" value="{{ request()->id }}">
                        <div class="mb-2">
                            <label for="top_tagline" class="form-label">Top Tagline (तिथि )</label>
                            <textarea name="top_tagline" class="form-control" maxlength="350" placeholder="Description">{{ $report->top_tagline ?? '' }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" class="form-control" placeholder="Enter Name" value="{{ $report->name ?? '' }} {{ $report->lead->first_name ?? '' }} {{ $report->lead->middle_name ?? '' }} {{ $report->lead->last_name ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="lineage" class="form-label">Lineage</label>
                                <input name="lineage" class="form-control" placeholder="Enter Lineage" value="{{ $lineage->lineage ?? $report->lineage }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="caste" class="form-label">Caste</label>
                                <input name="caste" class="form-control" placeholder="Enter Caste" value="{{$report->caste ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="subspecies" class="form-label">SubCaste</label>
                                <input name="subspecies" class="form-control" placeholder="Enter Subspecies" value="{{ $report->subspecies ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="surname" class="form-label">Surname</label>
                                <input name="surname" class="form-control" placeholder="Enter Surname" value="{{ $lineage->surname ?? $report->surname }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="credit" class="form-label">Branch</label>
                                <input name="credit" class="form-control" placeholder="Enter Credit" value="{{ $report->credit ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="gotra" class="form-label">Gotra</label>
                                <input name="gotra" class="form-control" placeholder="Enter Gotra" value="{{ $lineage->gotra ?? $report->gotra }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="pravar" class="form-label">Pravar</label>
                                <input name="pravar" class="form-control" placeholder="Enter Pravar" value="{{ $report->pravar ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="vedas" class="form-label">Vedas</label>
                                <input name="vedas" class="form-control" placeholder="Enter Vedas" value="{{ $report->vedas ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="upaveda" class="form-label">Upaveda</label>
                                <input name="upaveda" class="form-control" placeholder="Enter Upaveda" value="{{ $report->upaveda ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="branch" class="form-label">Shakha</label>
                                <input name="branch" class="form-control" placeholder="Enter Branch" value="{{ $report->branch ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="peak" class="form-label">Sikha</label>
                                <input name="peak" class="form-control" placeholder="Enter Peak" value="{{ $report->peak ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="formula" class="form-label">Sutra</label>
                                <input name="formula" class="form-control" placeholder="Enter Formula" value="{{ $report->formula ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="gotra_devi" class="form-label">Gotra Devi</label>
                                <input name="gotra_devi" class="form-control" placeholder="Enter Gotra Devi" value="{{ $report->gotra_devi ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="ishta_devi" class="form-label">Ishta Devi</label>
                                <input name="ishta_devi" class="form-control" placeholder="Enter Ishta Devi" value="{{ $report->ishta_devi ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="ishtadev" class="form-label">Ishtadev</label>
                                <input name="ishtadev" class="form-control" placeholder="Enter Ishtadev" value="{{ $report->ishtadev ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="kuldevi" class="form-label">Kuldevi</label>
                                <input name="kuldevi" class="form-control" placeholder="Enter Kuldevi" value="{{ $lineage->kuldevi ?? $report->kuldevi }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="kuldevata" class="form-label">Kuldevata</label>
                                <input name="kuldevata" class="form-control" placeholder="Enter Kuldevata" value="{{ $lineage->kuldevta ?? $report->kuldevata }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="supportive_mother" class="form-label">Sahayak Dev</label>
                                <input name="supportive_mother" class="form-control" placeholder="Enter Supportive Mother" value="{{ $report->supportive_mother ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="river" class="form-label">River</label>
                                <input name="river" class="form-control" placeholder="Enter River" value="{{ $report->river ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="ancestor_shrine" class="form-label">Ancestor Shrine</label>
                                <input name="ancestor_shrine" class="form-control" placeholder="Enter Ancestor Shrine" value="{{ $report->ancestor_shrine ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="tirth_purohit" class="form-label">Tirth Purohit</label>
                                <input name="tirth_purohit" class="form-control" placeholder="Enter Tirth Purohit" value="{{ $report->tirth_purohit ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="original_location" class="form-label">Original Location</label>
                                <input name="original_location" class="form-control" placeholder="Enter Original Location" value="{{ $report->original_location ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="kuldevi_dash" class="form-label">Kuldevi Dosh</label>
                                <input name="kuldevi_dash" class="form-control" placeholder="Enter Kuldevi Dosh" value="{{ $report->kuldevi_dash ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="patriarchy" class="form-label">Pitru Dosh</label>
                                <input name="patriarchy" class="form-control" placeholder="Enter Patriarchy" value="{{ $report->patriarchy ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="image" class="form-label">Image Upload</label>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kul_tagline" class="form-label">Kul Tag Line</label>
                            <textarea name="kul_tagline" class="form-control" placeholder="Description" maxlength="100">{{ $report->kul_tagline ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title (कुलदेवी  नैवेध)</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title" maxlength="100" value="{{ $report->title ?? '' }}">
                        </div>

                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="Description">{{ $report->description ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="history_title" class="form-label">History Title</label>
                            <input type="text" name="history_title" class="form-control" placeholder="Enter History Title" maxlength="100" value="{{ $report->history_title ?? '' }}">
                        </div>

                        <div class="mb-2">
                            <label for="history_description" class="form-label">History Description</label>
                            <textarea name="history_description" class="form-control" placeholder="History Description">{{ $report->history_description ?? '' }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('admin/research-reports/view/' . request()->id) }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
@endsection
