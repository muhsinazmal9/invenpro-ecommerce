@extends('backend.layouts.app')
@section('title', __('app.business_settings'))
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.business_settings') }} </h2>
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
                                        {{ __('app.business_settings') }}
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
                            <form action="{{ route('admin.settings.business.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-12 mt-1">
                                        <label for="email" class="mb-1"><strong>{{ __('app.email') }}</strong></label>

                                        <x-input-group :type="'email'" :value="old('email', getSetting('email') ?? '')" :name="'email'"
                                            :placeholder="__('app.enter_email_address')" :id="'email'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="business_description"
                                            class="mb-1"><strong>{{ __('app.business_description') }}</strong></label>

                                            <x-textarea-group :placeholder="__('app.business_description')"
                                            :name="'business_description'">{{ old('business_description') }}</x-textarea-group>

                                        @error('business_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="phone_1"
                                            class="mb-1"><strong>{{ __('app.phone_1') }}</strong></label>

                                        <x-input-group :type="'number'" :value="old('phone_1', getSetting('phone_1') ?? '')" :name="'phone_1'"
                                            :placeholder="__('app.enter_phone_number')" :id="'phone_1'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('phone_1')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="phone_2"
                                            class="mb-1"><strong>{{ __('app.phone_2') }}</strong></label>

                                        <x-input-group :type="'number'" :value="old('phone_2', getSetting('phone_2') ?? '')" :name="'phone_2'"
                                            :placeholder="__('app.enter_phone_number')" :id="'phone_2'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('phone_2')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="phone_3"
                                            class="mb-1"><strong>{{ __('app.phone_3') }}</strong></label>

                                        <x-input-group :type="'number'" :value="old('phone_3', getSetting('phone_3') ?? '')" :name="'phone_3'"
                                            :placeholder="__('app.enter_phone_number')" :id="'phone_3'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('phone_3')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="address"
                                            class="mb-1"><strong>{{ __('app.full_address') }}</strong></label>

                                        <x-input-group :type="'text'" :value="old('address', getSetting('address') ?? '')" :name="'address'"
                                            :placeholder="__('app.enter_address')" :id="'address'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="latitude"
                                            class="mb-1"><strong>{{ __('app.latitude') }}</strong></label>

                                        <x-input-group :step="0.00000000001" :type="'number'" :value="old('latitude', getSetting('latitude') ?? '')"
                                            :name="'latitude'" :placeholder="__('app.enter_latitude')" :id="'latitude'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('latitude')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="longitude"
                                            class="mb-1"><strong>{{ __('app.longitude') }}</strong></label>

                                        <x-input-group :step="0.00000000001" :type="'number'" :value="old('longitude', getSetting('longitude') ?? '')"
                                            :name="'longitude'" :placeholder="__('app.enter_longitude')" :id="'longitude'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('longitude')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="country_id"
                                            class="mb-1"><strong>{{ __('app.country') }}</strong></label>
                                        <x-input-select :name="'country_id'" :id="'country_id'" :class="'select2'">
                                            <option value="">{{ __('app.select_country') }}</option>
                                            @foreach (json_decode($countries_json) as $country)
                                                <option value="{{ $country->id }}" @selected(old('country_id', getSetting('country_id')) == $country->id)>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </x-input-select>

                                        @error('country_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="state_id" class="mb-1"><strong>{{ __('app.state') }}</strong></label>

                                        <x-input-select :name="'state_id'" :id="'state_id'" :class="'select2'">
                                            <option value="">{{ __('app.select_state') }}</option>
                                        </x-input-select>

                                        @error('state_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="city_id" class="mb-1"><strong>{{ __('app.city') }}</strong></label>

                                        <x-input-select :value="old('city_id', getSetting('city_id') ?? '')" :name="'city_id'" :id="'city_id'"
                                            :class="'select2'">
                                            <option value="">{{ __('app.select_city') }}</option>
                                        </x-input-select>

                                        @error('city_id')
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
        $('#country_id, #state_id, #city_id').select2();

        const country_id = $('#country_id');
        const state_id = $('#state_id');
        const city_id = $('#city_id');

        $(document).ready(function() {
            getStates(country_id);
            setTimeout(() => {
                getCities(state_id)
            }, 1000);

            $(country_id).on('change', function() {
                if ($(this).val()) {
                    $(state_id).empty();
                    $(state_id).append(`<option value="">{{ __('app.select_state') }}</option>`);
                    $(city_id).empty();
                    $(city_id).append(`<option value="">{{ __('app.select_city') }}</option>`);
                    getStates(country_id)
                }
            });

            $(state_id).on('change', function() {
                if ($(this).val()) {
                    $(city_id).empty();
                    $(city_id).append(`<option value="">{{ __('app.select_city') }}</option>`);
                    getCities(state_id)
                }
            });
        });

        function getStates(country_id) {
            let url = "{{ route('admin.settings.get.states', ':country_id') }}";
            url = url.replace(':country_id', country_id.val());
            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        let isSelected = '{{ getSetting('state_id') }}' == key ? 'selected' : '';
                        $(state_id).append(
                            `<option value="${key}" ${isSelected}>${value}</option>`
                        );
                    });
                }
            })

        }

        function getCities(state_id) {
            const city_id = $('#city_id');
            let url = "{{ route('admin.settings.get.cities', ':state_id') }}";
            url = url.replace(':state_id', state_id.val());
            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        let isSelected = '{{ getSetting('city_id') }}' == key ? 'selected' : '';
                        $(city_id).append(
                            `<option value="${key}" ${isSelected}>${value}</option>`
                        );
                    });
                }
            })
        }
    </script>
@endpush
