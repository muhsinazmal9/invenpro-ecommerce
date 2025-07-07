@extends('backend.layouts.app')
@section('title', 'Create Product')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/backend/css/image_cropper.css') }}"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
    <style>
        .product-img img {
            width: 100%;
            object-fit: cover;
            border-radius: 1rem;
        }

        .product-img .product-upload-photo {
            position: relative;
            cursor: pointer !important;
        }

        .product-img .product-upload-photo:hover::after {
            position: absolute;
            content: "";
            left: .7rem;
            top: 0;
            width: 86%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 0;
            border-radius: 1rem;
        }

        .product-img .product-upload-photo:hover span {
            display: block !important;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: #FFF;
            font-family: DM Sans;
            font-size: 2rem;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            z-index: 1;
        }

        .cr-vp-square {
            width: 285px !important;
            height: 250px !important;
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
                            <h2>Create Product</h2>
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
                                        <a href="{{ route('admin.products.index') }}">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Create
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
            <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card-style mb-3">
                            @csrf
                            <div class="row">
                                {{-- Title --}}
                                <div class="col-md-12 mt-2">
                                    <label for="title" class="mb-1"><strong>Title</strong></label>
                                    <x-input-group :type="'text'" :value="old('title')" :name="'title'" :placeholder="'Enter title of product'"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Short Description --}}
                                <div class="col-md-12 mt-2">

                                    <label for="short_description"
                                        class="mb-1"><strong>Short Description</strong></label>

                                    <textarea name="short_description" id="short_description" class="form-control" rows="5">{{ old('short_description') }}</textarea>

                                    @error('short_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                
                            </div>

                        </div>
                        <div class="card-style mb-3">
                            <div class="row">
                                {{-- Category --}}

                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="'Select a category'" :name="'category_id'" :id="'category_id'" :class="'select2'">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach

                                    </x-input-select>

                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Subcategory --}}
                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="'Select a subcategory'" :name="'subcategory_id'" :id="'subcategory_id'"
                                        :class="'select2'">
                                        <option value="">Select a subcategory</option>
                                        {{-- Subcategory will apear here when select any category --}}
                                    </x-input-select>

                                    @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Sub Subcategory --}}
                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="'Select a Sub Subcategory'" :name="'subsub_category_id'" :id="'subsub_category_id'"
                                        :class="'select2'">
                                        <option value="">Select a Sub Subcategory</option>
                                        {{-- Subcategory will apear here when select any category --}}
                                    </x-input-select>

                                    @error('subsub_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Brand --}}
                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="'Select a brand'" :name="'brand_id'" :id="'brand_id'"
                                        :class="'select2'">
                                        <option value="">Select a brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                                {{ $brand->title }}
                                            </option>
                                        @endforeach

                                    </x-input-select>

                                    @error('brand_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-style mb-3">
                            <div class="row">
                                {{-- Price  --}}
                                <div class="col-md-6 mt-2">
                                    <label for="price" class="mb-1"><strong>Price</strong></label>
                                    <x-input-group :type="'number'" :step="'any'" :value="old('price')"
                                        :name="'price'" :placeholder="'Enter price'" :id="'price'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Discount  --}}
                                <div class="col-md-6 mt-2">
                                    <label for="discount" class="mb-1"><strong>Discount</strong></label>
                                    <x-input-group :type="'number'" :step="'any'" :value="old('discount')"
                                        :name="'discount'" :placeholder="'Enter discount'" :id="'discount'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Discount Type --}}
                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="'Select discount type'" :name="'discount_type'" :id="'discount_type'">
                                        <option value="">Select discount type</option>

                                        @foreach (App\Models\Product::DISCOUNT_TYPE as $discount)
                                            <option @selected(old('discount_type') == $discount) value="{{ $discount }}">
                                                {{ $discount }}
                                            </option>
                                        @endforeach

                                    </x-input-select>
                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Stock --}}
                                <div class="col-md-6 mt-2">
                                    <label for="stock" class="mb-1"><strong>Stock</strong></label>
                                    <x-input-group :type="'number'" :value="old('stock')" :name="'stock'"
                                        :placeholder="'Enter stock'" :id="'stock'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('stock')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Attributes --}}
                        <div class="card-style mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('backend.products.partials.create_attributes')
                                </div>
                            </div>
                        </div>

                        <div class="card-style mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('backend.products.partials.create_custom_attributes')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="card-style">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image_input" class="mb-1"><strong>Thumbnail</strong></label>
                                        <div class="input-group">
                                            <input type="hidden" id="image" name="thumbnail" value="{{ old('thumbnail') }}">
                                            <input type="file" accept="image/*" id="image_input" class="d-none image-crop">
                                        </div>
                                        <div class="mt-2 p-3 border rounded">
                                            <div class="text-center">
                                                <img src="{{ old('thumbnail') ?? getPlaceholderImage(285, 250) }}" alt="thumbnail" id="image-preview" class="img-fluid w-100">
                                            </div>
    
                                            @error('thumbnail')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            {{--  choose button and reset button --}}
                                            <div class="d-flex mt-3 justify-content-center">
                                                <x-primary-button :id="'thumbnail_image'" :class="'me-2 '" :name="'thumbnail'">
                                                    <span class="mdi mdi-plus-circle" style="font-size: 20px"></span>
                                                    Add
                                                </x-primary-button>
        
                                                <x-danger-button :label="__('app.remove')" :id="'remove_thumbnail'">
                                                    <span class="mdi mdi-reload" style="font-size: 20px"></span>
                                                    Reset
                                                </x-danger-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Multiple Images --}}
                                <div class="col-md-12 mt-3">
                                    {{-- Multiple Images --}}
                                    <div class="multiple-images-wrapper">
                                        <label><strong>Gallery Images</strong></label>
                                        

                                        <div class="border p-3 mt-3 rounded">

                                            <div class="product-img mt-2">
                                                <div class="row g-4 mb-4 " id="images_preview">
                                                    @if (old('image_gallery') != null)
                                                        @foreach (old('image_gallery') as $image)
                                                            <div class="col-4 product-upload-photo">
                                                                <img src="{{ $image }}" alt=""
                                                                    class="output_multiple_image">
                                                                <span onclick="deleteMultipleImageItem(this.parentElement)"
                                                                    class="d-none"><i class="mdi mdi-close"></i>
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="text-center gallery-image-preview-placeholder">
                                                @if (!old('image_gallery'))
                                                    <img class="img-fluid w-100" src="{{ getPlaceholderImage(285, 250) }}" alt="product images">
                                                @endif
                                            </div>
    
                                            <div class="featured_input_wrapper">
                                                <input type="file" multiple id="gallery_images_input" accept="image/*"
                                                    class="d-none">
    
                                                <div id="multiple_images">
                                                    @if (old('image_gallery') != null)
                                                        @foreach (old('image_gallery') as $image)
                                                            <input type="hidden" name="image_gallery[]"
                                                                value="{{ $image }}">
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
    
                                            {{-- Buttons --}}
    
                                            <div class="d-flex mt-3 justify-content-center">
    
                                                <x-primary-button :id="'gallery_image_btn'" :class="'me-2 '">
                                                    <span class="mdi mdi-upload" style="font-size: 20px"></span>
                                                    Choose
                                                </x-primary-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <x-success-checkbox :id="'featured'" :value="'1'" :name="'featured'">
                                        Featured
                                    </x-success-checkbox>

                                </div>
                                <div class="col-md-12 mt-2">
                                    <x-success-checkbox :id="'new_arrival'" :value="'1'" :name="'new_arrival'">
                                        New Arrival
                                    </x-success-checkbox>

                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col">
                                            <x-primary-button :type="'button'" :id="'publish_btn'" :class="'me-2 w-100'">
                                                Publish
                                            </x-primary-button>

                                            <input class="main-btn primary-btn btn-hover btn-sm d-none" type="submit"
                                                name="status" value="PUBLISHED">

                                        </div>
                                        <div class="col">
                                            <x-secondary-button :type="'button'" :id="'draft_btn'"
                                                :class="'me-2 w-100'">
                                                Save as Draft
                                            </x-secondary-button>

                                            <input class="main-btn secondary-btn btn-hover btn-sm d-none"
                                                type="submit" name="status" value="DRAFT">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->
                        </div>
                        <!-- End Card -->
                    </div>
                </div>
            </form>
            <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

    @include('backend.partials.image_cropper_modal')
@endsection

@push('script')
    <script src="{{ asset('assets/backend/js/upload-multiple-images.js') }}"></script>
    <script type="module" src="{{ asset('assets/backend/js/image-cropper.js') }}"></script>
    <script type="module">
        import imageCrop from "{{ asset('assets/backend/js/image-cropper.js') }}";
        imageCrop(285, 250);
    </script>
    <script>
        $(".select2").select2();
        $(document).ready(function() {
            $('#short_description').summernote({
                height: 200,

                toolbar: [
                    // hide font family button
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph', 'style']],
                    ['insert', ['link', 'picture']],
                ]
            });

            $('#thumbnail_image').click(function() {
                $('#image_input').click();
            });

            $('#remove_thumbnail').click(function() {
                $('#image').val('');
                $('#image_input').val('');

                $('#image-preview').attr('src',
                    "{{ getPlaceholderImage(285, 250) }}");
            });

            $('#size_chart_image').click(function() {
                $('#size_chart_image_input').click();
            });

            $('#remove_size_chart').click(function() {
                $('#size_chart_image_input').val('');

                $('#size_chart_preview').attr('src',
                    "{{ asset('assets/backend/images/size-chart.jpg') }}");
            });
            $('#publish_btn').click(function() {
                $('input[name="status"][value="PUBLISHED"]').click();
            });

            $('#draft_btn').click(function() {
                $('input[name="status"][value="DRAFT"]').click();
            });
        });
    </script>

    <script>
        // Subcategory will apear here when select any category
        const subcategories = @json($subcategories);

        $('#category_id').change(function() {
            const category_id = $(this).val();

            // filter subcategories by category_id
            const filtered_subcategories = subcategories.filter(function(subcategory) {
                return subcategory.category_id == category_id;
            });

            const subcategorySelect = $('#subcategory_id');
            subcategorySelect.empty();
            subcategorySelect
                .append('<option value="">Select a subcategory</option>');

            const old_subcategory_id = "{{ old('subcategory_id') }}";

            filtered_subcategories.forEach(subcategory => {

                let isSelected = old_subcategory_id == subcategory.id ? 'selected' : '';

                subcategorySelect.append(
                    `<option ${isSelected} value="${subcategory.id}">${subcategory.title}</option>`);

            });
        });
        $('#category_id').trigger('change');
    </script>
    <script>
        // Sub Subcategory will apear here when select any Subcategory
        const subsubcategories = @json($subsubcategories);

        $('#subcategory_id').change(function() {
            const subcategory_id = $(this).val();

            // filter subcategories by category_id
            const filtered_subsubcategories = subsubcategories.filter(function(subsubcategory) {
                return subsubcategory.subcategory_id == subcategory_id;
            });

            const subsubcategorySelect = $('#subsub_category_id');

            subsubcategorySelect.empty();
            subsubcategorySelect
                .append('<option value="">Select a Sub Subcategory</option>');

            const old_subsub_category_id = "{{ old('subsub_category_id') }}";

            filtered_subsubcategories.forEach(subsubcategory => {

                let isSelected = old_subsub_category_id == subsubcategory.id ? 'selected' : '';

                subsubcategorySelect.append(
                    `<option ${isSelected} value="${subsubcategory.id}">${subsubcategory.title}</option>`
                );

            });
        });
        $('#subcategory_id').trigger('change');
    </script>
    {{-- <script>
        // tagify
        var inputElem = document.querySelector(
            '#tags')


        var tagify = new Tagify(inputElem, {
            whitelist: [
                @foreach ($tags as $tag)
                    '{{ $tag->title }}',
                @endforeach
            ],
            dropdown: {
                classname: "color-blue",
                enabled: 0, // show the dropdown immediately on focus
                maxItems: 5
            }
        })
    </script> --}}

    <script>
        $("#gallery_image_btn").click(function() {
            $("#gallery_images_input").click();
        });


        function deleteMultipleImageItem(imageHtml) {

            // Fade out image html
            $(imageHtml).fadeOut();

            // remove image input
            const imgKey = $(imageHtml).find('img').attr('img-key');
            $(`.${imgKey}`).remove()

            // remove image
            setTimeout(() => {
                imageHtml.remove();
            }, 500);
        }
    </script>
    <script>
        $("#tax_id").select2({
                placeholder: "Select TAX",
            });
    </script>
@endpush
