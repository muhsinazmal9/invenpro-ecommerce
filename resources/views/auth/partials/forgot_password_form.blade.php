<form action="{{ route('password.email') }}" method="POST" id="forgotPasswordForm">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-style-1">
                <label>{{ 'Your Email' }}</label>
                <input type="email" placeholder="{{ 'Email' }}" name="email" id="email" autofocus autocomplete="email" value="{{ old('email') }}" />
                @error('email')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="button-group d-flex justify-content-center flex-wrap">
                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center fusionshop-primary-bg rounded-md fs-6">
                    {{ 'Email Password Reset Link' }}
                </button>
            </div>
        </div>
    </div>
</form>



