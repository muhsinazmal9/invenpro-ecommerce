@extends('backend.layouts.app')
@section('title', 'Create Deals')
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
            width: 285px !important;
            height: 361px !important;
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
                            <h2>{{ 'Create Deals' }}</h2>
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
                                        <a href="{{ route('admin.deals.index') }}">{{ 'Deals' }}</a>
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
                        <form action="{{ route('admin.deals.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row ">
                                <div class="col-md-5 my-2">
                                    <label for="title" class="mb-1"><strong>{{ 'Title' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('title')" :name="'title'" :placeholder="'Enter title of the deal'"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-5 my-2">
                                    <label for="date" class="mb-1"><strong>{{ 'Date' }}</strong></label>
                                    <x-input-group :type="'date'" :value="old('date')" :name="'date'" :placeholder="__('app.enter_date')"
                                        :id="'link'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                        data-bs-toggle="modal" style="margin-top:42px"
                                        data-bs-target="#addProductModal">{{ 'Add Product' }}</button>
                                </div>
                                <div class="col-md-5 my-2">
                                    <label for="image"
                                        class="mb-1"><strong>{{ 'Choose an image' }}</strong></label>
                                    <div class="image-wrapper border-red-500 cursor-pointer">
                                        <label for="image_input">
                                            <input type="hidden" name="image" id="image"
                                                value="{{ old('image') }}">
                                            <input class="d-none image-crop" type="file" accept="image/*"
                                                name="image_input" id="image_input">

                                            <img id="image-preview" class="img-fluid cursor-pointer"
                                                src="{{ getPlaceholderImage(285, 361) }}" alt="your image" />
                                        </label>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                            id="choose_image">
                                            <span class="mdi mdi-file-image"></span>
                                            {{ 'Choose Image' }}
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

                                <div class="col-md-7">
                                    <input type="hidden" name="product_ids" id="product_ids" value="[]">

                                    <div class="product_wrapper table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="10%">{{ 'Thumbnail' }}</th>
                                                    <th class="text-center" width="20%">{{ 'Title' }}</th>
                                                    <th class="text-center" width="15%">{{ 'Price' }}</th>
                                                    <th class="text-center" width="10%">{{ 'Actions' }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="product_body">
                                                <tr>
                                                    <td class="text-center" colspan="4">{{ 'No Products' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @error('product_ids')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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

    {{-- Add Product Modal --}}
    <div class="modal fade" data-bs-backdrop="static" id="addProductModal" tabindex="-1"
        aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addProductModalLabel">{{ 'Add Product' }}</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="header-search">
                        <form style="max-width: 100% !important" class="w-full" role="search">
                            <input id="productSearch" class="form-control" type="search" placeholder="Search" autofocus
                                aria-label="Search">
                            <button><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>
                    <div id="product_container">
                        <div class="text-center p-4">
                            <i class="lni lni-keyword-research fs-1"></i>
                            <p>Search product</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @include('backend.partials.image_cropper_modal')

@endsection

@push('script')
    <script type="module" src="{{ asset('assets/backend/js/image-cropper.js') }}"></script>
    <script type="module">
        import imageCrop from "{{ asset('assets/backend/js/image-cropper.js') }}";
        imageCrop(285, 361);
    </script>
    <script>
        $(document).ready(function() {
            let timeoutID = null;

            $('#productSearch').on('input', function(e) {
                clearTimeout(timeoutID);
                const keyword = e.target.value;

                timeoutID = setTimeout(() => {
                    if (keyword === '') {
                        $("#product_container").css('opacity', 0).slideDown("fast").animate({
                            opacity: 1
                        }, 500);

                        $("#product_container").html(`
                            <div class="text-center p-4">
                                <i class="lni lni-keyword-research fs-1"></i>
                                <p>Search product</p>
                            </div>
                        `);
                        return;
                    }

                    productSearch(keyword);
                }, 500);
            });
            loopSelectedProduct();

            $('#choose_image').click(function() {
                $('#image_input').click();
            });

            $('#reset_image').click(function() {
                $('#image-preview').attr('src', "{{ getPlaceholderImage(285, 361) }}");
                $('#image_input').val('');
                $('#image').val('');
            });
        });

        function productSearch(keyword) {
            const data = {
                'keyword': keyword,
                'is_admin': true,
            };

            const url = "{{ url('/api/v1/product/search') }}/?" + $.param(data);
            console.log($.param(data));
            $.get(url, function(response) {
                if (response.success) {
                    productLoop(response.data);
                }
            });
        }

        function productLoop(products) {

            const getAllSelectedProducts = JSON.parse(localStorage.getItem('deals_products')) ?? [];


            $("#product_container").empty();
            if (products.length == 0) {
                $("#product_container").css('opacity', 0).slideDown("fast").animate({
                    opacity: 1
                }, 500);
                $("#product_container").html(`
                    <div class="text-center p-4">
                        <i class="lni lni-shopping-basket fs-1 text-danger"></i>
                        <h4 class="pb-1">No products found</h4>
                        <p>Your search did not match any products</p>
                    </div>
                `);
            } else {
                products.forEach((product, index) => {

                    let isSelected = getAllSelectedProducts.find(p => p.product_id == product.id) ? true : false;

                    let buildProductHtml = `
                        <div class="card mt-3" id="product_card_${product.id}" style="opacity: 0;">
                            <div class="card-body d-flex gap-2 align-items-center">
                                <div>
                                    <img style="height: 100px; width: 100px; object-fit: cover;"
                                        src="${product.thumbnail}" alt="product_thumbnail">
                                </div>
                                <div class="flex-fill align-self-start">
                                    <h5 class="card-title">${product.title}</h5>
                                    <div class="d-flex gap-1 align-items-center">
                                        <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                        <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                        <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                        <i style="font-size: 12px" class="fa-solid fa-star-half-stroke text-warning"></i>
                                        <i style="font-size: 12px" class="far fa-star text-warning"></i>
                                    </div>
                                    <p class="mt-1">
                                        {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }} ${(product.price).toLocaleString(undefined, { minimumFractionDigits: 2 })}
                                    </p>
                                    <p class="mt-2" style="font-size: 14px">
                                        ${product.short_description.length > 30 ? product.short_description.substring(0,30) + '...' : product.short_description}
                                    </p>
                                </div>
                                <div>
                                    <button
                                        type="button"

                                        ${isSelected ? "disabled" : `onclick="selectProduct(this,'${product.id}','${product.thumbnail}','${product.title}','${product.price}')"`}

                                        class="main-btn  ${isSelected ? 'success-btn' : 'primary-btn' }  btn-hover btn-sm" style="padding:4px 8px; ${isSelected ? 'cursor:no-drop' : '' }">

                                        ${isSelected ? "<i class='mdi mdi-check-circle fs-5'></i>" : "<i class='mdi mdi-plus-circle fs-5'></i>"}
                                    </button>
                                </div>
                            </div>

                        </div>
                    `;

                    $("#product_container").append(buildProductHtml);

                    $("#product_card_" + product.id).delay(index * 50).animate({
                        opacity: 1,
                    }, 500);
                });
            }
        }

        function selectProduct(button, product_id, thumbnail, title, price) {
            $(button).html('<i class="mdi mdi-check-circle fs-5"></i>')
                .attr('disabled', true)
                .removeClass('primary-btn')
                .addClass('success-btn');


            const product = {
                'product_id': product_id,
                'thumbnail': thumbnail,
                'title': title,
                'price': price,
            };

            const deals_products = JSON.parse(localStorage.getItem('deals_products')) ?? [];

            if (deals_products.length > 0) {
                if (!deals_products.find(product => product.product_id == product_id)) {
                    deals_products.push(product);
                }
            } else {
                deals_products.push(product);
            }

            localStorage.setItem('deals_products', JSON.stringify(deals_products));

            loopSelectedProduct();
        }

        $('#addProductModal').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        })

        $("#addProductModal .close").click(function() {
            setTimeout(() => {
                $("#productSearch").val('');
                $("#product_container").html(`
                    <div class="text-center p-4">
                            <i class="lni lni-keyword-research fs-1"></i>
                            <p>Search product</p>
                    </div>
                `);
            }, 1000);
        })

        function loopSelectedProduct() {

            const products = JSON.parse(localStorage.getItem('deals_products')) ?? [];
            $("#product_ids").val(JSON.stringify(products.map(p => p.product_id)));
            $("#product_body").empty();
            if (products.length == 0) {
                $("#product_body").append(`
                    <tr>
                        <td class="text-center" colspan="4">{{ 'No Products' }}</td>
                    </tr>
                `);
            } else {
                products.forEach(product => {

                    let buildProductHtml = `
                        <tr>
                            <td class="text-center"  width="10%">
                                <img src="${product.thumbnail}" alt="product image" class="rounded" style="max-width:80px">
                            </td>
                            <td class="text-center"  width="20%">${product.title}</td>
                            <td class="text-center"  width="15%">{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${product.price}</td>
                            <td class="text-center" width="10%">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this,${product.product_id})">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    $("#product_body").append(buildProductHtml);
                });
            }
        }

        function removeProduct(button, product_id) {

            $(button).closest('tr').css('opacity', '40%');

            setTimeout(() => {
                const products = JSON.parse(localStorage.getItem('deals_products')) ?? [];
                const productIndex = products.findIndex(product => product.product_id == product_id);
                products.splice(productIndex, 1);
                localStorage.setItem('deals_products', JSON.stringify(products));
                loopSelectedProduct();
            }, 500);


        }
    </script>
@endpush
