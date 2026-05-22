{{-- family member Info --}}
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
            Family Information
        </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
        <div class="accordion-body">
            <table class="table info-table">
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Marriage Date</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->families->whereIn('belongs_to', 'lead') as $item)
                        <tr>
                            <td>{{ ucfirst($item->relation) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->birth_date }}</td>
                            <td>{{ $item->marriage_date }}</td>
                            <td>{{ $item->death_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table info-table">
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->siblings->whereIn('belongs_to', 'lead') as $item)
                        <tr>
                            <td>{{ ucfirst($item->relation) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->birth_date }}</td>
                            <td>{{ $item->death_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-12 mb-2">
                    <label for="notes" class="form-label">Ancestor History Notes</label>
                    <textarea class="form-control" readonly name="lead_ancestor_notes" rows="3">{{ $data->lead_ancestor_notes }}</textarea>
                </div>
            </div>

        </div>
    </div>
</div>
