@extends('backend.layouts.app')

@section('title', __('app.edit_address'))

@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.edit_address') }}</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.dashboard.index') }}">{{ __('app.dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.users.index') }}?type=customers">{{ __('app.customers') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('app.edit_address') }}
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
                    <div class="card-style">
                        <form action="{{ route('admin.addresses.update', $address->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <label for="title" class="mb-1"><strong>{{ __('app.title') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('title', $address->title)" :name="'title'" :placeholder="__('app.title')"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="customer_name" class="mb-1"><strong>{{ __('app.customer_name') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('customer_name', $address->customer_name)" :name="'customer_name'" :placeholder="__('app.customer_name')"
                                        :id="'customer_name'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="email" class="mb-1"><strong>{{ __('app.email') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('email', $address->email)" :name="'email'" :placeholder="__('app.email')"
                                        :id="'email'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="phone" class="mb-1"><strong>{{ __('app.phone') }}</strong></label>
                                    <x-input-group :type="'tel'" :value="old('phone', $address->phone)" :name="'phone'" :placeholder="__('app.phone')"
                                        :id="'phone'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="col-md-6 my-2">
                                    <label for="street_address" class="mb-1"><strong>{{ __('app.street_address') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('street_address', $address->street_address)" :name="'street_address'" :placeholder="__('app.street_address')"
                                        :id="'street_address'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('street_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="apt_or_floor" class="mb-1"><strong>{{ __('app.apt_floor_suite_etc') }}</strong></label>
                                    <x-input-group :type="'apt_or_floor'" :value="old('apt_or_floor', $address->apt_or_floor)" :name="'apt_or_floor'" :placeholder="__('app.apt_floor_suite_etc')" :id="'apt_or_floor'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('apt_or_floor')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="zip_code" class="mb-1"><strong>{{ __('app.zip_code') }}</strong></label>
                                    <x-input-group :type="'zip_code'" :value="old('zip_code', $address->zip_code)" :name="'zip_code'" :placeholder="__('app.zip_code')" :id="'zip_code'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('zip_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="city" class="mb-1"><strong>{{ __('app.city') }}</strong></label>
                                    <x-input-group :type="'city'" :value="old('city', $address->city)" :name="'city'" :placeholder="__('app.city')" :id="'city'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="country" class="mb-1"><strong>{{ __('app.country') }}</strong></label>
                                    <x-input-group :type="'country'" :value="old('country', $address->country)" :name="'country'" :placeholder="__('app.country')" :id="'country'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="coordinate" class="mb-1"><strong>{{ __('app.coordinate') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('coordinate', $address->coordinate)" :name="'coordinate'" :placeholder="__('app.coordinate')"
                                        :id="'coordinate'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('coordinate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <x-input-select :label="__('app.select_type')" :name="'type'" :id="'type'">
                                        <option value="">{{ __('app.select_type') }}</option>

                                        @foreach (array_keys(\App\Models\Address::TYPE) as $type)
                                            <option @selected(old('type', $address->type) == \App\Models\Address::TYPE[$type]) value="{{ \App\Models\Address::TYPE[$type] }}">{{ ucwords($type) }}</option>
                                        @endforeach

                                    </x-input-select>

                                    @error('type')
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
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>

@endsection
