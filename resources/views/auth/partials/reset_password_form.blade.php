<form action="{{ route('admin.password.store') }}" method="POST" id="resetPasswordForm">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="row">
        <div class="col-12">
            <div class="input-style-1">
                <label>Your Email</label>
                <input type="email" placeholder="Email" name="email" id="email" autofocus autocomplete="email" value="{{ old('email', $request->email) }}" />
                @error('email')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-style-1">
                <label>{{ __('passwords.new_password') }}</label>
                <input type="password" placeholder="{{ __('passwords.new_password') }}" name="password" id="password" autocomplete="password" />
                <span class="mdi mdi-eye fs-5 toggle-password cursor-pointer" toggle="#password" style="position: absolute; top: 50%; left: 90%; transform: translateY(-50%, -50%);"></span>
                @error('password')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-style-1">
                <label>{{ __('passwords.confirm_password') }}</label>
                <input type="password" placeholder="{{ __('passwords.confirm_password') }}" name="password_confirmation" id="password_confirmation" autocomplete="password_confirmation" />
                <span class="mdi mdi-eye fs-5 toggle-password cursor-pointer" toggle="#password_confirmation" style="position: absolute; top: 50%; left: 90%; transform: translateY(-50%, -50%);"></span>
                @error('password_confirmation')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="button-group d-flex justify-content-center flex-wrap">
                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center fusionshop-primary-bg rounded-md fs-6">
                    {{ __('passwords.reset_password') }}
                </button>
            </div>
        </div>
    </div>
</form>
