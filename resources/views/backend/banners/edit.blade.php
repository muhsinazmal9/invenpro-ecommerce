@extends('backend.layouts.app')
@section('title',(request()->input('type') == 'popup') ? __('app.edit_popup') : 'Edit Banner')
@php
    $bannerWidth = 680;
    $bannerHeight = 465;
    if ($banner->width && $banner->height) {
        $bannerWidth = $banner->width;
        $bannerHeight = $banner->height;
    }
@endphp



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
            width: calc({{ $bannerWidth }}px / 3) !important;
            height: calc({{ $bannerHeight }}px / 3) !important;
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
                            @php
                                $type = request()->input('type');
                                $editTitle = $banner->type == \App\Enums\BannerTypeEnum::FIXED->value ? 'Edit' . ' ' . $banner->banner_name : 'Edit Banner';
                                $title = ($type == 'popup') ? __('app.edit_popup') : $editTitle;
                            @endphp

                            <h2>{{ $title }}</h2>
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
                                        @php
                                            $isFixed = $banner->type == \App\Enums\BannerTypeEnum::FIXED->value ? true : false;
                                        @endphp
                                        <a href="{{ $isFixed ? route('admin.banner.fixedBanners') : route('admin.banner.index') }}">{{ 'Banners' }}</a>
                                    </li>
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.banner.index').((request()->input('type') == 'popup') ? '?type=popup' : '') }}">{{
                                            request()->input('type') == 'popup' ? \App\Models\Banner::POPUP : \App\Models\Banner::BANNER }}</a>
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
                        <form action="{{ route('admin.banner.update', $banner->slug) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label for="title" class="mb-1"><strong>{{ 'Title' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('title', $banner->title)" :name="'title'" :placeholder="'Enter title of banner'"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if($banner->type == \App\Enums\BannerTypeEnum::FIXED->value)
                                <!-- short description -->
                                <div class="col-md-6 my-2">
                                    <label for="short_description" class="mb-1"><strong>{{ 'Short Description' }}</strong></label>
                                    <x-textarea-group :placeholder="'Enter short description'" :name="'short_description'" :id="'short_description'">
                                        {{ old('short_description', $banner->short_description) }} </x-textarea-group>
                                    @error('short_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif
                                <div class="col-md-6 my-2">
                                    <label for="link" class="mb-1"><strong>{{ 'Link' }}</strong></label>
                                    <x-input-group :type="'url'" :value="old('link', $banner->link)" :name="'link'" :placeholder="'Enter link of banner'"
                                        :id="'link'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if($banner->type == 'popup')
                                <div class="col-md-6 my-2">
                                    <label for="countdown_start" class="mb-1"><strong>{{ 'Countdown Start' }}</strong></label>
                                    <x-input-group :type="'datetime-local'" :value="old('countdown_start', $banner->countdown_start)" :name="'countdown_start'"
                                        :placeholder="'Enter link of banner'" :id="'countdown_start'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('countdown_start')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="countdown_end" class="mb-1"><strong>{{ 'Countdown End' }}</strong></label>
                                    <x-input-group :type="'datetime-local'" :value="old('countdown_start', $banner->countdown_end)" :name="'countdown_end'"
                                        :placeholder="'Enter link of banner'" :id="'countdown_end'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('countdown_end')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @endif
                                <div class="col-md-12 my-2">

                                    <label for="image"
                                        class="mb-1"><strong>{{ 'Choose an image' }}</strong></label>
                                    <div class="image-wrapper border-red-500 cursor-pointer">
                                        <label for="image_input">
                                            <input type="hidden" name="image" id="image"
                                                value="{{ old('image') }}">
                                            <input class="d-none image-crop" type="file" accept="image/*"
                                                name="image_input" id="image_input">

                                            <img id="image-preview" class="img-fluid cursor-pointer"
                                                src="{{ asset($banner->image) }}" alt="your image" />
                                        </label>
                                        {{-- @if ($banner->position == 'top')
                                                <span class="form-text">H: 490 px - W: 430 px</span>
                                            @elseif ($banner->position == 'bottom')
                                                <span class="form-text">H: 1500 px - W: 430 px</span>
                                            @endif --}}
                                    </div>

                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                            id="change_image">
                                            <span class="mdi mdi-file-image"></span>
                                            {{ 'Change Image' }}
                                        </button>
                                        <button type="button" class="main-btn danger-btn btn-hover btn-sm"
                                            id="reset_image">
                                            <span class="mdi mdi-refresh"></span>
                                            {{ 'Reset' }}
                                        </button>
                                    </div>

                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if ($banner->type != 'fixed')
                                    <div class="col-md-12 my-2">
                                        @if ($banner->status)
                                            <x-success-checkbox :id="'status'" :value="'1'" :name="'status'"
                                                :checked="'status'">
                                                {{ 'Status' }}
                                            </x-success-checkbox>
                                        @else
                                            <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                                                {{ 'Status' }}
                                            </x-success-checkbox>
                                        @endif
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
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
        imageCrop({{ $bannerWidth }}, {{ $bannerHeight }});
    </script>
    <script>
        $(document).ready(function() {
            // Change Image
            $('#change_image').click(function() {
                $('#image_input').click();
            });

            // Reset Image
            $('#reset_image').click(function() {
                $('#image_input').val('');
                $('#image-preview').attr('src', '{{ asset($banner->image) }}');
                $('#image').val('');
            });
        });
    </script>
@endpush
