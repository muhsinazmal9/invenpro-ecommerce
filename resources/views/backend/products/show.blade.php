@extends('backend.layouts.app')
@section('title', $product->title)
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://www.insightindia.com/mcss/icon-font.css">
    <style>
        .slick-slider .slick-prev,
        .slick-slider .slick-next {
            z-index: 100;
            font-size: 2.5em;
            height: 40px;
            width: 40px;
            margin-top: -20px;
            color: #B7B7B7;
            position: absolute;
            top: 50%;
            text-align: center;
            color: #000;
            opacity: .3;
            transition: opacity .25s;
            cursor: pointer;
        }

        .slick-slider .slick-prev:hover,
        .slick-slider .slick-next:hover {
            opacity: .65;
        }

        .slick-slider .slick-prev {
            left: 0;
        }

        .slick-slider .slick-next {
            right: 0;
        }

        #detail .product-images {
            width: 100%;
            margin: 0 auto;
            border: 1px solid #eee;
        }

        #detail .product-images li,
        #detail .product-images figure,
        #detail .product-images a,
        #detail .product-images img {
            display: block;
            outline: none;
            border: none;
        }

        #detail .product-images .main-img-slider figure {
            margin: 0 auto;
            padding: 0 2em;
        }

        #detail .product-images .main-img-slider figure a {
            cursor: pointer;
            cursor: -webkit-zoom-in;
            cursor: -moz-zoom-in;
            cursor: zoom-in;
        }

        #detail .product-images .main-img-slider figure a img {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        #detail .product-images .thumb-nav {
            margin: 0 auto;
            padding: 20px 10px;
            max-width: 600px;
        }

        #detail .product-images .thumb-nav.slick-slider .slick-prev,
        #detail .product-images .thumb-nav.slick-slider .slick-next {
            font-size: 1.2em;
            height: 20px;
            width: 26px;
            margin-top: -10px;
        }

        #detail .product-images .thumb-nav.slick-slider .slick-prev {
            margin-left: -30px;
        }

        #detail .product-images .thumb-nav.slick-slider .slick-next {
            margin-right: -30px;
        }

        #detail .product-images .thumb-nav li {
            display: block;
            margin: 0 auto;
            cursor: pointer;
        }

        #detail .product-images .thumb-nav li img {
            display: block;
            width: 100%;
            max-width: 75px;
            margin: 0 auto;
            border: 2px solid transparent;
            -webkit-transition: border-color .25s;
            -ms-transition: border-color .25s;
            -moz-transition: border-color .25s;
            transition: border-color .25s;
        }

        #detail .product-images .thumb-nav li:hover,
        #detail .product-images .thumb-nav li:focus {
            border-color: #999;
        }

        #detail .product-images .thumb-nav li.slick-current img {
            border-color: #d12f81;
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
                            <h2>{{ 'Products' }}</h2>
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
                                        <a href="{{ route('admin.products.index') }}">{{ 'Products' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Deals'}}
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
                <div class="col-md-5">
                    {{-- add Thumbnail picker design --}}
                    <div id="detail" class="card style">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-11 mx-auto py-5">
                                    <!-- Product Images & Alternates -->
                                    <div class="product-images demo-gallery">
                                        <!-- Begin Product Images Slider -->
                                        <div class="main-img-slider">
                                            <a data-fancybox="gallery" href="{{ asset($product->thumbnail) }}">
                                                <img style="width: 100%" src="{{ asset($product->thumbnail) }}"
                                                    class="img-fluid" alt="{{ $product->title }}">
                                            </a>
                                            @foreach ($product->images as $image)
                                                <a data-fancybox="gallery" href="{{ asset($image->source) }}">
                                                    <img style="width: 100%" src="{{ asset($image->source) }}"
                                                        class="img-fluid" alt="{{ $product->title }}">
                                                </a>
                                            @endforeach
                                        </div>
                                        <!-- End Product Images Slider -->

                                        <!-- Begin product thumb nav -->
                                        <ul class="thumb-nav">
                                            <li><img style="max-height: 50px" src="{{ asset($product->thumbnail) }}"
                                                    alt="{{ $product->title }}"></li>
                                            @foreach ($product->images as $image)
                                                <li><img style="max-height: 50px" src="{{ asset($image->source) }}"
                                                        alt="{{ $product->title }}"></li>
                                            @endforeach

                                        </ul>
                                        <!-- End product thumb nav -->
                                    </div>
                                    <!-- End Product Images & Alternates -->

                                </div>
                            </div>
                        </div>

                        <!-- End Row -->
                    </div>
                    <!-- End Card -->
                </div>
                <div class="col-md-7 mt-3 mt-md-0">
                    <div class="card-style">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="fw-bold">{{ $product->title }}</h2>
                                <p class="text-sm mt-2">{{ 'Date' }}: {{ $product->created_at?->format('j/m/Y') }}</p>
                                <p class="text-sm pt-1">
                                    ( {{ $product->ratting }} )
                                        @for ($i = 0; $i < (int) $product->ratting; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor

                                        @if ($product->ratting - (int) $product->ratting > 0.5)
                                            <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                        @endif

                                        @for ($i = 0; $i < 5 - round($product->ratting) ; $i++)
                                            <i class="far fa-star text-warning"></i>
                                        @endfor
                                    <span class="ps-1">{{ $product->reviews->count() }} {{ 'Reviews' }}</span>
                                </p>

                                <div class="mt-4">
                                    <p class="fw-bold">{{ 'Price' }}:</p>
                                        <h3 >
                                           <del class=" text-muted fw-normal lh-base" style="font-size: 0.8rem; vertical-align: middle;">
                                                {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}{{ number_format($product->price, 2) }}
                                            </del>
                                        </h3>
                                        @if ($product->discount_type && $product->discount > 0)
                                        <h3 class=" text-success fw-bold lh-base">
                                            {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}
                                            @if($product->discount_type == \App\Models\Product::DISCOUNT_TYPE['percentage'])
                                                {{ number_format($product->price - ($product->price * $product->discount) / 100) }}
                                            @elseif ($product->discount_type == \App\Models\Product::DISCOUNT_TYPE['fixed'])
                                                {{ number_format($product->price - $product->discount,2) }}
                                            @endif
                                        </h3>
                                        @endif
                                </div>

                                <div class="mt-4">
                                    <p class="fw-bold">{{ 'Available Stock' }}:</p>
                                    <p>{{ $product->stock }}</p>
                                </div>

                                @if ($product->discount)
                                    <div class="mt-4">
                                        <p class="fw-bold">{{ 'Discount information' }}:</p>
                                        <p>
                                            {{ $product->discount }}@if($product->discount_type == \App\Models\Product::DISCOUNT_TYPE['percentage'])%@else {{ getSetting(\App\Models\Settings::DEFAULT_CURRENCY) }}@endif
                                            ({{ $product->discount_type }})
                                        </p>
                                    </div>
                                @endif


                                <div class="mt-4">
                                    <p class="fw-bold pb-2">{{ 'Attributes' }}:</p>

                                    <div class="table-wrapper table-responsive">
                                        <!-- begin table -->
                                        <div class="d-flex flex-column gap-4">
                                            @forelse ($product->attributes as $attribute)

                                                <table class="table-bordered p-5 mx-auto "
                                                    style="border-color:#00000052 !important; width: 100%">
                                                    <tbody class="">
                                                        <tr class="mt-5">
                                                            <th class="p-2" colspan="2">{{ 'Name' }}: {{ $attribute->name }}
                                                            </th>
                                                            <th class="p-2" colspan="2">{{ 'Type' }}: {{ $attribute->type }}
                                                            </th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th colspan="4" class="p-2">{{ 'Items' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-2">{{ 'Name' }} </th>
                                                            <th class="p-2">{{ 'Price Adjustment' }} </th>
                                                            <th class="p-2" colspan="2">{{ 'Code' }} </th>
                                                        </tr>
                                                        @foreach ($attribute->items as $item)
                                                            <tr>
                                                                <td class="p-2">{{ $item->name }}</td>
                                                                <td class="p-2">{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}{{ $item->price_adjustment }}</td>
                                                                <td class="p-2" colspan="2">{{ $item->code }} </td>
                                                            </tr>
                                                        @endforeach
                                                </table>

                                            @empty
                                                <table class="table-bordered p-5 mx-auto"
                                                    style="border-color:#00000052 !important; width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td class="p-2" colspan="4">{{ 'No attributes' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endforelse
                                        </div>

                                        <!-- end table -->
                                    </div>
                                </div>


                                <div class="mt-4">

                                    <nav class="nav nav-pills mb-3 d-flex gap-3" id="pills-tab" role="tablist">
                                        <button class="nav-link tab-button active" id="nav-long-description-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-long-description" type="button"
                                            role="tab" aria-controls="nav-long-description" aria-selected="true">{{ 'Long Description' }}</button>

                                        <button class="nav-link tab-button" id="nav-short-description-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-short-description" type="button"
                                            role="tab" aria-controls="nav-short-description"
                                            aria-selected="false">{{ 'Short Description' }}</button>

                                        <button class="nav-link tab-button" id="nav-additional-information-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-additional-information"
                                            type="button" role="tab" aria-controls="nav-additional-information"
                                            aria-selected="false">{{ 'Additional Information' }}</button>

                                        <button class="nav-link tab-button" id="nav-size-chart-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-size-chart"
                                            type="button" role="tab" aria-controls="nav-size-chart"
                                            aria-selected="false">{{ 'Size Chart' }}</button>

                                        <button class="nav-link tab-button" id="nav-seo-information-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-seo-information" type="button"
                                            role="tab" aria-controls="nav-seo-information" aria-selected="false">{{ 'SEO Information' }}</button>

                                        <button class="nav-link tab-button" id="nav-reviews-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button"
                                            role="tab" aria-controls="nav-reviews" aria-selected="false">{{ $product->reviews->count() }} {{ 'Reviews' }}</button>

                                    </nav>

                                    <div class="tab-content p-3 border bg-light" id="nav-tabContent">

                                        <div class="tab-pane fade active show" id="nav-long-description" role="tabpanel"
                                            aria-labelledby="nav-long-description-tab">
                                            <p>{!! $product->long_description !!}</p>
                                        </div>

                                        <div class="tab-pane fade" id="nav-short-description" role="tabpanel"
                                            aria-labelledby="nav-short-description-tab">
                                            {{ $product->short_description }}
                                        </div>
                                        <div class="tab-pane fade" id="nav-additional-information" role="tabpanel"
                                            aria-labelledby="nav-additional-information-tab">
                                            <div class="table-wrapper table-responsive">
                                                <!-- begin table -->
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="fw-bold">{{ 'Brand' }}:</span>
                                                                {{ $product->brand?->title ?? 'None' }}
                                                            </td>
                                                            <td>
                                                                <span class="fw-bold">{{ 'Category' }}:</span>
                                                                {{ $product->category?->name ?? 'None' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="fw-bold">{{ 'Subcategory' }}:</span>
                                                                {{ $product->subcategory?->title ?? 'None' }}
                                                            </td>
                                                            <td>
                                                                <span class="fw-bold">{{ 'sub subcategory' }}:</span>
                                                                {{ $product->subsubCategory?->title ?? 'None' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="fw-bold">{{ 'SKU' }}:</span>
                                                                {{ $product->sku ?? 'None' }}
                                                            </td>
                                                            <td>
                                                                <span class="fw-bold">{{ 'Status' }}:</span>
                                                                @if ($product->status)
                                                                    <span class="badge bg-success-subtle text-success">{{ 'Enabled' }}</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger">{{ 'Disabled' }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="fw-bold">{{ 'Featured' }}:</span>
                                                                @if ($product->featured)
                                                                    <span class="badge bg-success-subtle text-success">{{ 'Yes' }}</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger">{{ 'No' }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="fw-bold">{{ 'New Arrival' }}:</span>
                                                                @if ($product->new_arrival)
                                                                    <span class="badge bg-success-subtle text-success">{{ 'Yes' }}</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger">{{ 'No' }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="fw-bold">{{ 'TAX' }}:</span>
                                                                @if ($product?->tax?->code)
                                                                    <span class="badge bg-success-subtle text-success">{{ $product->tax->code }}</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger">{{ 'No' }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="fw-bold">{{ 'Tags' }}:</span>
                                                                @if ($product->tags->isNotEmpty())
                                                                    @foreach ($product->tags as $tag)
                                                                        <span class="badge bg-success-subtle text-success mx-1">{{ $tag->title }}</span>
                                                                    @endforeach
                                                                @else
                                                                    {{ 'None' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if (!empty($product->customAttributes))
                                                            @foreach ($product->customAttributes as $attribute)
                                                                <tr>
                                                                    <td>
                                                                        <span class="fw-bold">{{ $attribute['key'] ?? 'None' }}:</span>
                                                                    </td>
                                                                    <td>
                                                                        {{ $attribute['value'] ?? 'None' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>
                                                                    <span class="fw-bold">{{ 'Custom Attributes' }}:</span>
                                                                </td>
                                                                <td>
                                                                    {{ 'None' }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <!-- end table -->
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-size-chart" role="tabpanel"
                                            aria-labelledby="nav-size-chart-tab">
                                            <div class="table-wrapper table-responsive">
                                                <!-- begin table -->
                                                <table class="table striped-table">
                                                    <tbody>
                                                        <tr>
                                                            <td><span class="fw-bold">{{ 'Size Chart' }}:</span><br>
                                                                 <img class="img-fluid rounded" src="{{asset($product->size_chart ) }}" /></td>

                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <!-- end table -->
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="nav-seo-information" role="tabpanel"
                                            aria-labelledby="nav-seo-information-tab">
                                            <div class="table-wrapper table-responsive">
                                                <!-- begin table -->
                                                <table class="table striped-table">
                                                    <tbody>
                                                        <tr>
                                                            <td><span class="fw-bold">{{ 'Meta Title' }}:</span>
                                                                {{ $product->seo_title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="fw-bold">{{ 'Keywords' }}:</span>
                                                                {{ $product->keywords }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="fw-bold">{{ 'Meta Description' }}:</span>
                                                                {{ $product->seo_description }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- end table -->
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="nav-reviews" role="tabpanel"
                                            aria-labelledby="nav-reviews-tab">
                                            <ul>
                                                @forelse ($product->reviews as $review)
                                                    <li class="my-3">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <img src="{{ asset('assets/backend/images/profile/profile.png') }}" alt="">
                                                            </div>
                                                            <div class="ps-4">
                                                                <p>
                                                                    <span class="fw-bold">{{ $review->user->name }}</span>
                                                                </p>
                                                                <p>
                                                                    {{ $review->created_at->format('d/m/Y h:i A') }}
                                                                </p>
                                                                <p>
                                                                    @for ($i = 0; $i < (int) $review->rating; $i++)
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    @endfor

                                                                    @if ($review->ratting - (int) $review->rating > 0.5)
                                                                        <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                                                    @endif

                                                                    @for ($i = 0; $i < 5 - round($review->rating) ; $i++)
                                                                        <i class="far fa-star text-warning"></i>
                                                                    @endfor
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="comment mt-2">
                                                            <p>
                                                                {{ $review->comment }}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <li>{{ 'No Reviews' }}</li>
                                                @endforelse
                                            </ul>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- end container -->
    </section>
    <!-- ========== section end ========== -->
@endsection


@push('script')
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script>
        // Main/Product image slider for product page
        $('#detail .main-img-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            fade: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 300,
            lazyLoad: 'ondemand',
            asNavFor: '.thumb-nav',
            arrows: false,
        });
        // Thumbnail/alternates slider for product page
        $('.thumb-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            centerPadding: '0px',
            asNavFor: '.main-img-slider',
            dots: false,
            centerMode: false,
            draggable: true,
            speed: 200,
            focusOnSelect: true,
            prevArrow: '<div class="slick-prev"><i class="fas fa-chevron-left"></i><span class="sr-only sr-only-focusable">Previous</span></div>',
            nextArrow: '<div class="slick-next"><i class="fas fa-chevron-right"></i><span class="sr-only sr-only-focusable">Next</span></div>'
        });


        //keeps thumbnails active when changing main image, via mouse/touch drag/swipe
        $('.main-img-slider').on('afterChange', function(event, slick, currentSlide, nextSlide) {
            //remove all active class
            $('.thumb-nav .slick-slide').removeClass('slick-current');
            //set active class for current slide
            $('.thumb-nav .slick-slide:not(.slick-cloned)').eq(currentSlide).addClass('slick-current');
        });
    </script>
@endpush
