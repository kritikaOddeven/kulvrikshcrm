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
        
        .attachment-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        
        .attachment-name {
            flex: 1;
            margin-right: 10px;
        }
        
        .remove-attachment {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
    <!-- Trigger Button (this can be outside too) -->
    <button wire:click="prepareEmail" class="email-icon-btn" wire:loading.attr="disabled">
        <span wire:loading.remove>
            <i class="ri-mail-line"></i>
        </span>
        <span wire:loading>
            <span class="loader" style="border: 2px solid #f3f3f3; border-top: 2px solid #007bff; border-radius: 50%; width: 14px; height: 14px; display: inline-block; animation: spin 1s linear infinite; vertical-align: middle; margin-right: 5px;"></span>
        </span>
    </button>

    @if ($showModal)
        <!-- Modal -->
        <div class="modal d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-lg" role="document" style="z-index: 1055;">
                <div class="modal-content">
                    <form wire:submit.prevent="send">
                        <div class="modal-header">
                            <h5 class="modal-title">Send Lead Preview via Email</h5>
                            <button type="button" class="btn-close" wire:click="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Email Address(es) <x-required-star /></label>
                                <input type="text" wire:model="email" class="form-control" placeholder="Enter email addresses separated by commas (e.g., email1@example.com, email2@example.com)">
                                <small class=" text-danger">You can enter multiple email addresses separated by commas.</small><br>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Subject<x-required-star /></label>
                                <input type="text" wire:model="subject" class="form-control">
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Message<x-required-star /></label>
                                <textarea id="editor" wire:model="inbox" class="form-control editor" rows="6" placeholder="Enter your message here..."></textarea>
                                @error('inbox')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Attachments (Optional)</label>
                                <input type="file" wire:model="attachments" class="form-control" multiple>
                                <small class="text-muted">You can select multiple files. Maximum 10MB per file.</small>
                                @error('attachments.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            @if(count($attachments) > 0)
                                <div class="mb-3">
                                    <label class="form-label">Selected Attachments:</label>
                                    @foreach($attachments as $index => $attachment)
                                        <div class="attachment-item">
                                            <span class="attachment-name">{{ $attachment->getClientOriginalName() }}</span>
                                            <button type="button" class="remove-attachment" wire:click="removeAttachment({{ $index }})">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                        </div>
                        <div class="modal-footer">
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

</div>
