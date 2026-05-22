{{-- Children Information --}}
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
            Children Information
        </button>
    </h2>
    <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse">
        <div class="accordion-body">
            <table class="table info-table">
                <thead>
                    <tr>
                        <th>Gender</th>
                        <th>Children Name</th>
                        <th>Birth Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->children as $item)
                        <tr>

                            <td class="ps-3"><span>{{ ucfirst($item->gender ?? '') }}</span></td>

                            <td class="ps-3"><span>{{ $item->name ?? '' }}</span></td>


                            <td class="ps-3"><span>{{ $item->birth_date ?? '' }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
