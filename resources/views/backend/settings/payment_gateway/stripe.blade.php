@extends('backend.layouts.app')
@section('title', __('app.stripe_settings'))
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.stripe_settings') }} </h2>
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
                                        {{ __('app.stripe_settings') }}
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
                    <ul class="nav nav-pills mb-4" id="paymentGatewayLinksTab">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.settings.payment-gateway.stripe') ? 'active' : '' }}" href="{{ route('admin.settings.payment-gateway.stripe') }}">{{ __('app.stripe') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.settings.payment-gateway.paypal') ? 'active' : '' }}" href="{{ route('admin.settings.payment-gateway.paypal') }}">Paypal</a>
                        </li>
                    </ul>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.settings.payment-gateway.stripe.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-12 mt-1">
                                        <label for="stripe_publishable_key"
                                            class="mb-1"><strong>{{ __('app.publishable_key') }}</strong></label>

                                        <x-input-group :type="'text'" :value="old(
                                            'stripe_publishable_key',
                                            getSetting('stripe_publishable_key') ?? '',
                                        )" :name="'stripe_publishable_key'"
                                            :placeholder="__('app.enter_publishable_key')" :id="'stripe_publishable_key'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('stripe_publishable_key')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <label for="stripe_secret_key"
                                            class="mb-1"><strong>{{ __('app.secret_key') }}</strong></label>

                                        <x-input-group :type="'text'" :value="old('stripe_secret_key', getSetting('stripe_secret_key') ?? '')" :name="'stripe_secret_key'"
                                            :placeholder="__('app.enter_secret_key')" :id="'stripe_secret_key'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('stripe_secret_key')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <x-success-checkbox :id="'stripe_status'" :checked="getSetting('stripe_status') == true ? true : null" :value="'1'"
                                            :name="'stripe_status'">
                                            {{ __('app.status') }}
                                        </x-success-checkbox>
                                        @error('stripe_status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-3">
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
