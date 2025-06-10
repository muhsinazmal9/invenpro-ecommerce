@extends('backend.layouts.app')
@section('title',(request()->input('type') == 'popup') ? __('app.create_popup') : __('app.create_banner'))
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/backend/css/image_cropper.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
    <style>
        .image-wrapper {
            max-width: 12rem;
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
        .cr-vp-square {
            width: calc(680px / 3) !important;
            height: calc(465px / 3) !important;
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
                            <h2>{{ (request()->input('type') == 'popup') ? __('app.create_popup') : __('app.create_banner') }}</h2>
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
                                        <a href="{{ route('admin.banner.index').((request()->input('type') == 'popup') ? '?type=popup' : '') }}">{{
                                            request()->input('type') == 'popup' ? \App\Models\Banner::POPUP : \App\Models\Banner::BANNER }}</a>
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
                            <form action="{{ route('admin.banner.store') }}"
                            method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <label for="title" class="mb-1"><strong>{{ __('app.title') }}</strong></label>
                                        <x-input-group :type="'text'" :value="old('title')" :name="'title'" :placeholder="__('app.enter_title_of_banner')" :id="'title'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <label for="link" class="mb-1"><strong>{{ __('app.link') }}</strong></label>
                                        <x-input-group :type="'url'" :value="old('link')" :name="'link'" :placeholder="__('app.enter_link_of_banner')" :id="'link'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>
                                        @error('link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if(request()->input('type') == 'popup')
                                    <div class="col-md-6 my-2">
                                        <label for="countdown_start" class="mb-1"><strong>{{ __('app.countdown_start') }}</strong></label>
                                        <x-input-group :type="'datetime-local'" :value="old('countdown_start')" :name="'countdown_start'" :placeholder="__('app.enter_countdown_start_of_banner')"
                                            :id="'countdown_start'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>
                                        @error('countdown_start')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="countdown_end" class="mb-1"><strong>{{ __('app.countdown_end') }}</strong></label>
                                        <x-input-group :type="'datetime-local'" :value="old('countdown_end')" :name="'countdown_end'" :placeholder="__('app.enter_countdown_end_of_banner')"
                                            :id="'countdown_end'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>
                                        @error('countdown_end')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="type" value="{{ request()->input('type') }}" />
                                    @endif


                                    <div class="col-md-12 my-2">

                                        <label for="image" class="mb-1"><strong>{{ __('app.choose_an_image') }}</strong></label>
                                        <div class="image-wrapper border-red-500 cursor-pointer">
                                            <label for="image_input">
                                                <input type="hidden" name="image" id="image"
                                                    value="{{ old('image') }}">
                                                <input class="d-none image-crop" type="file" accept="image/*"
                                                    name="image_input" id="image_input">

                                                <img id="image-preview" class="img-fluid cursor-pointer"
                                                    src="{{ getPlaceholderImage(680, 465) }}"
                                                    alt="your image" />
                                            </label>
                                        </div>
                                        <div class="d-flex gap-2 mt-2">
                                            <button type="button" class="main-btn primary-btn btn-hover btn-sm" id="choose_image">
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
    <script type="module" src="{{ asset('assets/backend/js/image_cropper.js') }}"></script>
    <script type="module">
        import imageCrop from "{{ asset('assets/backend/js/image-cropper.js') }}";
        imageCrop(680, 465);
    </script>
    <script>
        $(document).ready(function() {
            $('#choose_image').click(function() {
                $('#image_input').click();
            });
            $('#reset_image').click(function() {
                $('#image-preview').attr('src', "{{ getPlaceholderImage(680, 465) }}");
                $('#image_input').val('');
                $('#image').val('');
            });
        })
    </script>
@endpush
