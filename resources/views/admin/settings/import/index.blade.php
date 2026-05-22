@extends('admin.layouts.app')
@section('pagetitle', 'Import/Export Data | Lead Management')
@section('admin-content')

<div class="py-3">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto mb-3 mb-md-0">
            <h4 class="page-title">Import/Export Data</h4>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-check-line me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('import_errors'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="ri-alert-line me-2"></i>Import completed with some errors:
        <ul class="mb-0 mt-2">
            @foreach(session('import_errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Data Import/Export</h5>
                
                <!-- Instructions Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="ri-information-line me-2"></i>Important Instructions
                            </h6>
                            <ul class="mb-0">
                                <li>Always download and use the provided CSV templates for proper formatting</li>
                                <li>Ensure all foreign key IDs (country_id, state_id, city_id, taluka_id) are valid and exist in the database</li>
                                <li>Use the export functions to get reference data with proper IDs</li>
                                <li>CSV files should have headers in the first row</li>
                                <li>Maximum file size allowed is 10MB</li>
                                <li>Duplicate entries will be updated, not created</li>
                                <li>Import process will validate all data before inserting</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Upload Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-4">
                            <h6 class="text-primary mb-3">
                                <i class="ri-upload-cloud-line me-2"></i>Upload CSV File
                            </h6>
                            <form action="{{ route('admin.settings.import.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Data Type</label>
                                            <select class="form-select" id="type" name="type" required>
                                                <option value="">Select data type to import</option>
                                                <option value="countries">Countries</option>
                                                <option value="states">States</option>
                                                <option value="cities">Cities</option>
                                                <option value="districts">Districts</option>
                                                <option value="talukas">Talukas</option>
                                                <option value="villages">Villages</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="file" class="form-label">CSV File</label>
                                            <input type="file" class="form-control" id="file" name="file" accept=".csv,.txt" required>
                                            <div class="form-text">Only CSV files are allowed. Maximum file size: 10MB</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-upload-line me-1"></i>Upload CSV
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Common Export Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-4 bg-success bg-opacity-10">
                            <h6 class="text-success mb-3">
                                <i class="ri-download-cloud-line me-2"></i>Export Data with Filters
                            </h6>
                            <form action="{{ route('admin.settings.import.export.data') }}" method="POST" id="exportForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="export_type" class="form-label">Data Type <span class="text-danger">*</span></label>
                                            <select class="form-select" id="export_type" name="type" required>
                                                <option value="">Select data type</option>
                                                <option value="countries">Countries</option>
                                                <option value="states">States</option>
                                                <option value="cities">Cities</option>
                                                <option value="districts">Districts</option>
                                                <option value="talukas">Talukas</option>
                                                <option value="villages">Villages</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="export_country_id" class="form-label">Filter by Country</label>
                                            <select class="form-select" id="export_country_id" name="country_id">
                                                <option value="">All Countries</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="stateFilterDiv" style="display: none;">
                                        <div class="mb-3">
                                            <label for="export_state_id" class="form-label">Filter by State</label>
                                            <select class="form-select" id="export_state_id" name="state_id">
                                                <option value="">All States</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="cityFilterDiv" style="display: none;">
                                        <div class="mb-3">
                                            <label for="export_city_id" class="form-label">Filter by City</label>
                                            <select class="form-select" id="export_city_id" name="city_id">
                                                <option value="">All Cities</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="talukaFilterDiv" style="display: none;">
                                        <div class="mb-3">
                                            <label for="export_taluka_id" class="form-label">Filter by Taluka</label>
                                            <select class="form-select" id="export_taluka_id" name="taluka_id">
                                                <option value="">All Talukas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ri-download-line me-1"></i>Export Filtered Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Countries Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-primary mb-3">
                                <i class="ri-global-line me-2"></i>Countries
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 1: Download Template</h6>
                                    <p class="text-muted small mb-3">Download the CSV template and fill it with your data.</p>
                                    <a href="{{ route('admin.settings.import.template', 'countries') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-download-line me-1"></i>Download Template
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 2: Export Existing Data</h6>
                                    <p class="text-muted small mb-3">Use the filtered export section above to export countries data for reference.</p>
                                    <div class="alert alert-info alert-sm mb-0">
                                        <small><i class="ri-information-line me-1"></i>Use the "Export Data with Filters" section above for better export options</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- States Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-primary mb-3">
                                <i class="ri-map-pin-line me-2"></i>States
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 1: Download Template</h6>
                                    <p class="text-muted small mb-3">Download the CSV template and fill it with your data. Country ID should be numerical.</p>
                                    <a href="{{ route('admin.settings.import.template', 'states') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-download-line me-1"></i>Download Template
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 2: Export Reference Data</h6>
                                    <p class="text-muted small mb-3">Use the filtered export section above to export countries and states data for reference.</p>
                                    <div class="alert alert-info alert-sm mb-0">
                                        <small><i class="ri-information-line me-1"></i>Use the "Export Data with Filters" section above for better export options</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cities Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-primary mb-3">
                                <i class="ri-building-line me-2"></i>Cities
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 1: Download Template</h6>
                                    <p class="text-muted small mb-3">Download the CSV template and fill it with your data. State ID should be numerical.</p>
                                    <a href="{{ route('admin.settings.import.template', 'cities') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-download-line me-1"></i>Download Template
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 2: Export Reference Data</h6>
                                    <p class="text-muted small mb-3">Use the filtered export section above to export countries, states and cities data for reference.</p>
                                    <div class="alert alert-info alert-sm mb-0">
                                        <small><i class="ri-information-line me-1"></i>Use the "Export Data with Filters" section above for better export options</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Districts Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-primary mb-3">
                                <i class="ri-map-2-line me-2"></i>Districts
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 1: Download Template</h6>
                                    <p class="text-muted small mb-3">Download the CSV template and fill it with your data. State ID should be numerical.</p>
                                    <a href="{{ route('admin.settings.import.template', 'districts') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-download-line me-1"></i>Download Template
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 2: Export Reference Data</h6>
                                    <p class="text-muted small mb-3">Use the filtered export section above to export countries, states and districts data for reference.</p>
                                    <div class="alert alert-info alert-sm mb-0">
                                        <small><i class="ri-information-line me-1"></i>Use the "Export Data with Filters" section above for better export options</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Talukas Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-primary mb-3">
                                <i class="ri-community-line me-2"></i>Talukas
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 1: Download Template</h6>
                                    <p class="text-muted small mb-3">Download the CSV template and fill it with your data. City ID should be numerical.</p>
                                    <a href="{{ route('admin.settings.import.template', 'talukas') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-download-line me-1"></i>Download Template
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 2: Export Reference Data</h6>
                                    <p class="text-muted small mb-3">Use the filtered export section above to export all reference data for talukas import.</p>
                                    <div class="alert alert-info alert-sm mb-0">
                                        <small><i class="ri-information-line me-1"></i>Use the "Export Data with Filters" section above for better export options</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Villages Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-primary mb-3">
                                <i class="ri-home-line me-2"></i>Villages
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 1: Download Template</h6>
                                    <p class="text-muted small mb-3">Download the CSV template and fill it with your data. Taluka ID should be numerical.</p>
                                    <a href="{{ route('admin.settings.import.template', 'villages') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-download-line me-1"></i>Download Template
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Step 2: Export Reference Data</h6>
                                    <p class="text-muted small mb-3">Use the filtered export section above to export all reference data for villages import.</p>
                                    <div class="alert alert-info alert-sm mb-0">
                                        <small><i class="ri-information-line me-1"></i>Use the "Export Data with Filters" section above for better export options</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const exportTypeSelect = document.getElementById('export_type');
    const exportCountrySelect = document.getElementById('export_country_id');
    const exportStateSelect = document.getElementById('export_state_id');
    const exportCitySelect = document.getElementById('export_city_id');
    const exportTalukaSelect = document.getElementById('export_taluka_id');
    
    const stateFilterDiv = document.getElementById('stateFilterDiv');
    const cityFilterDiv = document.getElementById('cityFilterDiv');
    const talukaFilterDiv = document.getElementById('talukaFilterDiv');

    // Show/hide filters based on selected type
    exportTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Reset all filters
        stateFilterDiv.style.display = 'none';
        cityFilterDiv.style.display = 'none';
        talukaFilterDiv.style.display = 'none';
        
        // Clear all filter values
        exportStateSelect.innerHTML = '<option value="">All States</option>';
        exportCitySelect.innerHTML = '<option value="">All Cities</option>';
        exportTalukaSelect.innerHTML = '<option value="">All Talukas</option>';
        
        // Show relevant filters
        if (['cities', 'districts', 'talukas', 'villages'].includes(selectedType)) {
            stateFilterDiv.style.display = 'block';
        }
        
        if (['talukas', 'villages'].includes(selectedType)) {
            cityFilterDiv.style.display = 'block';
        }
        
        if (selectedType === 'villages') {
            talukaFilterDiv.style.display = 'block';
        }
    });

    // Load states when country is selected
    exportCountrySelect.addEventListener('change', function() {
        const countryId = this.value;
        if (countryId) {
            fetch(`/admin/settings/import/export-states-ajax?country_id=${countryId}`)
                .then(response => response.json())
                .then(data => {
                    exportStateSelect.innerHTML = '<option value="">All States</option>';
                    data.forEach(state => {
                        exportStateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading states:', error);
                    exportStateSelect.innerHTML = '<option value="">Error loading states</option>';
                });
        } else {
            exportStateSelect.innerHTML = '<option value="">All States</option>';
        }
        
        // Reset dependent dropdowns
        exportCitySelect.innerHTML = '<option value="">All Cities</option>';
        exportTalukaSelect.innerHTML = '<option value="">All Talukas</option>';
    });

    // Load cities when state is selected
    exportStateSelect.addEventListener('change', function() {
        const stateId = this.value;
        if (stateId) {
            fetch(`/admin/settings/import/export-cities-ajax?state_id=${stateId}`)
                .then(response => response.json())
                .then(data => {
                    exportCitySelect.innerHTML = '<option value="">All Cities</option>';
                    data.forEach(city => {
                        exportCitySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    exportCitySelect.innerHTML = '<option value="">Error loading cities</option>';
                });
        } else {
            exportCitySelect.innerHTML = '<option value="">All Cities</option>';
        }
        
        // Reset dependent dropdown
        exportTalukaSelect.innerHTML = '<option value="">All Talukas</option>';
    });

    // Load talukas when city is selected
    exportCitySelect.addEventListener('change', function() {
        const cityId = this.value;
        if (cityId) {
            fetch(`/admin/settings/import/export-talukas-ajax?city_id=${cityId}`)
                .then(response => response.json())
                .then(data => {
                    exportTalukaSelect.innerHTML = '<option value="">All Talukas</option>';
                    data.forEach(taluka => {
                        exportTalukaSelect.innerHTML += `<option value="${taluka.id}">${taluka.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading talukas:', error);
                    exportTalukaSelect.innerHTML = '<option value="">Error loading talukas</option>';
                });
        } else {
            exportTalukaSelect.innerHTML = '<option value="">All Talukas</option>';
        }
    });
});
</script>

@endsection
