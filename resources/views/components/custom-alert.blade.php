<div>
    @if (session('success') || session('error') || session('info') || session('failed'))
        @php
            $type = session('success') ? 'success' : (session('error') || session('failed') ? 'danger' : 'info');
            $message = session('success') ?? (session('error') ?? session('info')) ?? session('failed');
        @endphp

        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="alert alert-{{ $type }} alert-dismissible fade show mt-3" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

</div>