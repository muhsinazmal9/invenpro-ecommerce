@extends('layouts.main')

@section('title', __('auth.login'))

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0 h-100 d-flex" style="min-height: 100vh;">
            <div class="col-lg-7 d-none d-md-block">
                <div class="auth-cover-wrapper bg-primary-auth-shade">
                    <div class="auth-cover">
                        <div class="cover-image">
                            <img src="{{ asset('assets/backend/images/auth/login-illustration.svg') }}" alt="login-illustration.svg" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-flex">
                <div class="signin-wrapper">
                    <div class="form-wrapper">
                        <div class="text-center">
                            <div class="mb-60">
                                <img class="img-fluid" src="{{ asset(getSetting(App\Models\Settings::PRIMARY_LOGO)) }}" alt="primary_logo" loading="lazy">
                            </div>
                            <h2 class="mb-3 fusionshop-primary fw-bold text-uppercase">{{ __('auth.admin_panel') }}</h6>
                            <p class="text-sm mb-25">{{ __('auth.welcome_back_login_to_your_panel') }}</p>
                        </div>
                        @include('auth.partials.login_form')
                        @env('local')
                            <div class="mt-40">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>
                                            {{ __('auth.email') }} : <span class="fw-bold" id="admin_email">admin@gmail.com</span>
                                        </p>
                                        <p>
                                            {{ __('auth.password') }} : <span class="fw-bold" id="admin_password">admin</span>
                                        </p>
                                    </div>
                                    <button class="btn btn-sm btn-light" onclick="giveCredentials()">
                                        <i class="mdi mdi-content-copy"></i>
                                    </button>
                                </div>
                            </div>
                        @endenv
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function giveCredentials() {
            let email = $("#admin_email").text();
            let password = $("#admin_password").text();
            $("#email").val(email);
            $("#password").val(password);

            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            Toast.fire({
                icon: 'success',
                title: 'Credentials copied successfully'
            })
        }
    </script>

@endpush
