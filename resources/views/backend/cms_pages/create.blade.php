@extends('backend.layouts.app')
@section('title', __('app.create_a_page'))
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
                            <h2>{{ __('app.create_a_page') }}</h2>
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
                                        <a href="{{ route('admin.pages.index') }}">{{ __('app.pages') }}</a>
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
                        <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="mb-1"><strong>{{ __('app.title') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('title')" :name="'title'" :placeholder="__('app.enter_title_of_page')"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="slug" class="mb-1"><strong>{{ __('app.slug') }}</strong></label>

                                    <x-input-group :type="'text'" :value="old('slug')" :name="'slug'" :placeholder="__('app.enter_slug')"
                                        :id="'slug'">
                                        <span class="mdi mdi-format-title"></span>
                                    </x-input-group>

                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="content" class="mb-1"><strong>{{ __('app.content') }}</strong></label>
                                    <textarea name="content" id="summernote" cols="30" rows="10" class="w-100">
                                        {{ old('content') }}
                                    </textarea>
                                </div>

                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror


                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body row">
                                            {{-- <h5 class="card-title">SEO and Metadata</h3> --}}
                                            <div class="col-md-6 mb-2">
                                                <label for="meta_title"
                                                    class="mb-1"><strong>{{ __('app.meta_title') }}</strong></label>
                                                <x-input-group :type="'text'" :name="'meta_title'" :placeholder="__('app.enter_meta_title')"
                                                    :id="'meta_title'" :value="old('meta_title')">
                                                    <span class="mdi mdi-shape"></span>
                                                </x-input-group>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="meta_description"
                                                    class="mb-1"><strong>{{ __('app.meta_description') }}</strong></label>

                                                <x-textarea-group :placeholder="__('app.meta_description')"
                                                    :name="'meta_description'">{{ old('meta_description') }}</x-textarea-group>

                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                        </form>

                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300
            });
        });

        $('#title').keyup(function() {
            const title = $(this).val();
            slugGenerator(title, 'slug');
        });
        $('#slug').change(function() {
            const title = $(this).val();
            slugGenerator(title, 'slug');
        });

        function slugGenerator(_this, id) {
            const slug = _this.trim().toLowerCase().replace(/[^a-zA-Z0-9]+/g, '-').replace(/-$/, '');
            $(`#${id}`).val(slug);
        }
    </script>
@endpush
