<form action="{{ route('login') }}" method="POST" id="loginForm">
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
            <div class="input-style-1">
                <label>{{ 'Password' }}</label>
                <input type="password" placeholder="{{ 'Password' }}" name="password" id="password" autocomplete="current-password" value="{{ old('password') }}" />
                <span class="mdi mdi-eye fs-5 toggle-password cursor-pointer" toggle="#password" style="position: absolute; top: 50%; left: 90%; transform: translateY(-50%, -50%);"></span>
                @error('password')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-xxl-6 col-lg-12 col-md-6">
            <div class="form-check checkbox-style-1 mb-30">
                <label class="form-check-label" for="remember_me">{{ 'Remember me' }}</label>
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            </div>
        </div>
        <div class="col-xxl-6 col-lg-12 col-md-6">
            <div class="text-start text-md-end text-lg-start text-xxl-end mb-30">
                <a href="{{ route('password.request') }}" class="hover-underline fusionshop-primary">
                    {{ 'Forgot Password ?' }}
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="button-group d-flex justify-content-center flex-wrap">
                <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center fusionshop-primary-bg rounded-md fs-6">
                    {{ 'Log in' }}
                </button>
            </div>
        </div>
    </div>
</form>
