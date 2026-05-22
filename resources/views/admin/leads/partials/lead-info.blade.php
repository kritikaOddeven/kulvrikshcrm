<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
            Lead Information
        </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">First Name<x-required-star /></label>
                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                    <span class="text-danger">
                        @error('first_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}">
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Last Name<x-required-star /></label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                    <span class="text-danger">
                        @error('last_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">DOB</label>
                    <div class="position-relative">
                        <input type="text" value="{{ old('dob') }}" class="form-control basic-datepicker pe-5" name="dob" id="dob" placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Marriage Date</label>
                    <div class="position-relative">
                        <input type="text" class="form-control basic-datepicker pe-5" value="{{ old('marriage_date') }}" name="marriage_date" id="marriage_date" placeholder="dd-mm-yyyy">
                        <i class="ri-calendar-2-line calendar-icon"></i>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Phone No. <x-required-star /></label>
                    <div class="input-group">
                        <input type="hidden" name="phonecode" value="{{ old('phonecode') ?? '+91' }}">
                        <span class="input-group-text" id="phonecode">+91</span>
                        <input type="text" class="form-control" value="{{ old('phone') }}" name="phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <span class="text-danger phone-error">
                        @error('phone')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Alternate Mobile number </label>
                    <div class="input-group">
                        <input type="hidden" name="alternate_phonecode" value="{{ old('alternate_phonecode') ?? '+91' }}">
                        <span class="input-group-text" id="alternate_phonecode">+91</span>
                        <input type="text" class="form-control" value="{{ old('alternate_mobile_number') }}" name="alternate_mobile_number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <span class="text-danger">
                        @error('alternate_mobile_number')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Email </label>
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">Country<x-required-star /></label>
                    <select class="form-select js-choice lead-country" id="country" name="country">
                        <option disabled>Select Country</option>
                        @foreach ($country as $item)
                            <option value="{{ $item->id }}" {{ $item->name == 'India' ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger country-error">
                        @error('country')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">State<x-required-star /></label>
                    <select class="form-select js-choice lead-state" id="state" name="state">
                        <option disabled selected>Select State</option>
                    </select>
                    <span class="text-danger state-error">
                        @error('state')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">District<x-required-star /></label>
                    <select class="form-select js-choice lead-district" id="district" name="district">
                        <option disabled selected>Select District</option>
                    </select>
                    <span class="text-danger district-error">
                        @error('district')
                            {{ $message }}
                        @enderror
                    </span>
                </div>



                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="validationDefault01" class="form-label">City<x-required-star /></label>
                    <select class="form-select js-choice lead-city" id="city" name="city">
                        <option disabled selected>Select City</option>
                    </select>
                    <span class="text-danger city-error">
                        @error('city')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="taluka" class="form-label">Taluka</label>
                    <select class="form-select js-choice lead-taluka" id="taluka" name="taluka">
                        <option disabled selected>Select Taluka</option>
                    </select>
                    <span class="text-danger taluka-error">
                        @error('taluka')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <label for="village" class="form-label">Village</label>
                    <select class="form-select js-choice lead-village" id="village" name="village">
                        <option disabled selected>Select Village</option>
                    </select>
                    <span class="text-danger village-error">
                        @error('village')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="col-lg-6 col-md-4">
                    <label for="validationDefault01" class="form-label">Address</label>
                    <input type="text" class="form-control" value="{{ old('notes_address') }}" name="notes_address">
                </div>

            </div>
        </div>

    </div>
</div>
