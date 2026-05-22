<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Test SMTP configuration</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="sendTestEmail">
                <div class="row">
                    <div class="col">
                        <input type="email" class="form-control" wire:model="email" placeholder="Enter your test email address">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="sendTestEmail">
                            <span wire:loading.remove wire:target="sendTestEmail">Send test email</span>
                            <span wire:loading wire:target="sendTestEmail">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Sending...
                            </span>
                        </button>
                    </div>

                </div>

                @if ($message)
                    <div class="mt-3 alert alert-{{ $status === 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            </form>
        </div>
    </div>

</div>
