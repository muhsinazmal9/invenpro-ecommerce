@extends('backend.layouts.app')
@section('title', 'Charges Settings')
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ 'Charges Settings' }} </h2>
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
                                        {{ 'Charges Settings' }}
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
                            <form action="{{ route('admin.settings.charges.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="shipping_charge"
                                            class="mb-1"><strong>{{ 'Shipping Charge' }}</strong></label>

                                        <x-input-group :type="'number'" :step="0.01" :value="old(
                                            'shipping_charge',
                                            getSetting('shipping_charge') ?? '',
                                        )"
                                            :name="'shipping_charge'" :placeholder="'Enter shipping charge'" :id="'shipping_charge'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('shipping_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <label for="gift_wrapping_charge"
                                            class="mb-1"><strong>{{ 'Gift Wrapping Charge' }}</strong></label>

                                        <x-input-group :type="'number'" :step="0.01" :value="old(
                                            'gift_wrapping_charge',
                                            getSetting('gift_wrapping_charge') ?? '',
                                        )"
                                            :name="'gift_wrapping_charge'" :placeholder="'Enter Gift Wrapping Charge'" :id="'gift_wrapping_charge'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('gift_wrapping_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6">
                                        <label for="service_charge" class="mb-1"><strong>{{ 'Service Charge' }}</strong></label>

                                        <x-input-group :type="'number'" :step="0.01" :value="old(
                                                                                'service_charge',
                                                                                getSetting('service_charge') ?? '',
                                                                            )" :name="'service_charge'" :placeholder="'Enter service charge'"
                                            :id="'service_charge'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('service_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

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
