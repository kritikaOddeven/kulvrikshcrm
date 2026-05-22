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
            <table class="table info-table">
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->first_name ?? '' }}</span></td>

                        <th>Middle Name</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->middle_name ?? '' }}</span></td>

                        <th>Last Name</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->last_name ?? '' }}</span></td>

                        <th>DOB</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->birth_date ?? '' }}</span></td>
                    </tr>

                    <tr>
                        <th>Marriage Date</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->marriage_date ?? '' }}</span></td>

                        <th>Death Date</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->death_date ?? '' }}</span></td>

                        <th>Phone No.</th>
                        <td>:</td>
                        <td class="ps-3">
                            <span>{{ $data->wifeDetail->phonecode ?? '' }}{{ $data->wifeDetail->phone ?? '' }}</span>
                        </td>

                        <th>Email</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->email ?? '' }}</span></td>
                    </tr>

                    <tr>
                        <th>Country</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->countries->name ?? '' }}</span></td>

                        <th>State</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->states->name ?? '' }}</span></td>

                        <th>District</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->districts->name ?? '' }}</span></td>

                        <th>City</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->cities->name ?? '' }}</span></td>
                    </tr>

                    <tr>
                        <th>Taluka</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->talukas->name ?? '' }}</span></td>

                        <th>Village</th>
                        <td>:</td>
                        <td class="ps-3"><span>{{ $data->wifeDetail->villages->name ?? '' }}</span></td>

                        <th>Notes/Address</th>
                        <td>:</td>
                        <td class="ps-3" colspan="3"><span>{{ $data->wifeDetail->address ?? '' }}</span></td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>