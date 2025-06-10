@extends('backend.layouts.app')
@section('title', 'Logo and Favicon Settings')
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ 'Logo and Favicon Settings' }} </h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.dashboard.index') }}">{{ 'Dashboard' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Logo and Favicon Settings' }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->
            <div class="row">
                <div class="col-md-3">
                    @include('backend.settings.partials.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.settings.logo.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">

                                    <div class="col-md-12 mt-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="primary_logo" class="mb-1">
                                                    <strong>{{ 'Primary Logo' }}</strong>
                                                </label>

                                                <div class="input-style-3 row align-items-center">
                                                    <div class="col-10">
                                                        <input
                                                            onchange=
                                                                "document.getElementById('primary_logo-preview').src =
                                                                window.URL.createObjectURL(this.files[0])"
                                                            type="file" id="primary_logo" name="primary_logo"
                                                            accept=image/*>
                                                    </div>
                                                    <div class="col-2">
                                                        <img class="w-100" id="primary_logo-preview"
                                                            src="{{ getSetting(App\Models\Settings::PRIMARY_LOGO) != '' ? asset(getSetting(App\Models\Settings::PRIMARY_LOGO)) : asset('assets/backend/images/placeholder.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>

                                                @error('primary_logo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="secondary_logo" class="mb-1">
                                                    <strong>{{ 'Secondary Logo' }}</strong>
                                                </label>

                                                <div class="input-style-3 row align-items-center">
                                                    <div class="col-10">
                                                        <input
                                                            onchange=
                                                                "document.getElementById('secondary_logo-preview').src =
                                                                window.URL.createObjectURL(this.files[0])"
                                                            type="file" id="secondary_logo" name="secondary_logo"
                                                            accept=image/*>
                                                    </div>
                                                    <div class="col-2">
                                                        <img class="w-100" id="secondary_logo-preview"
                                                            src="{{ getSetting(App\Models\Settings::SECONDARY_LOGO) != '' ? asset(getSetting(App\Models\Settings::SECONDARY_LOGO)) : asset('assets/backend/images/placeholder.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>

                                                @error('secondary_logo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="favicon"class="mb-1">
                                                    <strong>{{ 'Favicon' }}</strong>
                                                </label>

                                                <div class="input-style-3 row align-items-center">
                                                    <div class="col-10">
                                                        <input type="file"
                                                            onchange=
                                                                "document.getElementById('favicon-preview').src =
                                                                window.URL.createObjectURL(this.files[0])"
                                                            id="favicon" name="favicon" accept=image/*>
                                                    </div>
                                                    <div class="col-2">
                                                        <img class="w-100" id="favicon-preview"
                                                            src="{{ getSetting(App\Models\Settings::FAVICON) != '' ? asset(getSetting(App\Models\Settings::FAVICON)) : asset('assets/backend/images/placeholder.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                @error('favicon')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-12 mt-3">
                                        <x-primary-button :type="'submit'">
                                            {{ 'Update' }}
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
