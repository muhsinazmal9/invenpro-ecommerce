@extends('backend.layouts.app')
@section('title', 'Create FAQ')
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
                            <h2>{{ 'Create FAQ' }}</h2>
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
                                        <a href="{{ route('admin.faq.index') }}">{{ 'FAQs' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Create' }}
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
                        <form action="{{ route('admin.faq.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label for="question" class="mb-1"><strong>{{ 'Question' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('question')" :name="'question'" :placeholder="'Question'" {{-- :id="'question'" --}}>
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('question')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <x-input-select :label="'Select Category'" :name="'category_id'" :id="'category_id'">
                                        <option value="">{{ 'Select Category' }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id'))>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach

                                    </x-input-select>

                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 my-2">
                                    <label for="answer" class="mb-1"><strong>{{ 'Answer' }}</strong></label>
                                    <x-textarea-group :placeholder="'Answer'" :name="'answer'">
                                        {{ old('answer') }}
                                    </x-textarea-group>

                                    @error('answer')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 my-2">
                                    <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                                        {{ 'Status' }}
                                    </x-success-checkbox>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        {{ 'Create' }}
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

@endsection
@push('script')
    <script>
        $("#category_id").select2({
            placeholder: "{{ 'Select Category' }}",
        });
    </script>
@endpush
