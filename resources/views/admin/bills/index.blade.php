@extends('admin.layouts.app')
@section('pagetitle', 'Bill | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Bills</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="">Bills</a></li>
                <li class="breadcrumb-item active">View All Bills</li>
            </ol>
        </div>
        {{-- <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/admin/bills/create') }}" type="button" class="btn btn-primary">+ Add Bill</a>
        </div> --}}
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-alert />

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>KV ID</th>
                                <th>Invoice Number</th>
                                <th>Client Name</th>
                                <th>Services Name</th>
                                <th>Bill Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bills as $bill)
                                <tr>
                                    <td>{{ $bill->client->kulvrisk_id ?? '-' }}</td>
                                    <td>{{ $bill->invoice_number }}</td>
                                    {{-- <td>{{ $bill->client->user->name ?? '-' }}</td> --}}
                                    {{-- <td>
                                        {{ $bill->client->lead->first_name }} {{ $bill->client->lead->middle_name }} {{ $bill->client->lead->last_name }}
                                    </td> --}}
                                    <td>
                                        {{-- {{ !empty($bill->name) ? $bill->name : trim($bill->client->lead->first_name . ' ' . $bill->client->lead->middle_name . ' ' . $bill->client->lead->last_name) ?? ''}} --}}
                                        {{ !empty($bill->name) ? $bill->name : trim(optional($bill->client->lead)->first_name . ' ' . optional($bill->client->lead)->middle_name . ' ' . optional($bill->client->lead)->last_name) }}
                                    </td>

                                    <td>
                                        <!-- @php
                                            $subProjectIds = json_decode($bill->sub_project_ids ?? ($bill->client->sub_project_ids ?? '[]'), true) ?: [];
                                            $projectsById = \App\Models\Project::whereIn('id', array_unique($subProjectIds))->get()->keyBy('id');
                                            $names = collect($subProjectIds)->map(fn($id) => $projectsById->get($id)?->name)->filter()->toArray();
                                        @endphp
                                                    {{ implode(', ', $names) }} -->
                                        @php
                                            $names = [];

                                            foreach ($bill->billServices as $svc) {
                                                if ($svc->type === 'project') {
                                                    $names[] = $svc->subProject->name ?? '-';
                                                } else {
                                                    $names[] = $svc->service_name ?? '-';
                                                }
                                            }
                                        @endphp

                                        {{ implode(', ', array_filter($names)) }}
                                    </td>
                                    {{-- <td>{{ $bill->created_at->format('d M Y') }}</td> --}}
                                    <td data-order="{{ $bill->created_at->timestamp }}">
                                        {{ $bill->created_at->format('d M Y') }}
                                    </td>

                                    <td>
                                        <span class="status-lead-btn {{ $bill->status == 'paid' ? 'high-lead' : 'close-lead' }}">
                                            {{ ucfirst($bill->status) }}
                                        </span>
                                    </td>
                                    <td>₹{{ number_format(round($bill->amount * 1.18), 2) }}</td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('view_bill')
                                                <a href="{{ url('admin/bills/' . $bill->id) }}" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                            @endcan

                                            @can('edit_bill')
                                                <a href="{{ url('admin/bills/edit/' . $bill->id) }}" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a>
                                            @endcan

                                            @can('delete_bill')
                                                <form action="{{ url('admin/bills/delete/' . $bill->id) }}" method="POST" id="deleteForm_{{ $bill->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Bill" data-description="Are you sure you want to delete this Bill?" onclick="deleteAccount(this, {{ $bill->id }})">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        @push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#datatable').DataTable({
        "destroy": true,
        "order": [[4, "desc"]], // ✅ latest bill first
    });
});
</script>
@endpush
@endsection
