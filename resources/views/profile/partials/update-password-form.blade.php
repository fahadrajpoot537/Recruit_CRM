<section class="mb-4">
    <header class="mb-3">
        <h2 class="h5 text-dark">
            {{ __('Update Password') }}
        </h2>
        <p class="small text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input 
                type="password" 
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                id="update_password_current_password" 
                name="current_password" 
                autocomplete="current-password"
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input 
                type="password" 
                class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                id="update_password_password" 
                name="password" 
                autocomplete="new-password"
            >
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input 
                type="password" 
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                autocomplete="new-password"
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <span class="small text-muted" id="saved-message">{{ __('Saved.') }}</span>
                <script>
                    setTimeout(() => {
                        document.getElementById('saved-message')?.remove();
                    }, 2000);
                </script>
            @endif
        </div>
    </form>
</section>
