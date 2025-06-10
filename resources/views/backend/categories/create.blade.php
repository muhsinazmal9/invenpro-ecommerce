@extends('backend.layouts.app')
@section('title', __('app.create_category'))

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
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.create_category') }}</h2>
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
                                        <a href="{{ route('admin.category.index') }}">{{ 'Categories' }}</a>
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
                        <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label for="name" class="mb-1"><strong>{{ __('app.title') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('name')" :name="'name'" :placeholder="__('app.enter_title_of_category')"
                                        :id="'name'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 my-2">
                                    <label for="image"
                                        class="mb-1"><strong>{{ __('app.choose_an_image') }}</strong></label>
                                    <div class="image-wrapper border-red-500 cursor-pointer">
                                        <label for="image_input">
                                            <input type="hidden" name="image" id="image" value="{{ old('image') }}">
                                            <input class="d-none image-crop" type="file" accept="image/*" name="image_input" id="image_input">
                                            <img id="image-preview" class="img-fluid cursor-pointer" src="{{ getPlaceholderImage('200', '200') }}" alt="preview_img" loading="lazy"/>
                                        </label>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                            id="choose_image">
                                            <span class="mdi mdi-file-image"></span>
                                            {{ __('app.choose_image') }}
                                        </button>
                                        <button type="button" class="main-btn danger-btn btn-hover btn-sm"
                                            id="reset_image">
                                            <span class="mdi mdi-refresh"></span>
                                            {{ __('app.reset') }}
                                        </button>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    <x-success-checkbox :id="'show_in_quick_menu'" :value="'1'" :name="'show_in_quick_menu'">
                                        {{ __('app.show_in_quick_menu') }}
                                    </x-success-checkbox>
                                    @error('show_in_quick_menu')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    <x-success-checkbox :id="'show_in_home_page'" :value="'1'" :name="'show_in_home_page'">
                                        {{ __('app.show_in_home_page') }}
                                    </x-success-checkbox>
                                    @error('show_in_home_page')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
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
<script type="module" src="{{ asset('assets/backend/js/image-cropper.js') }}"></script>
    <script type="module">
        import imageCrop from "{{ asset('assets/backend/js/image-cropper.js') }}";
        imageCrop(200, 200);
    </script>
    <script>
        $("#category_id").select2({
            placeholder: "{{ __('app.select_category') }}",
        });

        $(document).ready(function() {
            // Handle image preview
            $('#choose_image').click(function() {
                $('#image').click();
            });
            $('#reset_image').click(function() {
                $('#image-preview').attr('src', '{{ getPlaceholderImage('200', '200') }}');
                $('#image_input').val('');
                $('#image').val('');
            });
        });
    </script>
@endpush

