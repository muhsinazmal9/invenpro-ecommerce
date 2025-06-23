@extends('backend.layouts.app')
@section('title', 'Create Campaign')
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


        /* Image wrapper size */
        .cr-vp-square {
            width: 488px !important;
            height: 240px !important;
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
                            <h2>Edit</h2>
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
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.campaign.index') }}">Campaigns</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Edit
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
                        <form action="{{ route('admin.campaign.update', $campaign->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label for="title" class="mb-1"><strong>Title</strong></label>
                                    <x-input-group :type="'text'" :value="old('title', $campaign->title)" :name="'title'" :placeholder="'Enter title of campaign'"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="discount"
                                        class="mb-1"><strong>Discount up to</strong></label>
                                    <x-input-group :type="'number'" :value="old('discount', $campaign->discount)" :name="'discount'" :placeholder="'Enter discount of campaign'"
                                        :id="'discount'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <x-input-select :label="'Discount Type'" :name="'discount_type'" :id="'discount_type'"
                                        :value="old('discount', $campaign->discount_type)">

                                        <option value="FIXED" @selected(old('discount_type') == 'FIXED')>Fixed</option>
                                        <option value="PERCENTAGE" @selected(old('discount_type') == 'PERCENTAGE')>
                                            PERCENTAGE
                                        </option>

                                    </x-input-select>

                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="start_date"
                                        class="mb-1"><strong>Start Date</strong></label>
                                    <x-input-group :type="'date'" :value="old('start_date', $campaign->start_date)" :name="'start_date'"
                                        :placeholder="__('app.enter_start_date_of_campaign')" :id="'start_date'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="start_time"
                                        class="mb-1"><strong>Start Time</strong></label>
                                    <x-input-group :type="'time'" :value="old('start_time', $campaign->start_time)" :name="'start_time'"
                                        :placeholder="__('app.enter_start_time')" :id="'start_time'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('start_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="end_date" class="mb-1"><strong>End Date</strong></label>
                                    <x-input-group :type="'date'" :value="old('end_date', $campaign->end_date)" :name="'end_date'"
                                        :placeholder="__('app.enter_end_date_of_campaign')" :id="'end_date'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="end_time" class="mb-1"><strong>End Time</strong></label>
                                    <x-input-group :type="'time'" :value="old('end_time', $campaign->end_time)" :name="'end_time'"
                                        :placeholder="__('app.enter_end_time')" :id="'end_time'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('end_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    <label for="image"
                                        class="mb-1"><strong>Change Image</strong></label>
                                    <div class="image-wrapper border-red-500 cursor-pointer">
                                        <label for="image_input">
                                            <input type="hidden" name="image" id="image"
                                                value="{{ old('image') }}">
                                            <input class="d-none image-crop" type="file" accept="image/*"
                                                name="image_input" id="image_input">
                                            <img id="image-preview" class="img-fluid cursor-pointer"
                                                src="{{ asset($campaign->image) }}" />
                                        </label>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                            id="change_image">
                                            <span class="mdi mdi-file-image"></span>
                                            Change Image
                                        </button>
                                        <button type="button" class="main-btn danger-btn btn-hover btn-sm"
                                            id="reset_image">
                                            <span class="mdi mdi-refresh"></span>
                                            Reset
                                        </button>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    @if ($campaign->status == '1')
                                        <x-success-checkbox :id="'status'" :value="'1'" :name="'status'"
                                            :checked="'status'">
                                            Status
                                        </x-success-checkbox>
                                    @else
                                        <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                                            Status
                                        </x-success-checkbox>
                                    @endif
                                    @error('status')
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
        imageCrop(488, 240);
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
                $('#image-preview').attr('src', '{{ asset($campaign->image) }}');
                $('#image').val('');
            });
        });
    </script>
@endpush
