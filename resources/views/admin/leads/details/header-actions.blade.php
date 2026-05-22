<div class="row py-3 align-items-sm-center justify-content-between gap-2">
    <div class="col-auto">
        <h4 class="page-title">View Lead</h4>
        {{-- <p>Agents/View All Agents</p> --}}
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Lead</a></li>
            <li class="breadcrumb-item active"><a href="{{ url('admin/leads') }}">View All Leads</a></li>
            <li class="breadcrumb-item active">View Leads</li>
        </ol>
    </div>
    <div class="col-auto d-flex flex-wrap gap-2">
        @can('send_lead_whatsapp')
            <a href="" type="button" class="whatsapp-icon-btn"><i class="ri-whatsapp-line"></i></a>
        @endcan
        {{-- <a href="" type="button" class="email-icon-btn"><i class="ri-mail-line"></i></a> --}}
        <!-- Open Email Modal -->

        @can('send_lead_email')
            @livewire('send-lead-email', ['lead' => $data], key($data->id))
        @endcan

        @can('preview_lead')
            <a href="{{ route('admin.leads.download-pdf', $data->id) }}" type="button" class="btn btn-success" id="pdfPreviewBtn" onclick="showPdfLoader(this)">
                <i class="ri-printer-line"></i> Preview
            </a>
        @endcan

        <style>
            .animate-spin {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .btn.loading {
                cursor: not-allowed;
                opacity: 0.8;
            }
        </style>

        @can('convert_to_client')
            <a type="button" class="btn btn-primary mr-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" title="view"><i class="ri-refresh-fill"></i> Convert to Client</a>
        @endcan

        @can('edit_lead')
            <a href="{{ url('admin/leads/edit/' . $data->id) }}" class="btn btn-primary mr-1" title="edit"><i class="ri-edit-line"></i> Edit Lead</a>
        @endcan
    </div>
</div>
