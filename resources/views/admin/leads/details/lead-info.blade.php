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
            <table class="table info-table">
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->first_name ?? '' }}</td>
                        <th>Middle Name</th>
                        <td>:</td>

                        <td class="ps-3">{{ $data->middle_name ?? '' }}</td>
                        <th>Last Name</th>
                        <td>:</td>

                        <td class="ps-3">{{ $data->last_name ?? '' }}</td>
                        <th>DOB</th>
                        <td>:</td>

                        <td class="ps-3">{{ $data->birth_date ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Marriage Date</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->marriage_date ?? '' }}</td>
                        <th>Phone No.</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->phone ?? '' }}</td>
                        <th>Email</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->email ?? '' }}</td>
                        <th>Country</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->countries->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->states->name ?? '' }}</td>
                        <th>District</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->districts->name ?? '' }}</td>
                        <th>City</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->cities->name ?? '' }}</td>
                        <th>Taluka</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->talukas->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Village</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->villages->name ?? '' }}</td>

                        <th>Alternate Mobile number</th>
                        <td>:</td>
                        <td class="ps-3">{{ $data->alternate_mobile_number ?? '' }}</td>
                        
                        <th>Address</th>
                        <td>:</td>
                        <td class="ps-3" colspan="5">{{ $data->notes ?? '' }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>