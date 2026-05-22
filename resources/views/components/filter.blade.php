@props(['countries'])

<div class="row">
    <div class="col-md-12 text-end">
        @if(request('country') || request('state') || request('city') || request('taluka') || request('village') || request('filter_date'))
            <a href="{{ url()->current() }}" class="btn btn-danger me-2">
                <i class="ri-filter-off-line me-1"></i> Clear Filters
            </a>
        @endif
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="ri-filter-3-line me-1"></i> Filter
        </button>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Records</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url()->current() }}" method="GET">
                <div class="modal-body">
                    <div class="row">
                        {{-- Country --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Country</label>
                            <select class="form-select js-choice-filter" id="country" name="country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- State --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <select class="form-select js-choice-filter" id="state" name="state">
                                <option value="">Select State</option>
                            </select>
                        </div>

                        {{-- City --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <select class="form-select js-choice-filter" id="city" name="city">
                                <option value="">Select City</option>
                            </select>
                        </div>

                         {{-- Taluka --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Taluka</label>
                            <select class="form-select js-choice-filter" id="taluka" name="taluka">
                                <option value="">Select Taluka</option>
                            </select>
                        </div>

                         {{-- Village --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Village</label>
                            <select class="form-select js-choice-filter" id="village" name="village">
                                <option value="">Select Village</option>
                            </select>
                        </div>

                        {{-- Date Filter --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Filter by Date</label>
                            <input type="date" class="form-control basic-datepicker" id="filter_date" name="filter_date" value="{{ request('filter_date') }}">
                            <small class="text-muted">Select a date to filter records by that specific day (ignoring year for anniversaries)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

{{-- <script>
    $(document).ready(function() {
        // Store Choices instances
        let countryChoices, stateChoices, cityChoices;

        // Initialize choices.js for all select elements
        const choices = document.querySelectorAll('.js-choice-filter');
        choices.forEach(choice => {
            if (choice.id === 'country') {
                countryChoices = new Choices(choice, {
                    searchEnabled: true,
                    searchPlaceholderValue: 'Search country...',
                    searchResultLimit: 10,
                    itemSelectText: ''
                });
            } else if (choice.id === 'state') {
                stateChoices = new Choices(choice, {
                    searchEnabled: true,
                    searchPlaceholderValue: 'Search state...',
                    searchResultLimit: 10,
                    itemSelectText: ''
                });
            } else if (choice.id === 'city') {
                cityChoices = new Choices(choice, {
                    searchEnabled: true,
                    searchPlaceholderValue: 'Search city...',
                    searchResultLimit: 10,
                    itemSelectText: ''
                });
            }
        });

        // Function to load states based on selected country
        function loadStates(countryId) {
            if (!countryId) {
                stateChoices.setChoiceByValue('');
                cityChoices.setChoiceByValue('');
                return;
            }

            $.ajax({
                url: "{{ url('admin/settings/get-state') }}" + "/" + countryId,
                type: "GET",
                data: {
                    country_id: countryId
                },
                success: function(response) {
                    let stateSelect = $('#state');
                    stateSelect.empty();
                    stateSelect.append('<option value="">Select State</option>');

                    response.forEach(state => {
                        stateSelect.append(`<option value="${state.id}">${state.name}</option>`);
                    });

                    // Update choices instead of reinitializing
                    stateChoices.destroy();
                    stateChoices = new Choices(stateSelect[0], {
                        searchEnabled: true,
                        searchPlaceholderValue: 'Search state...',
                        searchResultLimit: 10,
                        itemSelectText: ''
                    });
                }
            });
        }

        // Function to load cities based on selected state
        function loadCities(stateId) {
            if (!stateId) {
                cityChoices.setChoiceByValue('');
                return;
            }

            $.ajax({
                url: "{{ url('admin/settings/get-cities') }}" + "/" + stateId,
                type: "GET",
                data: {
                    state_id: stateId
                },
                success: function(response) {
                    let citySelect = $('#city');
                    citySelect.empty();
                    citySelect.append('<option value="">Select City</option>');

                    response.forEach(city => {
                        citySelect.append(`<option value="${city.id}">${city.name}</option>`);
                    });

                    // Update choices instead of reinitializing
                    cityChoices.destroy();
                    cityChoices = new Choices(citySelect[0], {
                        searchEnabled: true,
                        searchPlaceholderValue: 'Search city...',
                        searchResultLimit: 10,
                        itemSelectText: ''
                    });
                }
            });
        }

        // Event listener for country change
        $('#country').on('change', function() {
            loadStates($(this).val());
        });

        // Event listener for state change
        $('#state').on('change', function() {
            loadCities($(this).val());
        });

        // Load states if country is pre-selected
        const selectedCountry = $('#country').val();
        if (selectedCountry) {
            loadStates(selectedCountry);
        }

        // Load cities if state is pre-selected
        const selectedState = $('#state').val();
        if (selectedState) {
            loadCities(selectedState);
        }
    });
</script> --}}
<script>
    $(document).ready(function() {
        // Store Choices instances
        let countryChoices, stateChoices, cityChoices, talukaChoices, villageChoices;

        // Initialize choices.js for all select elements
        const choices = document.querySelectorAll('.js-choice-filter');
        choices.forEach(choice => {
            if (choice.id === 'country') {
                countryChoices = new Choices(choice, { searchEnabled: true, searchPlaceholderValue: 'Search country...', searchResultLimit: 10, itemSelectText: '' });
            } else if (choice.id === 'state') {
                stateChoices = new Choices(choice, { searchEnabled: true, searchPlaceholderValue: 'Search state...', searchResultLimit: 10, itemSelectText: '' });
            } else if (choice.id === 'city') {
                cityChoices = new Choices(choice, { searchEnabled: true, searchPlaceholderValue: 'Search city...', searchResultLimit: 10, itemSelectText: '' });
            } else if (choice.id === 'taluka') {
                talukaChoices = new Choices(choice, { searchEnabled: true, searchPlaceholderValue: 'Search taluka...', searchResultLimit: 10, itemSelectText: '' });
            } else if (choice.id === 'village') {
                villageChoices = new Choices(choice, { searchEnabled: true, searchPlaceholderValue: 'Search village...', searchResultLimit: 10, itemSelectText: '' });
            }
        });

        // Load states
        function loadStates(countryId) {
            if (!countryId) return;

            $.get("{{ url('admin/settings/get-state') }}/" + countryId, function(response) {
                let stateSelect = $('#state').empty().append('<option value="">Select State</option>');
                response.forEach(state => stateSelect.append(`<option value="${state.id}">${state.name}</option>`));

                stateChoices.destroy();
                stateChoices = new Choices(stateSelect[0], { searchEnabled: true, searchPlaceholderValue: 'Search state...', searchResultLimit: 10, itemSelectText: '' });
            });
        }

        // Load cities
        function loadCities(stateId) {
            if (!stateId) return;

            $.get("{{ url('admin/settings/get-cities') }}/" + stateId, function(response) {
                let citySelect = $('#city').empty().append('<option value="">Select City</option>');
                response.forEach(city => citySelect.append(`<option value="${city.id}">${city.name}</option>`));

                cityChoices.destroy();
                cityChoices = new Choices(citySelect[0], { searchEnabled: true, searchPlaceholderValue: 'Search city...', searchResultLimit: 10, itemSelectText: '' });
            });
        }

        // Load talukas
        function loadTalukas(cityId) {
            if (!cityId) return;

            $.get("{{ url('admin/settings/get-talukas') }}/" + cityId, function(response) {
                let talukaSelect = $('#taluka').empty().append('<option value="">Select Taluka</option>');
                response.forEach(taluka => talukaSelect.append(`<option value="${taluka.id}">${taluka.name}</option>`));

                talukaChoices.destroy();
                talukaChoices = new Choices(talukaSelect[0], { searchEnabled: true, searchPlaceholderValue: 'Search taluka...', searchResultLimit: 10, itemSelectText: '' });
            });
        }

        // Load villages
        function loadVillages(talukaId) {
            if (!talukaId) return;

            $.get("{{ url('admin/settings/get-villages') }}/" + talukaId, function(response) {
                let villageSelect = $('#village').empty().append('<option value="">Select Village</option>');
                response.forEach(village => villageSelect.append(`<option value="${village.id}">${village.name}</option>`));

                villageChoices.destroy();
                villageChoices = new Choices(villageSelect[0], { searchEnabled: true, searchPlaceholderValue: 'Search village...', searchResultLimit: 10, itemSelectText: '' });
            });
        }

        // Event listeners
        $('#country').on('change', function() { loadStates($(this).val()); });
        $('#state').on('change', function() { loadCities($(this).val()); });
        $('#city').on('change', function() { loadTalukas($(this).val()); });
        $('#taluka').on('change', function() { loadVillages($(this).val()); });

        // Load default if already selected
        const selectedCountry = $('#country').val();
        if (selectedCountry) loadStates(selectedCountry);

        const selectedState = $('#state').val();
        if (selectedState) loadCities(selectedState);

        const selectedCity = $('#city').val();
        if (selectedCity) loadTalukas(selectedCity);

        const selectedTaluka = $('#taluka').val();
        if (selectedTaluka) loadVillages(selectedTaluka);
    });
</script>
