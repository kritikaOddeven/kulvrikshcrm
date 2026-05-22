@extends('admin.layouts.app')
@section('pagetitle', 'Researcher Report | Kulvriksh')
@section('admin-content')

    <style>
        .avatar-list-stack {
            display: flex;
            align-items: center;
        }

        .avatar-list-stack .avatar {
            border: 2px solid #fff;
            z-index: 1;
            position: relative;
        }

        .avatar-list-stack .avatar:first-child {
            margin-left: 0;
        }

        .avatar-list-stack .avatar.more {
            background-color: #3394df;
            color: #fff;
        }

        /* Blur background when modal is shown */
        body.modal-open {
            filter: blur(0.5px);
            transition: filter 0.3s ease;
        }

        /* Ensure modal content is not blurred */
        .modal {
            filter: none !important;
        }

        .modal-content {
            filter: none !important;
        }
    </style>

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Researcher Report</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="">Researcher Report</a></li>
                <li class="breadcrumb-item active">View All Researchers Report</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>KV ID</th>
                                <th>Client Name</th>
                                <th>Email Id</th>
                                <th>Researcher Name</th>
                                <th>Project Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($researchers as $report)
                                <tr>
                                    @php
                                        $assign_researchers = getResearchersWithNames(json_decode($report->researcher_ids ?? '[]', true))['researchers'];
                                        $projectData = getProjectsWithNames('parent', json_decode($report->project_ids ?? '[]', true));

                                    @endphp
                                    <td>{{ $report->kulvrisk_id }}</td>
                                    <td>{{ $report->lead->first_name ?? '' }} {{ $report->lead->middle_name ?? '' }} {{ $report->lead->last_name ?? '' }}</td>
                                    <td>{{ $report->lead->email ?? '' }}</td>
                                    <td>
                                        {{-- <div class="avatar-group avatar-list-stack">
                                            @foreach ($assign_researchers as $data)
                                                <div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="{{ $data->name }}">
                                                    {{ get_initials($data->name) }}
                                                </div>
                                            @endforeach
                                        </div> --}}
                                        <div class="avatar-group avatar-list-stack">
                                            @foreach ($assign_researchers->take(3) as $data)
                                                <div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="{{ $data->name }}">
                                                    {{ get_initials($data->name) }}
                                                </div>
                                            @endforeach

                                            @if ($assign_researchers->count() > 3)
                                                <div class="avatar avatar-xs rounded-circle d-inline-flex align-items-center justify-content-center more" style="width: 32px; height: 32px; font-size: 12px;">
                                                    +{{ $assign_researchers->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $projectData['names'] }}</td>
                                    <td>{{ $report->start_date ?? '' }}</td>
                                    <td>{{ $report->end_date ?? '' }}</td>
                                    <td style="width: 150px">
                                        <div class="d-flex gap-2">
                                            @can('download_researcher_report')
                                                @if ($report->report && $report->report->exists())
                                                    <button type="button" class="btn-sm edit-icon-btn" onclick="downloadPDF({{ $report->id }})" title="Download"><i class="ri-download-2-line"></i></button>
                                                @endif
                                            @endcan
                                            @can('view_researcher_report')
                                                <a href="{{ url('admin/research-reports/view/' . $report->id) }}" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                            @endcan
                                            @can('delete_researcher_report')
                                                <form action="{{ url('admin/research-reports/delete/' . $report->id) }}" method="POST" id="deleteForm_{{ $report->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Researcher Report" data-description="Are you sure you want to delete this Researcher Report ?" onclick="deleteAccount(this, {{ $report->id }})">
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

    <!-- Loading Modal -->
    <div class="modal fade" id="pdfLoadingModal" tabindex="-1" aria-labelledby="pdfLoadingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="mb-2">Generating PDF Report</h5>
                    <p class="text-muted mb-0">Please wait while we prepare your report...</p>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="pdfProgressBar"></div>
                    </div>
                    <small class="text-muted mt-2 d-block" id="pdfProgressText">Initializing...</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Include html2canvas and jsPDF libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function downloadPDF(reportId) {
            // Show loading modal
            const loadingModal = new bootstrap.Modal(document.getElementById('pdfLoadingModal'));
            loadingModal.show();

            // Add blur effect to background
            document.body.classList.add('modal-open');

            // Update progress
            updateProgress(10, 'Fetching report data...');

            // Fetch the PDF page content
            fetch(`{{ url('admin/research-reports/pdf1') }}/${reportId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch report data');
                    }
                    return response.text();
                })
                .then(html => {
                    updateProgress(20, 'Preparing content...');

                    // Create a temporary container
                    const tempContainer = document.createElement('div');
                    tempContainer.style.position = 'absolute';
                    tempContainer.style.left = '-9999px';
                    tempContainer.style.top = '-9999px';
                    tempContainer.style.width = '800px'; // Set fixed width for consistent rendering
                    tempContainer.innerHTML = html;
                    document.body.appendChild(tempContainer);

                    // Extract only the main content area (cards) and remove unnecessary elements
                    const mainContent = tempContainer.querySelector('.row .col-12');
                    if (mainContent) {
                        // Remove any navigation, headers, or other unnecessary elements
                        const elementsToRemove = mainContent.querySelectorAll('.py-3, .breadcrumb, .page-title, .btn, script, style');
                        elementsToRemove.forEach(el => el.remove());

                        // Get all cards from the cleaned content
                        const cards = mainContent.querySelectorAll('.card');

                        if (cards.length === 0) {
                            throw new Error('No content found to generate PDF');
                        }

                        updateProgress(30, `Found ${cards.length} page(s) to process...`);

                        // Create a new jsPDF instance
                        const {
                            jsPDF
                        } = window.jspdf;
                        const pdf = new jsPDF('p', 'mm', 'a4');

                        // Process each card
                        const processCard = (index) => {
                            if (index >= cards.length) {
                                // All cards processed, save the PDF
                                updateProgress(95, 'Finalizing PDF...');

                                setTimeout(() => {
                                    pdf.save(`kulvriksh-report-${reportId}.pdf`);

                                    updateProgress(100, 'Download complete!');

                                    setTimeout(() => {
                                        // Clean up
                                        document.body.removeChild(tempContainer);
                                        loadingModal.hide();
                                        document.body.classList.remove('modal-open');
                                    }, 1000);
                                }, 500);

                                return;
                            }

                            const card = cards[index];
                            const progressPercent = 30 + ((index + 1) / cards.length) * 60;
                            updateProgress(progressPercent, `Processing page ${index + 1} of ${cards.length}...`);

                            html2canvas(card, {
                                scale: 2,
                                useCORS: true,
                                logging: false,
                                allowTaint: true,
                                windowWidth: card.scrollWidth,
                                windowHeight: card.scrollHeight,
                                backgroundColor: '#ffffff'
                            }).then(canvas => {
                                const imgData = canvas.toDataURL('image/png');

                                // Add new page for each card except the first one
                                if (index > 0) {
                                    pdf.addPage();
                                }

                                // Calculate dimensions to fit the page
                                const imgWidth = 210; // A4 width in mm
                                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                                // Add the image to the PDF
                                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

                                // Process next card
                                processCard(index + 1);
                            }).catch(error => {
                                console.error('Error generating PDF:', error);
                                showError('Error generating PDF. Please try again.');

                                // Clean up
                                document.body.removeChild(tempContainer);
                                loadingModal.hide();
                                document.body.classList.remove('modal-open');
                            });
                        };

                        // Start processing from the first card
                        processCard(0);
                    } else {
                        throw new Error('Could not find main content area');
                    }
                })
                .catch(error => {
                    console.error('Error fetching PDF content:', error);
                    showError('Error fetching report data. Please try again.');
                    loadingModal.hide();
                    document.body.classList.remove('modal-open');
                });
        }

        function updateProgress(percent, text) {
            const progressBar = document.getElementById('pdfProgressBar');
            const progressText = document.getElementById('pdfProgressText');

            progressBar.style.width = percent + '%';
            progressBar.setAttribute('aria-valuenow', percent);
            progressText.textContent = text;
        }

        function showError(message) {
            // Show error in modal
            const modalBody = document.querySelector('#pdfLoadingModal .modal-body');
            modalBody.innerHTML = `
        <div class="text-center p-4">
            <i class="ri-error-warning-line text-danger" style="font-size: 3rem;"></i>
            <h5 class="mt-3 text-danger">Error</h5>
            <p class="text-muted">${message}</p>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    `;
        }
    </script>
@endsection
