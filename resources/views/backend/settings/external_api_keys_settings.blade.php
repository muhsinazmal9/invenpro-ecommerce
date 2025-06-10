@extends('backend.layouts.app')
@section('title', __('app.external_api_keys_settings'))
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.external_api_keys_settings') }} </h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.dashboard.index') }}">{{ 'Dashboard' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('app.external_api_keys_settings') }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    @include('backend.settings.partials.sidebar')
                </div>
                <div class="col-md-9 mt-3 mt-md-0">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.settings.external-api.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="google_places_api_key"
                                            class="mb-2"><strong>{{ __('app.google_places_api_key') }}</strong></label>
                                        <div class="input-style-1 mb-3">
                                            <input type="password" name="google_places_api_key" id="google_places_api_key"
                                                class="form-control"
                                                value="{{ old('google_places_api_key', getSetting('google_places_api_key') ?? '') }}"
                                                placeholder="{{ __('app.enter_google_places_api_key') }}" />
                                            <span class="mdi mdi-eye fs-5 toggle-password cursor-pointer"
                                                toggle="#google_places_api_key"
                                                style="position: absolute; top: 50%; left: 90%; transform: translateY(-50%);"></span>
                                            @error('google_places_api_key')
                                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>



                                    </div>

                                    <div class="col-md-12">
                                        <x-primary-button :type="'submit'">
                                            {{ __('app.update') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->
@endsection

@push('script')
    <script src="{{ asset('assets/backend/js/toggle-password.js') }}"></script>
@endpush
