@extends('backend.layouts.app')
@section('title',(request()->input('type') == 'customers') ? __('app.create_customer') : __('app.create_user'))
@push('css')
<link rel="stylesheet" href="{{ asset('assets/backend/css/image_cropper.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
<style>
    .image-wrapper {
        max-width: 10rem;
        border: 2px dashed #5D657B;
        border-radius: 5px;
        padding: 5px;
        background: #f7f5f5;
    }

    .image-wrapper:hover {
        border: 2px dashed #323743;
    }

    .image-wrapper img {
        width: 100%;
    }

    /* Image wrapper size */
    .cr-vp-square {
        width: 200px !important;
        height: 200px !important;
    }
</style>
@endpush
@section('content')
    <style>
        .image-wrapper {
            max-width: 12rem;
            border: 2px dotted #000;
            padding: 5px;
            background: #f7f5f5;
        }

        .image-wrapper img {
            width: 100%;
        }
    </style>

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ (request()->input('type') == 'customers') ? __('app.create_customer') : __('app.create_user') }}</h2>
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
                                        <a href="{{ route('admin.users.index').((request()->input('type') == 'customers') ? '?type=customers' : '') }}">{{ request()->input('type') == 'customers' ? \App\Models\User::CUSTOMER : \App\Models\User::USER  }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('app.create') }}
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
                        <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label for="fname" class="mb-1"><strong>{{ __('app.first_name') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('fname')" :name="'fname'" :placeholder="__('app.first_name')"
                                        :id="'fname'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('fname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="lname" class="mb-1"><strong>{{ __('app.last_name') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('lname')" :name="'lname'" :placeholder="__('app.last_name')"
                                        :id="'lname'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('lname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="email" class="mb-1"><strong>{{ __('app.email') }}</strong></label>
                                    <x-input-group :type="'email'" :value="old('email')" :name="'email'" :placeholder="__('app.email')"
                                        :id="'email'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="password" class="mb-1"><strong>{{ __('app.password') }}</strong></label>
                                    <div class="input-style-1">
                                        <input type="password" placeholder="{{ __('app.password') }}" name="password" id="password" autocomplete="password"
                                            value="{{ old('password') }}" />
                                        <span class="mdi mdi-eye fs-5 toggle-password cursor-pointer" toggle="#password"
                                            style="position: absolute; top: 50%; left: 95%; transform: translateY(-50%);"></span>
                                        @error('password')
                                        <span class="text-sm text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 my-2">
                                    <label for="password_confirmation"
                                        class="mb-1"><strong>{{ __('passwords.confirm_password') }}</strong></label>
                                    <div class="input-style-1">
                                        <input type="password" placeholder="{{ __('app.confirm_password') }}" name="password_confirmation"
                                            id="password_confirmation" autocomplete="password_confirmation" value="{{ old('password_confirmation') }}" />
                                        <span class="mdi mdi-eye fs-5 toggle-password_confirmation cursor-pointer" toggle="#password_confirmation"
                                            style="position: absolute; top: 50%; left: 95%; transform: translateY(-50%);"></span>
                                        @error('password_confirmation')
                                        <span class="text-sm text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 my-2">
                                    <x-input-select :label="__('app.select_role')" :name="'role'" :id="'role'">
                                        <option value="">{{ __('app.select_role') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" @selected(old('role'))>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach

                                    </x-input-select>

                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    <label for="image" class="mb-1"><strong>{{ __('app.choose_an_image') }}</strong></label>
                                    <div class="image-wrapper border-red-500 cursor-pointer">
                                        <label for="image_input">
                                            <input type="hidden" name="image" id="image" value="{{ old('image') }}">
                                            <input class="d-none image-crop" type="file" accept="image/*" name="image_input" id="image_input">
                                            <img id="image-preview" class="img-fluid cursor-pointer" src="{{ getPlaceholderImage('200', '200') }}"
                                                alt="preview_img" loading="lazy" />
                                        </label>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" class="main-btn primary-btn btn-hover btn-sm" id="choose_image">
                                            <span class="mdi mdi-file-image"></span>
                                            {{ __('app.choose_image') }}
                                        </button>
                                        <button type="button" class="main-btn danger-btn btn-hover btn-sm" id="reset_image">
                                            <span class="mdi mdi-refresh"></span>
                                            {{ __('app.reset') }}
                                        </button>
                                    </div>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2 d-flex align-items-center">
                                    <x-success-checkbox :id="'status'" :value="'ACTIVE'" :name="'status'">
                                        {{ __('app.status') }}
                                    </x-success-checkbox>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        {{ __('app.create') }}
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
    <!-- ========== section end ========== -->
    @include('backend.partials.image_cropper_modal')

@endsection
@push('script')
    <script>
        $("#role_id").select2({
            placeholder: "{{ __('app.select_role') }}",
        });
    </script>
    <script>
        $(".toggle-password").click(function() {
                $(this).toggleClass("mdi-eye mdi-eye-off");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
            $(".toggle-password_confirmation").click(function() {
            $(this).toggleClass("mdi-eye mdi-eye-off");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
            input.attr("type", "text");
            } else {
            input.attr("type", "password");
            }
            });
    </script>
    <script type="module" src="{{ asset('assets/backend/js/image_cropper.js') }}"></script>
    <script type="module">
        import imageCrop from "{{ asset('assets/backend/js/image-cropper.js') }}";
            imageCrop(200, 200);
    </script>
    <script>
        $(document).ready(function() {
                $('#choose_image').click(function() {
                    $('#image_input').click();
                });
                $('#reset_image').click(function() {
                    $('#image-preview').attr('src', "{{ getPlaceholderImage('200', '200') }}");
                    $('#image_input').val('');
                    $('#image').val('');
                });
            })
    </script>
@endpush
