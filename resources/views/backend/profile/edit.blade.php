@extends('backend.layouts.app')
@section('title', __('app.profile'))
@section('content')

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.profile') }}</h2>
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
                                        {{ __('app.profile') }}
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
                <div class="col-md-12">

                    <div class="card-style mb-30">
                        <h6 class="mb-25">{{ __('app.update_profile_information') }}</h6>
                        @include('backend.profile.partials.update-profile-information-form')
                    </div>

                    <div class="card-style mb-30">
                        <h6 class="mb-25">{{ __('app.update_password') }}</h6>
                        @include('backend.profile.partials.update-password-form')
                    </div>
                    <div class="card-style mb-30">
                        <h6 class="mb-25">{{ __('app.delete_account') }}</h6>
                        @include('backend.profile.partials.delete-user-form')
                    </div>




                    {{-- <div class="py-12"> --}}
                    {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('backend.profile.partials.update-password-form')
                                </div>
                            </div> --}}

                    {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('backend.profile.partials.delete-user-form')
                                </div>
                            </div> --}}
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
