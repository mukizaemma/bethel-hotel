<div class="account-livewire-page" style="max-width: 560px;">
    <h1 class="h4 mb-4">My profile</h1>

    @if(session('account_message'))
        <div class="alert alert-success">{{ session('account_message') }}</div>
    @endif

    <form wire:submit="save" class="stat-card p-4">
        <div class="mb-3">
            <label class="form-label">Full name</label>
            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>
