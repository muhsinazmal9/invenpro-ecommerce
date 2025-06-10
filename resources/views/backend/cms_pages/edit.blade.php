@extends('backend.layouts.app')
@section('title', __('edit_page'))
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
                            <h2>{{ 'Edit Page' }}</h2>
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
                                        <a href="{{ route('admin.pages.index') }}">{{ 'Pages' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Edit' }}
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
                        <form action="{{ route('admin.pages.update', $page->slug) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="mb-1"><strong>{{ 'Title' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('title', $page->title)" :name="'title'" :placeholder="'Enter title of the page'"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="slug" class="mb-1"><strong>{{ 'Slug' }}</strong></label>

                                    <x-input-group :type="'text'" :value="old('slug', $page->slug)" :name="'slug'" :placeholder="'Enter Slug'"
                                        :id="'slug'">
                                        <span class="mdi mdi-format-title"></span>
                                    </x-input-group>

                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="content" class="mb-1"><strong>Content</strong></label>
                                    <textarea name="content" id="summernote" cols="30" rows="10" class="w-100">
                                        {{ old('content', $page->content) }}
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
                                                    class="mb-1"><strong>{{ 'Meta Title' }}</strong></label>
                                                <x-input-group :type="'text'" :name="'meta_title'" :value="old('meta_title', $page->meta_title)"
                                                    :placeholder="'Enter meta title'" :id="'meta_title'">
                                                    <span class="mdi mdi-shape"></span>
                                                </x-input-group>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="meta_description"
                                                    class="mb-1"><strong>{{ 'Meta Description' }}</strong></label>

                                                <x-textarea-group :placeholder="'Meta Description'"
                                                    :name="'meta_description'">{{ old('meta_description', $page->meta_description) }}</x-textarea-group>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 my-2">
                                @if ($page->status)
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
                            <div class="col-md-12 mt-3">
                                <x-primary-button :type="'submit'">
                                    {{ 'Update' }}
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
