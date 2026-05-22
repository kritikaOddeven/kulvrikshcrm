<?php $__env->startSection('pagetitle', 'View Bill | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <style>
        @media print {
            .text-end {
                text-align: right !important;
            }

            .fw-bold {
                font-weight: bold !important;
            }

            .fw-semibold {
                font-weight: 600 !important;
            }

            .table-bordered {
                border: 1px solid #dee2e6 !important;
            }

            .table-bordered td,
            .table-bordered th {
                border: 1px solid #dee2e6 !important;
            }

            .amount-value {
                font-family: monospace !important;
                white-space: nowrap !important;
                text-align: right !important;
            }

            .amount-container {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
            }
        }

        #print-content {
            background: white;
            padding: 20px;
            margin: 0;
            border: 1px solid #E6EAED;
            border-radius: 10px;
        }

        .service-table {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        .service-table td,
        .service-table th {
            padding: 8px !important;
            border: 1px solid #dee2e6 !important;
            vertical-align: middle !important;
        }

        .service-name {
            white-space: normal !important;
            word-break: break-word !important;
            min-width: 200px !important;
        }
    </style>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View Bill</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="#">Bill</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/bills')); ?>">View All Bills</a></li>
                <li class="breadcrumb-item active">View Bill</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_bill_email')): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('send-bill-email', ['bill' => $bill]);

$__html = app('livewire')->mount($__name, $__params, $bill->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?>
          
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bill_pdf_download')): ?>
                <button onclick="generatePDF()" class="btn btn-success border-0 pdf-button"><i class="ri-printer-line"></i> Pdf</button>
            <?php endif; ?>
        </div>
    </div>

    <div id="print-content">
        <div class="panel-body">
            <div class="inv-topbox">
                <div class="inv-logo">
                    <img src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" alt="logo">
                </div>
                <div>
                    <h4 class="inv-number">Invoice <span>#<?php echo e($bill->invoice_number); ?></span></h4>
                </div>
            </div>

            <div class="row justify-content-between view-inv-m">
                <div class="col-auto mt-3">
                    <address>
                        <h4 class="inv-number">From</h4>
                        <table class="inv-address-table">
                            <tbody>
                                <tr>
                                    <th class="pe-3">Name:</th>
                                    <td>Kulvriksh Pvt Ltd </td>
                                </tr>
                                <tr>
                                    <th class="pe-3">Address:</th>
                                    <td>D 204, EARTH ACROPOLIS, TOWER 2, </td>
                                </tr>
                                <tr>
                                    <th class="pe-3"></th>
                                    <td>BHAYLI, VADODARA, GUJARAT - 390002</td>
                                </tr>
                                <tr>
                                    <th class="pe-3">Email:</th>
                                    <td>kulvriksh@gmail.com</td>
                                </tr>
                                <tr>
                                    <th class="pe-3">CIN Number:</th>
                                    <td>U74110GJ2017PTC098902 </td>
                                </tr>
                                <tr>
                                    <th class="pe-3">GST Number:</th>
                                    <td>24AAZCS1599N1Z8 </td>
                                </tr>
                            </tbody>
                        </table>
                    </address>
                </div>

                <div class="col-auto mt-3">
                    <address>
                        <h4 class="inv-number">To</h4>
                        <table class="inv-address-table">
                            <tbody>
                                <tr>
                                    <th class="pe-4">Name:</th>
                                    <td><?php echo e($bill->client->lead->first_name ?? '-'); ?>

                                        <?php echo e($bill->client->lead->middle_name ?? '-'); ?>

                                        <?php echo e($bill->client->lead->last_name ?? '-'); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th class="pe-3">Country:</th>
                                    <td><?php echo e($bill->client->lead->countries->name ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <th class="pe-3">Address:</th>
                                    <td style="width: 300px; text-wrap: break-word;">
                                        <?php echo e($bill->client->lead->notes ?? '-'); ?>, 
                                        <?php echo e(implode(', ', array_filter([$bill->client->lead->villages->name ?? null, $bill->client->lead->talukas->name ?? null, $bill->client->lead->districts->name ?? null, $bill->client->lead->states->name ?? null]))); ?>

                                    </td>
                                </tr>
                                

                                <tr>
                                    <th class="pe-3">Email:</th>
                                    <td><?php echo e($bill->client->lead->email ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <th class="pe-3">Phone No.:</th>
                                    <td><?php echo e($bill->client->lead->phone ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <th class="pe-3">GST No.:</th>
                                    <td><?php echo e($bill->gst_number ?? '-'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </address>
                </div>
            </div>

            <div class="row justify-content-between">
                
                <div class="col-auto">
                    <p class="form-label">Created On</p>
                    <p><?php echo e($bill->created_at->format('d M Y')); ?></p>
                </div>
                <div class="col-auto">
                    <p class="form-label">Status</p>
                    <p>
                        <span class="status-lead-btn <?php echo e($bill->status === 'paid' ? 'high-lead' : 'close-lead'); ?>">
                            <?php echo e(ucfirst($bill->status)); ?>

                        </span>
                    </p>
                </div>
                <div class="col-auto">
                    <p class="form-label">Total Amount</p>
                    <p>₹<?php echo e(number_format((float) $totalAmount, 2, '.', ',')); ?></p>
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table bill-viewtable align-middle">
                        <thead class="table-info text-dark">
                            <tr>
                                <th class="service-name">Service Name</th>
                                <th class="service-name">HSN/SAC</th>
                                <th class="service-name">Kulvriksh Id</th>
                                <th class="text-end">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $amount = $isIndia ? $project->amount : $project->amount + $cgst + $sgst;
                                ?>
                                <tr>
                                    <td class="service-name"><?php echo e($project->name); ?></td>
                                    <td class="service-name"><?php echo e($bill->sac_number); ?></td>
                                    <td class="service-name"><?php echo e($bill->client->kulvrisk_id ?? '-'); ?></td>
                                    <td class="text-end amount-value">₹<?php echo e(number_format((float) $amount, 2, '.', ',')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $amount = $isIndia ? $project->amount : $project->amount + $cgst + $sgst;
                            ?>
                            <tr>
                                <td class="service-name">
                                    <?php echo e($project->name); ?>

                                    <?php if(!empty($project->description)): ?>
                                        <br><small class="text-muted"><?php echo e($project->description); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="service-name">
                                    <?php echo e(!empty($project->hsn) ? $project->hsn : ($bill->sac_number ?? '-')); ?>

                                </td>
                                <td class="service-name"><?php echo e($bill->client->kulvrisk_id ?? '-'); ?></td>
                                <td class="text-end amount-value">₹<?php echo e(number_format((float) $amount, 2, '.', ',')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-8 mb-2">
                        <div class="p-3 bg-light rounded">
                            <h5 class="form-label">Important Notes:</h5>
                            <ul class="bill-note-ul">
                                <li>Payment is due within <strong>30 days</strong> of invoice date.</li>
                                <li>Make payment to the below account details:</li>
                            </ul>
                            <div class="bank-details-box">
                                <p><span>Bank:</span> <?php echo e($bill->bankAccount->bank_name ?? 'N/A'); ?></p>
                                <p><span>Account Holder:</span> <?php echo e($bill->bankAccount->account_holder_name ?? 'N/A'); ?></p>
                                <p><span>Account No:</span> <?php echo e($bill->bankAccount->account_number ?? 'N/A'); ?></p>
                                <p><span>IFSC Code:</span> <?php echo e($bill->bankAccount->ifsc_code ?? 'N/A'); ?></p>
                                <p><span>Branch:</span> <?php echo e($bill->bankAccount->branch ?? 'N/A'); ?></p>
                                <p><span>UPI ID Kulvriksh:</span> <?php echo e($bill->bankAccount->upi_number ?? 'N/A'); ?></p>
                                <p><span>SWIFT Code:</span> <?php echo e($bill->bankAccount->swift_code ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto mb-2">
                        <div class="subtotal-box">
                            <div class="d-flex flex-wrap justify-content-between mb-2"><span class="title pe-3">Sub-total:</span><span class="total-number">₹<?php echo e(number_format((float) ($isIndia ? $subTotal : $subTotal + $cgst + $sgst), 2, '.', ',')); ?></span></div>
                            <?php if($isIndia): ?>
                                <?php if($isGujarat): ?>
                                    <div class="d-flex flex-wrap justify-content-between mb-2"><span class="title pe-3">CGST <small class="text-danger">(9%)</small>:</span><span class="total-number">₹<?php echo e(number_format((float) $cgst, 2, '.', ',')); ?></span></div>
                                    <div class="d-flex flex-wrap justify-content-between mb-2"><span class="title pe-3">SGST <small class="text-danger">(9%)</small>:</span><span class="total-number">₹<?php echo e(number_format((float) $sgst, 2, '.', ',')); ?></span></div>
                                <?php else: ?>
                                    <div class="d-flex flex-wrap justify-content-between mb-2"><span class="title pe-3">IGST <small class="text-danger">(18%)</small>:</span><span class="total-number">₹<?php echo e(number_format((float) $igst, 2, '.', ',')); ?></span></div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <!-- <div class="d-flex flex-wrap justify-content-between mb-2"><span class="title pe-3">Actual Amount:</span><span class="total-number">₹<?php echo e(number_format((float) $grossAmount, 2, '.', ',')); ?></span></div> -->
                            <?php if($roundOffDiscount > 0): ?>
                                <div class="d-flex flex-wrap justify-content-between mb-2"><span class="title pe-3">Discount:</span><span class="total-number">₹<?php echo e(number_format((float) $roundOffDiscount, 2, '.', ',')); ?></span></div>
                            <?php endif; ?>
                            <div class="d-flex flex-wrap justify-content-between"><span class="total-title pe-3">Total Amount:</span><span class="total-title">₹<?php echo e(number_format((float) $totalAmount, 2, '.', ',')); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-4">
                <div class="">

                    <h4>Terms & Condition</h4>
                    <p>
                        The payment is immediate. Genealogy research will take 7 to 251 working days. For more terms and conditions,
                        visit www.kulvriksh.in. The genealogy research fee is non-refundable.
                    </p>
                </div>
                <div class="mt-2">
                    <h4>Declaration</h4>
                    <p>
                        We declare that this invoice shows the actual price of the goods described and that all particulars are true and
                        correct in all respects."
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Add html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function generatePDF() {
            const element = document.getElementById('print-content');
            const button = document.querySelector('.btn-success');
            const originalText = button.innerHTML;

            // Disable the button instead of hiding it
            button.disabled = true;
            button.innerHTML = '<i class="ri-loader-4-line"></i> Generating...';

            html2canvas(element, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('bill-<?php echo e($bill->invoice_number); ?>.pdf');

                // Re-enable the button and restore original text
                button.disabled = false;
                button.innerHTML = originalText;
            }).catch(error => {
                console.error('Error generating PDF:', error);
                // Re-enable the button and restore original text on error
                button.disabled = false;
                button.innerHTML = originalText;
                alert('Error generating PDF. Please try again.');
            });
        }
    </script>

    <?php echo $__env->make('admin.bills.modals.generate-bill-existing-client', ['client' => $bill->client], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/bills/view.blade.php ENDPATH**/ ?>