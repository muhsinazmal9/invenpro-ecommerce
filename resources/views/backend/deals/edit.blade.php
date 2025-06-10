@extends('backend.layouts.app')
@section('title', 'Edit Deals')
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
                        <h2>{{ 'Edit Deals' }}</h2>
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
                    <form action="{{ route('admin.deals.update', $deal->slug) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-5 my-2">
                                <label for="title" class="mb-1"><strong>{{ 'Title' }}</strong></label>
                                <x-input-group :type="'text'" :value="old('title', $deal->title)" :name="'title'"
                                    :placeholder="'Enter title of banner'" :id="'title'">
                                    <span class="mdi mdi-shape"></span>
                                </x-input-group>
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-5 my-2">
                                <label for="date" class="mb-1"><strong>{{ 'Date' }}</strong></label>
                                <x-input-group :type="'date'" :value="old('date', $deal->date?->toDateString())"
                                    :name="'date'" :placeholder="__('app.enter_date')" :id="'link'">
                                    <span class="mdi mdi-shape"></span>
                                </x-input-group>
                                @error('date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2 my-2">
                                <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                    data-bs-toggle="modal" style="margin-top:36px" data-bs-target="#addProductModal">{{
                                    'Add More Product' }}</button>
                            </div>
                            <div class="col-md-5 my-2">
                                <label for="image" class="mb-1"><strong>{{ 'Choose an image' }}</strong></label>
                                <div class="image-wrapper border-red-500 cursor-pointer">
                                    <label for="image_input">
                                        <input type="hidden" name="image" id="image" value="{{ old('image') }}">
                                        <input class="d-none image-crop" type="file" accept="image/*" name="image_input"
                                            id="image_input">

                                        <img id="image-preview" class="img-fluid cursor-pointer"
                                            src="{{ asset($deal->image) }}" alt="{{ $deal->title }}" />
                                    </label>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                        id="change_image">
                                        <span class="mdi mdi-file-image"></span>
                                        {{ 'Change Image' }}
                                    </button>
                                    <button type="button" class="main-btn danger-btn btn-hover btn-sm" id="reset_image">
                                        <span class="mdi mdi-refresh"></span>
                                        {{ 'Reset' }}
                                    </button>
                                </div>
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-7 my-2">
                                <input type="hidden" name="product_ids" id="product_ids" value="[]">
                                <div class="product_wrapper table-responsive" id="newly_selected_products">
                                    <label class="mb-1">
                                        <strong>{{ 'Newly Selected Products' }}</strong>
                                    </label>
                                    <table class="table mb-5">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="10%">
                                                    <span class="form-text">{{ 'Thumbnail' }}</span>
                                                </th>
                                                <th class="text-center" width="20%">
                                                    <span class="form-text">{{ 'Title' }}</span>
                                                </th>
                                                <th class="text-center" width="15%">
                                                    <span class="form-text">{{ 'Price' }}</span>
                                                </th>
                                                <th class="text-center" width="10%">
                                                    <span class="form-text">{{ 'Actions' }}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="new_selected_products"></tbody>
                                    </table>
                                    @error('product_ids')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="product_wrapper table-responsive">
                                    <label class="mb-1"><strong>{{ 'Saved Products' }}</strong></label>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="10%">
                                                    <span class="form-text">{{ 'Thumbnail' }}</span>
                                                </th>
                                                <th class="text-center" width="20%">
                                                    <span class="form-text">{{ 'Title' }}</span>
                                                </th>
                                                <th class="text-center" width="15%">
                                                    <span class="form-text">{{ 'Price' }}</span>
                                                </th>
                                                <th class="text-center" width="10%">
                                                    <span class="form-text">{{ 'Actions' }}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="product_body">
                                            @forelse ($deal->products as $product)
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ asset($product->thumbnail) }}"
                                                        alt="{{ $product->title }}" class="rounded"
                                                        style="max-width: 80px" height="50px">
                                                </td>
                                                <td class="text-center">{{ $product->title }}</td>
                                                <td class="text-center">{{ $product->price }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeSelectedProduct(this, '{{ $product->slug }}', '{{ $product->id }}')">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    <p>{{ 'No Products' }}</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 my-2">
                            @if ($deal->status)
                            <x-success-checkbox :id="'status'" :checked="true" :value="'1'" :name="'status'">
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
    </div>
    <!-- End Row -->
    </div>
    <!-- end container -->
</section>
<!-- ========== section end ========== -->

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
    let saved_product_ids = JSON.stringify({{ $deal->products->pluck('id') }}) ?? [];
        let saved_product_ids_array = JSON.parse(saved_product_ids);
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

            // Change Image
            $('#change_image').click(function() {
                $('#image_input').click();
            });

            // Reset Image
            $('#reset_image').click(function() {
                $('#image_input').val('');
                $('#image-preview').attr('src', '{{ asset($deal->image) }}');
                $('#image').val('');
            });
        });

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

            const getAllSelectedProducts = JSON.parse(localStorage.getItem('deals_product_edit_screen')) ?? [];


            $("#product_container").empty();
            if (products.length == 0) {
               $("#product_container").css('opacity', 0).slideDown("fast").animate({
                opacity: 1
                }, 500);
                $("#product_container").append(`
                    <div class="text-center p-4">
                        <i class="lni lni-shopping-basket fs-1 text-danger"></i>
                        <h4 class="pb-1">No products found</h4>
                        <p>Your search did not match any products</p>
                    </div>
                `)
            } else {
                products.forEach((product, index) => {


                    let saved_product_ids = JSON.stringify({{ $deal->products->pluck('id') }}) ?? [];
                    let saved_product_ids_array = JSON.parse(saved_product_ids);
                    let isSelected = getAllSelectedProducts.find(p => p.product_id == product.id) ? true : false;
                    let isSaved = saved_product_ids_array.includes(product.id) ? true : false;


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

                                        ${isSelected || isSaved ? "disabled" : `onclick="selectProduct(this,'${product.id}','${product.thumbnail}','${product.title}','${product.price}')"`}

                                        class="main-btn  ${isSelected || isSaved ? 'success-btn' : 'primary-btn' }  btn-hover btn-sm" style="padding:4px 8px; ${isSelected || isSaved ? 'cursor:no-drop' : '' }">

                                        ${isSelected || isSaved ? "<i class='mdi mdi-check-circle fs-5'></i>" : "<i class='mdi mdi-plus-circle fs-5'></i>"}
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
            // add checn icon to the button
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

            const deals_product_edit_screen = JSON.parse(localStorage.getItem('deals_product_edit_screen')) ?? [];

            // check if product already exists
            if (deals_product_edit_screen.length > 0) {
                if (!deals_product_edit_screen.find(product => product.product_id == product_id)) {
                    deals_product_edit_screen.push(product);
                }
            } else {
                deals_product_edit_screen.push(product);
            }

            localStorage.setItem('deals_product_edit_screen', JSON.stringify(deals_product_edit_screen));

            loopSelectedProduct();


        }


        function loopSelectedProduct() {
            const products = JSON.parse(localStorage.getItem('deals_product_edit_screen')) ?? [];
            let selected_product_ids = products.map(p => +p.product_id);
            let all_product_ids = saved_product_ids_array.concat(selected_product_ids);
            let all_product_ids_unique = [...new Set(all_product_ids)];
            $("#product_ids").val(JSON.stringify(all_product_ids_unique));
            $("#new_selected_products").empty();
            if (products.length > 0) {
                products.forEach(product => {
                    let buildProductHtml = `
                        <tr>
                            <td class="text-center" width="10%">
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
                    $("#new_selected_products").prepend(buildProductHtml);
                });
            } else {
                let buildProductHtml = `
                        <tr>
                            <td class="text-center" colspan="4">
                                <p>No product selected</p>
                            </td>
                        </tr>
                    `;
                $("#new_selected_products").prepend(buildProductHtml);
            }
        }

        function removeProduct(button, product_id) {
            $(button).closest('tr').css('opacity', '40%');

            setTimeout(() => {
                const products = JSON.parse(localStorage.getItem('deals_product_edit_screen')) ?? [];
                const productIndex = products.findIndex(product => product.product_id == product_id);
                products.splice(productIndex, 1);
                localStorage.setItem('deals_product_edit_screen', JSON.stringify(products));
                loopSelectedProduct();
            }, 500);
        }


        function removeSelectedProduct(btn, product_slug, product_id) {

            let row = $(btn).closest('tr');
            let url = "{{ url('/deals/product/destroy/') }}/:deal_slug/:product_slug";

            url = url.replace(':deal_slug', "{{ $deal->slug }}");
            url = url.replace(':product_slug', product_slug);

            let method = "delete";
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: "{{ 'Are you sure?' }}",
                text: "{{ 'You will not be able to revert this!' }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ 'Yes, delete it!' }}",
                cancelButtonText: "{{ 'Cancel' }}",
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    itemDelete(url, method, token, row);
                    saved_product_ids_array = saved_product_ids_array.filter(function(e) {
                        return e != product_id;
                    });
                    console.log(saved_product_ids_array);
                    loopSelectedProduct();
                }
            })
        }
</script>
@endpush
