<div>
    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
    
    <!-- Trigger Button -->
    <button wire:click="prepareEmail" class="email-icon-btn" wire:loading.attr="disabled">
        <span wire:loading.remove>
            <i class="ri-mail-line"></i>
        </span>
        <span wire:loading>
            <div class="spinner-border" role="status"></div>
        </span>
    </button>

    @if ($showModal)
        <!-- Modal -->
        <div class="modal d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-lg" role="document" style="z-index: 1055;">
                <div class="modal-content">
                    <form wire:submit.prevent="send">
                        <div class="modal-header">
                            <h5 class="modal-title">Send Bill via Email</h5>
                            <button type="button" class="btn-close" wire:click="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" wire:model="email" class="form-control" placeholder="Enter email address">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" wire:model="subject" class="form-control" placeholder="Enter email subject">
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea wire:model="body" class="form-control" rows="4" placeholder="Enter your message here..."></textarea>
                                @error('body')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Attachment</label>
                                <div class="border rounded p-3 bg-light">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ri-file-pdf-line text-danger" style="font-size: 1.2em;"></i>
                                            <span class="fw-medium">Invoice_{{ $bill->invoice_number }}.pdf</span>
                                        </div>
                                                                            @if($pdfFilename)
                                        <a href="{{ $this->getPdfPreviewUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="ri-eye-line"></i> Preview
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            <i class="ri-loader-4-line animate-spin"></i> Generating...
                                        </span>
                                    @endif
                                    </div>
                                    <small class="text-muted d-block mt-1">PDF will be automatically generated and attached to the email.</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Send Email</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Sending...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('pdfGenerated', () => {
                // PDF has been generated, preview button should now be available
                console.log('PDF generated successfully');
            });
        });
    </script>
</div> 