@extends('backend.layouts.app')

@section('title', 'Add address')

@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ 'Create Address' }}</h2>
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
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.users.index') }}">{{ 'Users' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Address' }}
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
                        <form action="{{ route('admin.addresses.store',$user->username) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <label for="title" class="mb-1"><strong>{{ 'Title' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('title')" :name="'title'" :placeholder="'Title'"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="customer_name" class="mb-1"><strong>{{ 'Customer Name' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('customer_name')" :name="'customer_name'" :placeholder="'Customer Name'"
                                        :id="'customer_name'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="email" class="mb-1"><strong>{{ 'Email' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('email')" :name="'email'" :placeholder="'Email'"
                                        :id="'email'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="phone" class="mb-1"><strong>{{ 'Phone' }}</strong></label>
                                    <x-input-group :type="'tel'" :value="old('phone')" :name="'phone'" :placeholder="'Phone'"
                                        :id="'phone'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="col-md-6 my-2">
                                    <label for="street_address" class="mb-1"><strong>{{ 'Street Address' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('street_address')" :name="'street_address'" :placeholder="'Street Address'"
                                        :id="'street_address'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('street_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="apt_or_floor" class="mb-1"><strong>{{ 'Apt, Floor, Suite, etc.' }}</strong></label>
                                    <x-input-group :type="'apt_or_floor'" :value="old('apt_or_floor')" :name="'apt_or_floor'" :placeholder="'Apt, Floor, Suite, etc.'" :id="'apt_or_floor'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('apt_or_floor')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="zip_code" class="mb-1"><strong>{{ 'Zip Code' }}</strong></label>
                                    <x-input-group :type="'zip_code'" :value="old('zip_code')" :name="'zip_code'" :placeholder="'Zip Code'" :id="'zip_code'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('zip_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="city" class="mb-1"><strong>{{ 'City' }}</strong></label>
                                    <x-input-group :type="'city'" :value="old('city')" :name="'city'" :placeholder="'City'" :id="'city'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="country" class="mb-1"><strong>{{ 'Country' }}</strong></label>
                                    <x-input-group :type="'country'" :value="old('country')" :name="'country'" :placeholder="'Country'" :id="'country'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="coordinate" class="mb-1"><strong>{{ 'Coordinate' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('coordinate')" :name="'coordinate'" :placeholder="'Coordinate'"
                                        :id="'coordinate'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('coordinate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <x-input-select :label="'Select Type'" :name="'type'" :id="'type'">
                                        <option value="">{{ 'Select Type' }}</option>

                                        @foreach (array_keys(\App\Models\Address::TYPE) as $type)
                                            <option @selected(old('type') == \App\Models\Address::TYPE[$type]) value="{{ \App\Models\Address::TYPE[$type] }}">{{ ucwords($type) }}</option>
                                        @endforeach

                                    </x-input-select>

                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        {{ 'Create' }}
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
