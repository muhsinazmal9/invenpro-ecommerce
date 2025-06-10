@extends('backend.layouts.app')
@section('title', __('app.create_product'))

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
                            <h2>{{ __('app.create_product') }}</h2>
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
                                        <a href="{{ route('admin.products.index') }}">{{ __('app.products') }}</a>
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
            <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card-style">
                            @csrf
                            <div class="row">
                                {{-- Title --}}
                                <div class="col-md-12 mt-2">
                                    <label for="title" class="mb-1"><strong>{{ __('app.title') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('title')" :name="'title'" :placeholder="__('app.enter_title_of_product')"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Category --}}

                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="__('app.select_a_category')" :name="'category_id'" :id="'category_id'" :class="'select2'">
                                        <option value="">{{ __('app.select_a_category') }}</option>
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
                                    <x-input-select :label="__('app.select_a_subcategory')" :name="'subcategory_id'" :id="'subcategory_id'"
                                        :class="'select2'">
                                        <option value="">{{ __('app.select_a_subcategory') }}</option>
                                        {{-- Subcategory will apear here when select any category --}}
                                    </x-input-select>

                                    @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Sub Subcategory --}}
                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="__('app.select_a_sub_subcategory')" :name="'subsub_category_id'" :id="'subsub_category_id'"
                                        :class="'select2'">
                                        <option value="">{{ __('app.select_a_sub_subcategory') }}</option>
                                        {{-- Subcategory will apear here when select any category --}}
                                    </x-input-select>

                                    @error('subsub_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Brand --}}
                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="__('app.select_a_brand')" :name="'brand_id'" :id="'brand_id'"
                                        :class="'select2'">
                                        <option value="">{{ __('app.select_a_brand') }}</option>
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

                                {{-- SKU --}}
                                <div class="col-md-6 mt-2">
                                    <label for="sku" class="mb-1"><strong>{{ __('app.sku') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('sku')" :name="'sku'"
                                        :placeholder="__('app.enter_sku')" :id="'sku'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('sku')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Stock --}}
                                <div class="col-md-6 mt-2">
                                    <label for="stock" class="mb-1"><strong>{{ __('app.stock') }}</strong></label>
                                    <x-input-group :type="'number'" :value="old('stock')" :name="'stock'"
                                        :placeholder="__('app.enter_stock')" :id="'stock'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('stock')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Price  --}}
                                <div class="col-md-6 mt-2">
                                    <label for="price" class="mb-1"><strong>{{ __('app.price') }}</strong></label>
                                    <x-input-group :type="'number'" :step="'any'" :value="old('price')"
                                        :name="'price'" :placeholder="__('app.enter_price')" :id="'price'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Discount  --}}
                                <div class="col-md-6 mt-2">
                                    <label for="discount" class="mb-1"><strong>{{ __('app.discount') }}</strong></label>
                                    <x-input-group :type="'number'" :step="'any'" :value="old('discount')"
                                        :name="'discount'" :placeholder="__('app.enter_discount')" :id="'discount'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Discount Type --}}
                                <div class="col-md-6 mt-2">
                                    <x-input-select :label="__('app.select_discount_type')" :name="'discount_type'" :id="'discount_type'"
                                        :class="'select2'">
                                        <option value="">{{ __('app.select_discount_type') }}</option>

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
                             {{--  Tax   --}}
                               <div class="col-md-6 my-2">
                                <x-input-select :label="__('app.select_tax')" :name="'tax_id'" :id="'tax_id'">
                                    <option value="0" @selected(old('tax_id') == 0)>{{ __('app.no_tax') }}</option>
                                    @foreach ($tax_settings as $tax_setting)
                                    <option value="{{ $tax_setting->id }}" @selected(old('tax_id') == $tax_setting->id)>
                                        {{ $tax_setting->code}}
                                    </option>
                                    @endforeach

                                </x-input-select>

                                @error('tax_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                               </div>

                                {{-- TAGs  --}}
                                <div class="col-md-12 mt-2">

                                    <label for="tags" class="mb-1"><strong>{{ __('app.tags') }}</strong></label>
                                    <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                                        class="form-control" placeholder="{{ __('app.enter_tags') }}">
                                    @error('tags')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Short Description --}}
                                <div class="col-md-12 mt-2">

                                    <label for="short_description"
                                        class="mb-1"><strong>{{ __('app.short_description') }}</strong></label>

                                    <x-textarea-group :placeholder="__('app.enter_short_description_of_product')" :name="'short_description'" :id="'short_description'">
                                        {{ old('short_description') }} </x-textarea-group>

                                    @error('short_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Long Description --}}
                                <div class="col-md-12 mt-2">

                                    <label for="long_description"
                                        class="mb-1"><strong>{{ __('app.long_description') }}</strong></label>

                                    <textarea name="long_description" id="long_description" class="form-control" rows="5">{{ old('long_description') }}</textarea>

                                    @error('long_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- SEO --}}
                                <div class="col-md-12 mt-3">
                                    {{-- SEO Section hr --}}
                                    <h4>{{ __('app.meta_section') }}</h4>
                                    <hr>
                                </div>

                                {{-- SEO title --}}
                                <div class="col-md-12 mt-2">
                                    <label for="seo_title"
                                        class="mb-1"><strong>{{ __('app.seo_title') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('seo_title')" :name="'seo_title'"
                                        :placeholder="__('app.enter_seo_title')" :id="'seo_title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('seo_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- SEO keywords --}}
                                <div class="col-md-12 mt-2">
                                    <label for="keywords" class="mb-1"><strong>{{ __('app.keywords') }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('keywords')" :name="'keywords'"
                                        :placeholder="__('app.enter_keywords')" :id="'keywords'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- SEO description --}}
                                <div class="col-md-12 mt-2">

                                    <label for="seo_description"
                                        class="mb-1"><strong>{{ __('app.seo_description') }}</strong></label>

                                    <x-textarea-group :placeholder="__('app.enter_seo_description')" :name="'seo_description'" :id="'seo_description'">
                                        {{ old('seo_description') }} </x-textarea-group>

                                    @error('seo_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Attributes --}}

                                @include('backend.products.partials.create_attributes')

                                @include('backend.products.partials.create_custom_attributes')
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="card-style">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image_input"
                                            class="mb-1"><strong>{{ __('app.thumbnail') }}</strong></label>
                                        <div class="input-group">
                                            <input type="hidden" id="image" name="thumbnail" value="{{ old('thumbnail') }}">
                                            <input type="file" id="image_input" class="d-none image-crop">
                                        </div>
                                        <div class="mt-2 text-center ">
                                            <img src="{{ old('thumbnail') ?? getPlaceholderImage(285, 250) }}"
                                                alt="thumbnail" id="image-preview" class="img-fluid">
                                        </div>

                                        @error('thumbnail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{--  choose button and reset button --}}
                                    <div class="d-flex mt-2 justify-content-center">
                                        <x-primary-button :id="'thumbnail_image'" :class="'me-2 '" :name="'thumbnail'">
                                            <span class="mdi mdi-plus-circle" style="font-size: 20px"></span>
                                            {{ __('app.add') }}
                                        </x-primary-button>

                                        <x-danger-button :label="__('app.remove')" :id="'remove_thumbnail'">
                                            <span class="mdi mdi-reload" style="font-size: 20px"></span>
                                            {{ __('app.reset') }}
                                        </x-danger-button>
                                    </div>
                                    <div class="form-group">
                                        <label for="size_chart"
                                            class="mb-1"><strong>{{ __('app.size_chart') }}</strong></label>
                                        <div class="input-group">
                                            <input type="file"
                                                onchange=
                                                "document.getElementById('size_chart_preview').src =
                                                window.URL.createObjectURL(this.files[0])"
                                                id="size_chart_image_input" class="d-none" name="size_chart">
                                        </div>
                                        <div class="mt-2 text-center ">
                                            <img src="{{ old('size_chart') ?? asset('assets/backend/images/size-chart.jpg') }}"
                                                alt="size_chart" id="size_chart_preview" class="img-fluid">
                                        </div>

                                        @error('size_chart')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex mt-2 justify-content-center">

                                        <x-primary-button :id="'size_chart_image'" :class="'me-2 '">
                                            <span class="mdi mdi-plus-circle" style="font-size: 20px"></span>
                                            {{ __('app.add') }}
                                        </x-primary-button>

                                        <x-danger-button :label="__('app.remove')" :id="'remove_size_chart'">
                                            <span class="mdi mdi-reload" style="font-size: 20px"></span>
                                            {{ __('app.reset') }}
                                        </x-danger-button>
                                    </div>


                                    {{-- Multiple Images --}}
                                    <div class="multiple-images-wrapper">
                                        <div class="product-img mt-2">

                                            <label class="mb-1"><strong>Gallery Images</strong></label>

                                            {{-- <div class="text-center"> --}}

                                            <div class="row g-4 mb-4 " id="images_preview">
                                                @if (old('image_gallery') != null)
                                                    @foreach (old('image_gallery') as $image)
                                                        <div class="col-4 product-upload-photo">
                                                            <img src="{{ $image }}" alt=""
                                                                class="output_multiple_image">
                                                            <span onclick="deleteMultipleImageItem(this.parentElement)"
                                                                class="d-none"><svg width="20" height="22"
                                                                    viewBox="0 0 20 22" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M7.32617 2.21719L6.50977 3.4375H12.7402L11.9238 2.21719C11.8594 2.12266 11.752 2.0625 11.6359 2.0625H7.60977C7.49375 2.0625 7.38633 2.11836 7.32187 2.21719H7.32617ZM13.6426 1.07422L15.2195 3.4375H15.8125H17.875H18.2188C18.7902 3.4375 19.25 3.89727 19.25 4.46875C19.25 5.04023 18.7902 5.5 18.2188 5.5H17.875V18.5625C17.875 20.4617 16.3367 22 14.4375 22H4.8125C2.91328 22 1.375 20.4617 1.375 18.5625V5.5H1.03125C0.459766 5.5 0 5.04023 0 4.46875C0 3.89727 0.459766 3.4375 1.03125 3.4375H1.375H3.4375H4.03047L5.60742 1.06992C6.0543 0.403906 6.80625 0 7.60977 0H11.6359C12.4395 0 13.1914 0.403906 13.6383 1.06992L13.6426 1.07422ZM3.4375 5.5V18.5625C3.4375 19.323 4.05195 19.9375 4.8125 19.9375H14.4375C15.198 19.9375 15.8125 19.323 15.8125 18.5625V5.5H3.4375ZM6.875 8.25V17.1875C6.875 17.5656 6.56563 17.875 6.1875 17.875C5.80937 17.875 5.5 17.5656 5.5 17.1875V8.25C5.5 7.87187 5.80937 7.5625 6.1875 7.5625C6.56563 7.5625 6.875 7.87187 6.875 8.25ZM10.3125 8.25V17.1875C10.3125 17.5656 10.0031 17.875 9.625 17.875C9.24687 17.875 8.9375 17.5656 8.9375 17.1875V8.25C8.9375 7.87187 9.24687 7.5625 9.625 7.5625C10.0031 7.5625 10.3125 7.87187 10.3125 8.25ZM13.75 8.25V17.1875C13.75 17.5656 13.4406 17.875 13.0625 17.875C12.6844 17.875 12.375 17.5656 12.375 17.1875V8.25C12.375 7.87187 12.6844 7.5625 13.0625 7.5625C13.4406 7.5625 13.75 7.87187 13.75 8.25Z"
                                                                        fill="white" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            {{-- </div> --}}
                                        </div>

                                        <div class="text-center gallery-image-preview-placeholder">
                                            @if (!old('image_gallery'))
                                                <img class="img-fluid" src="{{ getPlaceholderImage(285, 250) }}"
                                                    alt="product images">
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

                                        <div class="d-flex mt-2 justify-content-center">

                                            <x-primary-button :id="'gallery_image_btn'" :class="'me-2 '">
                                                <span class="mdi mdi-upload" style="font-size: 20px"></span>
                                                {{ __('app.choose') }}
                                            </x-primary-button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <x-success-checkbox :id="'featured'" :value="'1'" :name="'featured'">
                                            {{ __('app.featured') }}
                                        </x-success-checkbox>

                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <x-success-checkbox :id="'new_arrival'" :value="'1'" :name="'new_arrival'">
                                            {{ __('app.new_arrival') }}
                                        </x-success-checkbox>

                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="row">
                                            <div class="col">
                                                <x-primary-button :type="'button'" :id="'publish_btn'" :class="'me-2 w-100'">
                                                    {{ __('app.publish') }}
                                                </x-primary-button>

                                                <input class="main-btn primary-btn btn-hover btn-sm d-none" type="submit"
                                                    name="status" value="PUBLISHED">

                                            </div>
                                            <div class="col">
                                                <x-secondary-button :type="'button'" :id="'draft_btn'"
                                                    :class="'me-2 w-100'">
                                                    {{ __('app.save_as_draft') }}
                                                </x-secondary-button>

                                                <input class="main-btn secondary-btn btn-hover btn-sm d-none"
                                                    type="submit" name="status" value="DRAFT">
                                            </div>
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
            $('#long_description').summernote({
                height: 400,

                toolbar: [
                    // hide font family button
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph', 'style']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
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
                .append('<option value="">{{ __('app.select_a_subcategory') }}</option>');

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
                .append('<option value="">{{ __('app.select_a_sub_subcategory') }}</option>');

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
    <script>
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
    </script>

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
                placeholder: "{{ __('app.select_tax') }}",
            });
    </script>
@endpush
