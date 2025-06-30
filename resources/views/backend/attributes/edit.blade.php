@extends('backend.layouts.app')
@section('title', 'Edit Attribute')
@push('css')
    <style>

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
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
                            <h2>Edit Attribute</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.attributes.index') }}">Attributes</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Edit
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== title-wrapper end ========== -->
            <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="post" id="attributeForm">
                @csrf
                @method('PUT')
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card-style">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="mb-1"><strong>Name</strong></label>
                                    <x-input-group :type="'text'" :value="old('name', $attribute->name)" :name="'name'" :placeholder="'Enter attribute name'"
                                        :id="'name'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="error-message" id="name_error">Name is required</span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="slug" class="mb-1"><strong>Slug</strong></label>
                                    <x-input-group :type="'text'" :value="old('slug', $attribute->slug)" :name="'slug'" :placeholder="'Enter slug'"
                                        :id="'slug'">
                                        <span class="mdi mdi-link"></span>
                                    </x-input-group>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="error-message" id="slug_error">Slug is required and must be unique</span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <x-success-checkbox :id="'is_color'" :value="'1'" :name="'is_color'"
                                        :checked="old('is_color', $attribute->is_color)">
                                        Is Color?
                                    </x-success-checkbox>
                                    @error('is_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <x-success-checkbox :id="'status'" :value="'1'" :name="'status'"
                                        :checked="old('status', $attribute->status)">
                                        Status
                                    </x-success-checkbox>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <x-primary-button :type="'submit'">
                                        Update
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </form>
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/slugify@1.6.6/slugify.min.js"></script>
<script>
$(document).ready(function () {
    $('#name').on('input', function () {
        const input = $(this).val().trim();
        $('#slug').val(input ? slugify(input, { lower: true, strict: true, locale: 'en' }) : '');
    });

    $('#attributeForm').on('submit', validateForm);

    function validateForm(e) {
        let isValid = true;
        const name = $('#name').val().trim();
        const slug = $('#slug').val().trim();

        if (!name) { 
            $('#name_error').show(); 
            isValid = false; 
        } else { 
            $('#name_error').hide(); 
        }
        
        if (!slug || !/^[a-z0-9-]+$/.test(slug)) { 
            $('#slug_error').show(); 
            isValid = false; 
        } else { 
            $('#slug_error').hide(); 
        }

        if (!isValid) e.preventDefault();
    }
});
</script>
@endpush