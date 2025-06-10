@extends('backend.layouts.app')
@section('title', 'Business Settings')
@section('content')
<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">

        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="title">
                        <h2>{{ 'Authentication settings' }} </h2>
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
                                    {{ 'Authentication settings' }}
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
                        <form action="{{ route('admin.settings.authentication.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-md-6 mt-1">
                                    <label for="otp_validation_time" class="mb-1"><strong>{{ 'OTP Expiry time (Min)'
                                            }}</strong></label>

                                    <x-input-group :type="'text'"
                                        :value="old('otp_validation_time', getSetting('otp_validation_time') ?? '')"
                                        :name="'otp_validation_time'" :placeholder="'OTP Validation time'"
                                        :id="'otp_validation_time'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('otp_validation_time')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6 mt-1">
                                    <label for="default_avatar" class="mb-1"><strong>{{ 'Default Avatar'}}</strong></label>

                                    <div class="input-style-3 row align-items-center">
                                        <div class="col-10">
                                            <input
                                                onchange=
                                                    "document.getElementById('default_avatar-preview').src =
                                                    window.URL.createObjectURL(this.files[0])"
                                                type="file" id="default_avatar" name="default_avatar"
                                                accept=image/*>
                                        </div>
                                        <div class="col-2">
                                            <img class="w-100" id="default_avatar-preview"
                                                src="{{ getSetting(App\Models\Settings::DEFAULT_AVATAR) != '' ? asset(getSetting(App\Models\Settings::DEFAULT_AVATAR)) : asset('assets/backend/images/placeholder.jpg') }}"
                                                alt="">
                                        </div>
                                    </div>

                                    @error('default_avatar')
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

@push('script')
<script>
    $(document).ready(function() {
            $('.select2').select2();
        });
</script>
@endpush
