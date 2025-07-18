@extends('backend.layouts.app')
@section('title', 'Site Settings')
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>Site Settings </h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Site Settings
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
                            <form action="{{ route('admin.settings.site.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-6 mt-1">
                                        <label for="site_title"
                                            class="mb-1"><strong>Site Title</strong></label>

                                        <x-input-group :type="'text'" :value="old('site_title', getSetting('site_title') ?? '')" :name="'site_title'"
                                            :placeholder="'Enter site title'" :id="'site_title'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('site_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-6 mt-1">

                                        <label for="frontend_url"
                                            class="mb-1"><strong>Frontend URL</strong></label>

                                        <x-input-group :type="'url'" :value="old('frontend_url', getSetting('frontend_url') ?? '')" :name="'frontend_url'"
                                            :placeholder="'Enter frontend URL'" :id="'frontend_url'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('frontend_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div> --}}
                                    <div class="col-md-6 mt-1">
                                        <x-input-select :label="'Phone Code'" :name="'default_phone_code'" :id="'default_phone_code'"
                                            :class="'select2'">
                                            @php 
                                            $getSetting = getSetting('default_phone_code') ?? '';
                                            @endphp
                                            @foreach ($phoneCodes as $phoneCode)
                                                <option value="{{ $phoneCode->dial_code }}" @selected(old('default_phone_code', $getSetting) == $phoneCode->dial_code)>
                                                    {{ $phoneCode->dial_code }} ({{ $phoneCode->code }})
                                                </option>
                                            @endforeach

                                        </x-input-select>

                                        @error('default_phone_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <x-input-select :label="'Default Language'" :name="'default_language'" :id="'default_language'"
                                            :class="'select2'">
                                            <option value="en" @selected(old('default_language', getSetting('default_language') ?? '') == 'en')>en</option>
                                        </x-input-select>

                                        @error('default_language')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <x-input-select :label="'Default Currency'" :name="'default_currency'" :id="'default_currency'"
                                            :class="'select2'">
                                            @php
                                                $getSettingCurrency = getSetting('default_currency') ?? '';
                                            @endphp

                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->cc }}" @selected(old('default_currency', $getSettingCurrency) == $currency->cc)>
                                                    {{ $currency->cc }}</option>
                                            @endforeach


                                        </x-input-select>

                                        @error('default_currency')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="currency_symbol"
                                            class="mb-1"><strong>Currency Symbol</strong></label>

                                        <x-input-group :type="'text'" :value="old('currency_symbol', getSetting('currency_symbol') ?? '')" :name="'currency_symbol'"
                                            :placeholder="'Enter currency symbol'" :id="'currency_symbol'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('currency_symbol')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <x-input-select :label="'Timezone'" :name="'timezone'" :id="'timezone'"
                                            :class="'select2'">
                                            @php
                                                $getSettingTimezone = getSetting('timezone') ?? '';
                                            @endphp
                                            @foreach ($timezones as $timezone)
                                                <option value="{{ $timezone->abbr }}" @selected(old('timezone', $getSettingTimezone) == $timezone->abbr)>
                                                    {{ $timezone->value }} ({{ $timezone->abbr }})</option>
                                            @endforeach
                                        </x-input-select>
                                        @error('timezone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="copy_right_text" class="mb-1"><strong>Copy Right Text</strong></label>

                                        <x-input-group :type="'text'" :value="old('copy_right_text', getSetting('copy_right_text') ?? '')" :name="'copy_right_text'"
                                            :placeholder="'Enter copy right text'" :id="'copy_right_text'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('copy_right_text')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <x-primary-button :type="'submit'">
                                            Update
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
