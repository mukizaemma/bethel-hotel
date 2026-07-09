<div class="account-livewire-page" style="max-width: 560px;">
    <h1 class="h4 mb-4">Change password</h1>

    @if(session('account_message'))
        <div class="alert alert-success">{{ session('account_message') }}</div>
    @endif

    <form wire:submit="updatePassword" class="stat-card p-4">
        <div class="mb-3">
            <label class="form-label">Current password</label>
            <input type="password" wire:model="current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">
            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">New password</label>
            <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm new password</label>
            <input type="password" wire:model="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Update password</button>
    </form>
</div>
