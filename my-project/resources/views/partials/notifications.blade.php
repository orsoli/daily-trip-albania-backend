@if (session('status'))
<div class="toast text-bg-secondary position-fixed top-0 end-0 z-1" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header">
        <i class="bi bi-exclamation-circle me-2"></i>
        <strong class="me-auto">{{ ucwords('Status') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ session('status') }}
    </div>
</div>
@endif

@if (session('success'))
<div class="toast text-bg-success position-fixed top-0 end-0 z-1" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="bi bi-exclamation-circle me-2"></i>
        <strong class="me-auto">{{ ucwords('Success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ session('success') }}
    </div>
</div>
@endif

@if (session('error'))
<div class="toast text-bg-danger position-fixed top-0 end-0 z-1" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="bi bi-exclamation-circle me-2"></i>
        <strong class="me-auto">{{ ucwords('Success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ session('error') }}
    </div>
</div>
@endif