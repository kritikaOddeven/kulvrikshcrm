<div class="row py-3 align-items-sm-center justify-content-between gap-2">
    <div class="col-auto">
        <h4 class="page-title">View Lead</h4>
        
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Lead</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo e(url('admin/leads')); ?>">View All Leads</a></li>
            <li class="breadcrumb-item active">View Leads</li>
        </ol>
    </div>
    <div class="col-auto d-flex flex-wrap gap-2">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_lead_whatsapp')): ?>
            <a href="" type="button" class="whatsapp-icon-btn"><i class="ri-whatsapp-line"></i></a>
        <?php endif; ?>
        
        <!-- Open Email Modal -->

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_lead_email')): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('send-lead-email', ['lead' => $data]);

$__html = app('livewire')->mount($__name, $__params, $data->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preview_lead')): ?>
            <a href="<?php echo e(route('admin.leads.download-pdf', $data->id)); ?>" type="button" class="btn btn-success" id="pdfPreviewBtn" onclick="showPdfLoader(this)">
                <i class="ri-printer-line"></i> Preview
            </a>
        <?php endif; ?>

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

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('convert_to_client')): ?>
            <a type="button" class="btn btn-primary mr-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" title="view"><i class="ri-refresh-fill"></i> Convert to Client</a>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_lead')): ?>
            <a href="<?php echo e(url('admin/leads/edit/' . $data->id)); ?>" class="btn btn-primary mr-1" title="edit"><i class="ri-edit-line"></i> Edit Lead</a>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/details/header-actions.blade.php ENDPATH**/ ?>