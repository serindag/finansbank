<div class="card">
    <div class="card-header">Şifre Değiştir</div>

    <div class="card-body">
        <div class="mb-3">
            Güvende kalmak için hesabınızın uzun ve rastgele bir parola kullandığından emin olun.
        </div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">
                    Mevcut Şifre : 
                </label>

                <div class="col-md-6">
                    <input id="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" name="current_password" required autocomplete="current-password">

                    @error('current_password', 'updatePassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">
                   Yeni Şifre : 
                </label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password', 'updatePassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">
                   Şifreyi Tekrarlayınız : 
                </label>

                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" name="password_confirmation" required>

                    @error('password_confirmation', 'updatePassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Kaydet
                    </button>
                    @if (session('status') === 'password-updated')
                        <span class="m-1 fade-out">{{ __('Saved.') }}</span>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>