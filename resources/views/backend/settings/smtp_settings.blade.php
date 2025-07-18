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
                            <h2>SMTP Settings </h2>
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
                                        SMTP Settings
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
                            <form action="{{ route('admin.settings.smtp.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-6 mt-1">
                                        <label for="smtp_host" class="mb-1"><strong>Host</strong></label>

                                        <x-input-group :type="'text'" :value="old('smtp_host', getSetting('smtp_host') ?? '')" :name="'smtp_host'"
                                            :placeholder="'Enter host'" :id="'smtp_host'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('smtp_host')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="smtp_port" class="mb-1"><strong>Port</strong></label>

                                        <x-input-group :type="'number'" :value="old('smtp_port', getSetting('smtp_port') ?? '')" :name="'smtp_port'"
                                            :placeholder="'Enter port number'" :id="'smtp_port'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('smtp_port')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="smtp_username"
                                            class="mb-1"><strong>Username</strong></label>

                                        <x-input-group :type="'text'" :value="old('smtp_username', getSetting('smtp_username') ?? '')" :name="'smtp_username'"
                                            :placeholder="'Enter username'" :id="'smtp_username'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('smtp_username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="smtp_password"
                                            class="mb-1"><strong>{{ __('passwords.password') }}</strong></label>

                                        <x-input-group :type="'text'" :value="old('smtp_password', getSetting('smtp_password') ?? '')" :name="'smtp_password'"
                                            :placeholder="'Enter password'" :id="'smtp_password'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('smtp_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <x-input-select :label="'Encryption'" :name="'smtp_encryption'" :id="'smtp_encryption'"
                                            :class="'select2'">
                                            <option value="tls" @selected(old('smtp_encryption', getSetting('smtp_encryption') ?? '') == 'tls')>TLS</option>
                                            <option value="ssl" @selected(old('smtp_encryption', getSetting('smtp_encryption') ?? '') == 'ssl')>SSL</option>
                                        </x-input-select>

                                        @error('smtp_encryption')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="smtp_from_address"
                                            class="mb-1"><strong>From Email Address</strong></label>

                                        <x-input-group :type="'email'" :value="old('smtp_from_address', getSetting('smtp_from_address') ?? '')" :name="'smtp_from_address'"
                                            :placeholder="'Enter from Email  address'" :id="'smtp_from_address'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('smtp_from_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label for="smtp_from_name"
                                            class="mb-1"><strong>From Name</strong></label>

                                        <x-input-group :type="'text'" :value="old('smtp_from_name', getSetting('smtp_from_name') ?? '')" :name="'smtp_from_name'"
                                            :placeholder="'Enter from name'" :id="'smtp_from_name'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('smtp_from_name')
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
