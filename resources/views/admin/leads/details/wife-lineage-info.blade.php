{{-- Wife Family lineage and heritage --}}
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
            Wife Family lineage and heritage
        </button>
    </h2>

    @php
        $wifeLineage = $data->lineages && isset($data->lineages) ? $data->lineages()->firstWhere('belongs_to', 'wife') : null;
    @endphp
    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse">
        <div class="accordion-body">
            <table class="table info-table">
                <tbody>
                    <tr>
                        <th>Lineage</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->lineage ?? '' }}</td>

                        <th>Caste</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->caste ?? '' }}</td>

                        <th>Sub-Caste</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->sub_caste ?? '' }}</td>

                        <th>Surname</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->surname ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Gotra</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->gotra ?? '' }}</td>

                        <th>Kuldevi</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->kuldevi ?? '' }}</td>

                        <th>Kuldevta</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->kuldevta ?? '' }}</td>

                        <th>Primary Clan</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->primary_clan ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Sub-clan</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->sub_clan ?? '' }}</td>

                        <th>Khap</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->khap ?? '' }}</td>

                        <th>Rulership</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->rulership ?? '' }}</td>


                        <th>Spiritual Seat</th>
                        <td>:</td>
                        <td class="ps-3">{{ optional($wifeLineage)->spiritual_seat ?? '' }}</td>
                    </tr>
                    <tr>

                        <th> Ancestral Village</th>
                        <td>:</td>
                        <td class="ps-3" colspan="4"> {{ optional($wifeLineage)->ancestral_village ?? '' }} </td>

                        <th>Notes/Address</th>
                        <td>:</td>
                        <td class="ps-3" colspan="4">{{ optional($wifeLineage)->note ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
