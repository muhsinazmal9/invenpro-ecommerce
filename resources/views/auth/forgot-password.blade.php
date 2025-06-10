@extends('layouts.main')

@section('title', 'Reset Password')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0 h-100 d-flex" style="min-height: 100vh;">
            <div class="col-lg-7 d-none d-md-block">
                <div class="auth-cover-wrapper bg-primary-auth-shade">
                    <div class="auth-cover">
                        <div class="cover-image">
                            <img src="{{ asset('assets/backend/images/auth/reset_password_illustration.svg') }}"
                                alt="login-illustration.svg" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-flex">
                <div class="signin-wrapper">
                    <div class="form-wrapper">
                        <div class="text-center">
                            <div class="mb-60">
                                <img class="img-fluid" src="{{ asset(getSetting(App\Models\Settings::PRIMARY_LOGO)) }}" alt="primary_logo"
                                    loading="lazy">
                            </div>
                            <h2 class="mb-5 fusionshop-primary fw-bold text-uppercase">{{ 'Reset Password' }}</h6>
                        </div>

                        @include('auth.partials.forgot_password_form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @session('status')
            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            Toast.fire({
                icon: 'success',
                title: '{{ $value }}'
            });
        @endsession
    </script>
@endpush
