@extends('backend.layouts.app')
@section('title', __('app.users'))
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
                            <h2>{{ __('app.edit_user') }}</h2>
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
                                        <a href="{{ route('admin.users.index') }}">{{ __('app.users') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('app.edit') }}
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
                    <div class="card-style-3">
                        @include('backend.users.partials.edit-form')
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
    $(document).ready(function() {
            // Change Image
            $('#change_image').click(function() {
                $('#image_input').click();
            });

            // Reset Image
            $('#reset_image').click(function() {
                $('#image_input').val('');
                $('#image-preview').attr('src', '{{ asset($user->image) }}');
                $('#image').val('');
            });
        });
</script>

@endpush
