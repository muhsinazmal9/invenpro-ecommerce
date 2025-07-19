@extends('layouts.frontend.main-layout')

@section('title', 'Home')

@section('content')
<!-- Slider -->
<div class="tf-slideshow slider-electronic slider-default">
    <div dir="ltr" class="swiper tf-sw-slideshow slider-effect-fade" data-preview="1" data-tablet="1"
        data-mobile="1" data-centered="false" data-space="0" data-space-mb="0" data-loop="true"
        data-auto-play="true">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="slider-wrap bg-type-4">
                    <div class="image">
                        <img src="{{ asset('front_assets/images') }}/slider/electronic/slider-electronic-1.png"
                            data-src="{{ asset('front_assets/images') }}/slider/electronic/slider-electronic-1.png" alt="slider"
                            class="lazyload">
                    </div>
                    <div class="box-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-12 col-sm-6">
                                    <div class="content-slider">
                                        <div class="box-title-slider">
                                            <p class="sub text-md fw-medium fade-item fade-item-1 text-dark-3">
                                                ALL GADGETS COLLECTION
                                            </p>
                                            <h2 class="heading fw-medium fade-item fade-item-2 text-dark-3">
                                                Sale up to <br> 15% Off
                                            </h2>
                                        </div>
                                        <div class="box-btn-slider fade-item fade-item-3">
                                            <a href="shop-default.html" class="tf-btn btn-dark2 animate-btn">
                                                Shop Now
                                                <i class="icon icon-arr-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide reverse-slide">
                <div class="slider-wrap bg-type-5">
                    <div class="image">
                        <img src="{{ asset('front_assets/images') }}/slider/electronic/slider-electronic-2.png"
                            data-src="{{ asset('front_assets/images') }}/slider/electronic/slider-electronic-2.png" alt="slider"
                            class="lazyload">
                    </div>
                    <div class="box-content">
                        <div class="container">
                            <div class="row">
                                <div class=" offset-lg-8 col-lg-4 col-sm-6 offset-6 col-12">
                                    <div class="content-slider">
                                        <div class="box-title-slider">
                                            <p class="sub text-md fw-medium fade-item fade-item-1 text-dark-3">
                                                APPLE MAGSAFE CHARGER
                                            </p>
                                            <h2 class="heading fw-medium fade-item fade-item-2 text-dark-3">
                                                Next-Level <br> Tech
                                            </h2>

                                        </div>
                                        <div class="box-btn-slider fade-item fade-item-3">
                                            <a href="shop-default.html" class="tf-btn btn-dark2 animate-btn">
                                                Shop Now
                                                <i class="icon icon-arr-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slider-wrap bg-type-6 type-image-right">
                    <div class="image">
                        <img src="{{ asset('front_assets/images') }}/slider/electronic/slider-electronic-3.png"
                            data-src="{{ asset('front_assets/images') }}/slider/electronic/slider-electronic-3.png" alt="slider"
                            class="lazyload">
                    </div>
                    <div class="box-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-12 col-sm-6">
                                    <div class="content-slider">
                                        <div class="box-title-slider">
                                            <p class="sub text-md fw-medium fade-item fade-item-1 text-dark-3">
                                                ON-EAR HEADPHONES
                                            </p>
                                            <h2 class="heading fw-medium fade-item fade-item-2 text-dark-3">
                                                Power Up <br> Your Life
                                            </h2>

                                        </div>
                                        <div class="box-btn-slider fade-item fade-item-3">
                                            <a href="shop-default.html" class="tf-btn btn-dark2 animate-btn">
                                                Shop Now
                                                <i class="icon icon-arr-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrap-pagination">
            <div class="container">
                <div class="sw-dots sw-pagination-slider justify-content-center"></div>
            </div>
        </div>
    </div>
</div>
<!-- /Slider -->
<!-- Marquee -->
<div class="marquee-sale bg-light-green-2">
    <div class="marquee-wrapper">
        <div class="initial-child-container">
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">50% Off On Selected Items</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">New Arrival</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <!-- 2 -->
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">50% Off On Selected Items</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">New Arrival</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <!-- 3 -->
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">50% Off On Selected Items</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">New Arrival</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <!-- 4 -->
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">50% Off On Selected Items</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">New Arrival</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <!-- 5 -->
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">50% Off On Selected Items</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">New Arrival</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <!-- 6 -->
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">50% Off On Selected Items</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">New Arrival</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <!-- 7 -->
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">50% Off On Selected Items</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
            <div class="marquee-child-item">
                <p class="display-xs fw-medium">New Arrival</p>
            </div>
            <div class="marquee-child-item"><i class="icon-flash-star"></i></div>
        </div>
    </div>
</div>
<!-- /Marquee -->
<!-- Categories -->
<section class="flat-spacing-3">
    <div class="container">
        <div class="flat-title text-start wow fadeInUp">
            <h4 class="title">Categories</h4>
        </div>
        <div class="wow fadeInUp">
            <div class="fl-control-sw pos3">
                <div dir="ltr" class="swiper tf-swiper" data-swiper='{
                        "slidesPerView": 2,
                        "spaceBetween": 12,
                        "speed": 800,
                        "observer": true,
                        "observeParents": true,
                        "slidesPerGroup": 2,
                        "navigation": {
                            "clickable": true,
                            "nextEl": ".nav-next-categories",
                            "prevEl": ".nav-prev-categories"
                        },
                        "pagination": { "el": ".sw-pagination-categories", "clickable": true },
                        "breakpoints": {
                        "575": { "slidesPerView": 3, "spaceBetween": 12 ,"slidesPerGroup": 3 },
                        "768": { "slidesPerView": 4, "spaceBetween": 12, "slidesPerGroup": 4 },
                        "992": { "slidesPerView": 5, "spaceBetween": 24, "slidesPerGroup": 4 },
                        "1200": { "slidesPerView": 6, "spaceBetween": 24, "slidesPerGroup": 4}
                        }
                    }'>
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            <div class="swiper-slide">
                                <div class="wg-cls style-square hover-img">
                                    <a href="{{ route('frontend.category', $category->slug) }}" class="image img-style d-block">
                                        <img src="{{ asset($category->image) }}"
                                            data-src="{{ asset($category->image) }}" alt="cls"
                                            class="lazyload">
                                    </a>
                                    <div class="cls-content text-center">
                                        <a href="shop-sub-collection.html" class="link text-md fw-medium">{{ $category->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div
                        class="d-flex d-xl-none sw-dot-default sw-pagination-categories justify-content-center">
                    </div>
                </div>
                <div class="swiper-button-next d-none d-xl-flex nav-swiper nav-next-categories"></div>
                <div class="swiper-button-prev d-none d-xl-flex nav-swiper nav-prev-categories"></div>
            </div>
        </div>
    </div>
</section>
<!-- /Categories -->
<!-- Top Pick -->
<section class="flat-spacing-8 bg-surface">
    <div class="container">
        <div class="flat-title style-between align-items-end wow fadeInUp">
            <div class="box-title">
                <h4 class="title">Top Picks You’ll Love</h4>
                <p class="desc text-main text-md">Explore our most popular pieces that customers can't get
                    enough of</p>
            </div>
            <a href="shop-default.html" class="btn-underline">View all</a>
        </div>
        <div class="fl-control-sw">
            <div dir="ltr" class="sw-height swiper tf-swiper" data-swiper='{
                    "slidesPerView": 2,
                    "spaceBetween": 12,
                    "speed": 800,
                    "observer": true,
                    "observeParents": true,
                    "slidesPerGroup": 2,
                    "navigation": {
                        "clickable": true,
                        "nextEl": ".nav-next-top-pick",
                        "prevEl": ".nav-prev-top-pick"
                    },
                    "pagination": { "el": ".sw-pagination-top-pick", "clickable": true },
                    "breakpoints": {
                    "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                    "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                    }
                }'>
                <div class="swiper-wrapper wow fadeInUp">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                        alt="image-product">
                                </a>
                                <div class="on-sale-wrap flex-column type-2">
                                    <span class="on-sale-item">20% Off</span>
                                    <span class="on-sale-item trending">Trending</span>
                                </div>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Apple
                                    AirPods Pro 2 Wireless <br class="d-none d-xl-block"> Earbuds</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$170.00</span>
                                    <span class="price-old old-line">$190.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Red</span>
                                        <span class="swatch-value bg-red-2"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-red.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-red.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg-light-pink-10"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg" alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg" alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Fit
                                    Pro True Wireless Bluetooth Earbuds</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$155.00</span>
                                    <span class=" price-old old-line">$170.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-white.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-white.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg-light-pink-10"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-pink.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-pink.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ss-s21.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ss-s21.jpg" alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ss-s21-grey.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ss-s21-grey.jpg" alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Galaxy
                                    S21 5G 128GB G991U <br class="d-none d-xl-block"> Unlocked Smartphone</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$399.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload" data-src="{{ asset('front_assets/images') }}/products/electronic/ss-s21.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-s21.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Grey</span>
                                        <span class="swatch-value bg-light-grey"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-s21-grey.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-s21-grey.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Orange</span>
                                        <span class="swatch-value bg-light-orange"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-s21-pink.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-s21-pink.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ipad-pro11-mini.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ipad-pro11-mini.jpg"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ipad-pro11-mini.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ipad-pro11-mini.jpg"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Add to Cart</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Apple
                                    iPad Pro 11-inch Wi-Fi (2025, 4th generation)</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$499.00</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- item 5 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg" alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html"
                                    class="name-product link fw-medium text-md">Samsung Galaxy 5 LTE Smart <br
                                        class="d-none d-xl-block"> Watch</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$170.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                        <span class="tooltip">Grey</span>
                                        <span class="swatch-value bg-grey-6"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark-5"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-gray.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-gray.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex d-xl-none sw-dot-default sw-pagination-top-pick justify-content-center">
                </div>
            </div>
            <div class="swiper-button-next d-none d-xl-flex nav-swiper nav-next-top-pick"></div>
            <div class="swiper-button-prev d-none d-xl-flex nav-swiper nav-prev-top-pick"></div>
        </div>
    </div>
</section>
<!-- /Top Pick -->
<!-- Banner Collection-->
<div class="s-banner-colection banner-cls-electric flat-spacing-3">
    <div class="container">
        <div class="banner-content tf-grid-layout tf-col-2 hover-overlay-2">
            <div class="image">
                <img src="{{ asset('front_assets/images') }}/banner/phone.png" alt="{{ asset('front_assets/images') }}/banner/phone.png" class="lazyload">
            </div>
            <div class="box-content">
                <div class="box-title-banner wow fadeInUp">
                    <p class="title display-md fw-medium">
                        Unmatched Performance
                    </p>
                    <p class="sub text-md text-main">
                        Upgrade your devices with cutting-edge technology.
                    </p>
                </div>
                <div class="box-btn-banner wow fadeInUp">
                    <a href="shop-default.html" class="tf-btn btn-dark2 animate-btn">
                        Shop Now
                        <i class="icon icon-arr-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Banner Collection-->
<!-- Hot Deal -->
<section class="bg-surface flat-spacing-8">
    <div class="container">
        <div class="flat-title mb_1 style-between wow fadeInUp">
            <div class="box-title">
                <h4 class="title">Hot Deals</h4>
                <p class="desc text-main text-md">Explore our most popular pieces that customers can't get
                    enough of</p>
            </div>
            <div class="wg-countdown-2">
                <span class="js-countdown" data-timer="46556" data-labels="Days,Hours,Mins,Secs"></span>
            </div>
        </div>
        <div class="fl-control-sw wow fadeInUp">
            <div dir="ltr" class="swiper tf-swiper sw-height" data-swiper='{
                    "slidesPerView": 2,
                    "spaceBetween": 12,
                    "speed": 800,
                    "observer": true,
                    "observeParents": true,
                    "slidesPerGroup": 2,
                    "navigation": {
                        "clickable": true,
                        "nextEl": ".nav-next-deal",
                        "prevEl": ".nav-prev-deal"
                    },
                    "pagination": { "el": ".sw-pagination-deal", "clickable": true },
                    "breakpoints": {
                    "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                    "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                    }
                }'>
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                        alt="image-product">
                                </a>
                                <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="countdown-box style-2">
                                    <div class="js-countdown" data-timer="1007500"
                                        data-labels="D  :,H  :,M  :,S"></div>
                                </div>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Apple
                                    AirPods Pro 2 Wireless Earbuds</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$170.00</span>
                                    <span class="price-old old-line">$190.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item hover-tooltip tooltip-bot color-swatch active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Red</span>
                                        <span class="swatch-value bg-red-2"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-red.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-red.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg-light-pink-10"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                                <div class="product-progress-sale">
                                    <div class="progress-sold progress" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-orange-3" style="width: 90%"></div>
                                    </div>
                                    <p class="text-avaiable text-sm">Available: <span
                                            class="fw-medium text-red-2">2</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg" alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                        alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="countdown-box style-2">
                                    <div class="js-countdown" data-timer="810549"
                                        data-labels="D  :,H  :,M  :,S"></div>
                                </div>
                                <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html"
                                    class="name-product link fw-medium text-md">Samsung Galaxy 5 LTE Smart <br
                                        class="d-none d-xl-block"> Watch</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$210.00</span>
                                    <span class="price-old old-line">$230.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                        <span class="tooltip">Grey</span>
                                        <span class="swatch-value bg-grey-6"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-white.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-gray.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/ss-smart-watch-gray.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                                <div class="product-progress-sale">
                                    <div class="progress-sold progress" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-green-2" style="width: 40%"></div>
                                    </div>
                                    <p class="text-avaiable text-sm">Available: <span
                                            class="fw-medium text-success-5">60</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg" alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg" alt="image-product">
                                </a>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="countdown-box style-2">
                                    <div class="js-countdown" data-timer="1080732"
                                        data-labels="D  :,H  :,M  :,S"></div>
                                </div>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Fit
                                    Pro True Wireless Bluetooth Earbuds</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$155.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-black.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-white.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-white.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg-light-pink-10"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-pink.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/earbuds2-pink.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                                <div class="product-progress-sale">
                                    <div class="progress-sold progress" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-green-2" style="width: 50%"></div>
                                    </div>
                                    <p class="text-avaiable text-sm">Available: <span
                                            class="fw-medium text-success-5">55</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/amazfit-pink.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/amazfit-pink.jpg" alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/amazfit-pink.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/amazfit-pink.jpg" alt="image-product">
                                </a>
                                <ul class="list-product-btn justify-content-start">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="countdown-box style-2">
                                    <div class="js-countdown" data-timer="900610"
                                        data-labels="D  :,H  :,M  :,S"></div>
                                </div>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html"
                                    class="name-product link fw-medium text-md">Amazfit Bip 5 Smart Watch
                                    46mm</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$150.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg-light-pink-10"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/amazfit-pink.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/amazfit-pink.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Sky Blue</span>
                                        <span class="swatch-value bg-sky-blue"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/amazfit-blue.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/amazfit-blue.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                                <div class="product-progress-sale">
                                    <div class="progress-sold progress" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-orange-3" style="width: 70%"></div>
                                    </div>
                                    <p class="text-avaiable text-sm">Available: <span
                                            class="fw-medium text-red-2">20</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 5 -->
                    <div class="swiper-slide">
                        <div class="card-product style-center">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="img-product lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                        alt="image-product">
                                    <img class="img-hover lazyload"
                                        data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                        src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                        alt="image-product">
                                </a>
                                <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                                <ul class="list-product-btn">
                                    <li>
                                        <a href="#quickAdd" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#quickView" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon quickview">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </li>
                                    <li class="compare">
                                        <a href="#compare" data-bs-toggle="modal"
                                            class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="countdown-box style-2">
                                    <div class="js-countdown" data-timer="1007500"
                                        data-labels="D  :,H  :,M  :,S"></div>
                                </div>
                            </div>
                            <div class="card-product-info text-center">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Apple
                                    AirPods Pro 2 Wireless Earbuds</a>
                                <p class="price-wrap fw-medium">
                                    <span class="price-new">$170.00</span>
                                    <span class="price-old old-line">$190.00</span>
                                </p>
                                <ul class="list-color-product justify-content-center">
                                    <li class="list-color-item hover-tooltip tooltip-bot color-swatch active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-black.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Red</span>
                                        <span class="swatch-value bg-red-2"></span>
                                        <img class="lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-red.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-red.jpg"
                                            alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg-light-pink-10"></span>
                                        <img class=" lazyload"
                                            data-src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                            src="{{ asset('front_assets/images') }}/products/electronic/airpod-pro-pink.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                                <div class="product-progress-sale">
                                    <div class="progress-sold progress" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar bg-orange-3" style="width: 90%"></div>
                                    </div>
                                    <p class="text-avaiable text-sm">Available: <span
                                            class="fw-medium text-red-2">2</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex d-xl-none sw-dot-default sw-pagination-deal justify-content-center"></div>
            </div>
            <div class="swiper-button-next d-none d-xl-flex nav-swiper nav-next-deal"></div>
            <div class="swiper-button-prev d-none d-xl-flex nav-swiper nav-prev-deal"></div>
        </div>
    </div>
</section>
<!-- /Hot Deal -->
<!-- Testimonial -->
<section class="flat-spacing-2 pb-0">
    <div class="container">
        <div class="flat-title text-start wow fadeInUp">
            <h4 class="title">Happy Customers</h4>
        </div>
        <div dir="ltr" class="swiper tf-swiper" data-swiper='{
                "slidesPerView": 1,
                "spaceBetween": 12,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "slidesPerGroup": 1,
                "pagination": { "el": ".sw-pagination-tes", "clickable": true },
                "breakpoints": {
                "768": { "slidesPerView": 2, "spaceBetween": 24, "slidesPerGroup": 2 },
                "1200": { "slidesPerView": 3, "spaceBetween": 24, "slidesPerGroup": 3}
                }
            }'>
            <div class="swiper-wrapper">
                <!-- item 1 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial wow fadeInLeft">
                        <div class="content">
                            <div class="content-top">
                                <div class="box-author">
                                    <p class="name-author text-sm fw-medium">Emily T.</p>
                                    <div class="box-verified text-main">
                                        <i class="icon-verifi"></i>
                                        <p class="text-xs fst-italic">
                                            Verified Buyer
                                        </p>
                                    </div>
                                </div>
                                <div class="list-star-default">
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                </div>
                                <p class="text-review text-sm text-main">
                                    The quality of the electronics exceeded my expectations. Every device feels
                                    premium, and the performance is outstanding. I'm absolutely impressed.
                                </p>
                            </div>
                            <span class="br-line d-block"></span>
                            <div class="box-avt">
                                <div class="avatar">
                                    <img src="{{ asset('front_assets/images') }}/testimonial/author/author-electric1.jpg" alt="author">
                                </div>
                                <div class="box-price">
                                    <p class="name-item text-xs">
                                        <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                            <span class="fw-medium text-sm link">Instax Mini 12 Camera</span>
                                        </a>
                                    </p>
                                    <p class="price text-md fw-medium">
                                        $130.00
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- item 2 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="content">
                            <div class="content-top">
                                <div class="box-author">
                                    <p class="name-author text-sm fw-medium">Jessica M.</p>
                                    <div class="box-verified text-main">
                                        <i class="icon-verifi"></i>
                                        <p class="text-xs fst-italic">
                                            Verified Buyer
                                        </p>
                                    </div>
                                </div>
                                <div class="list-star-default">
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                </div>
                                <p class="text-review text-sm text-main">
                                    I love the gadget I purchased! The build quality is excellent, and the
                                    performance is top-notch. I’ve gotten so many compliments on it. Will
                                    definitely shop here again!
                                </p>
                            </div>
                            <span class="br-line d-block"></span>
                            <div class="box-avt">
                                <div class="avatar">
                                    <img src="{{ asset('front_assets/images') }}/testimonial/author/author-electric2.jpg" alt="author">
                                </div>
                                <div class="box-price">
                                    <p class="name-item text-xs">
                                        <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                            <span class="fw-medium text-sm link">Wi-Fi Video Doorbell</span>
                                        </a>
                                    </p>
                                    <p class="price text-md fw-medium">
                                        $150.00
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- item 3 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="content">
                            <div class="content-top">
                                <div class="box-author">
                                    <p class="name-author text-sm fw-medium">Lisa P.</p>
                                    <div class="box-verified text-main">
                                        <i class="icon-verifi"></i>
                                        <p class="text-xs fst-italic">
                                            Verified Buyer
                                        </p>
                                    </div>
                                </div>
                                <div class="list-star-default">
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                </div>
                                <p class="text-review text-sm text-main">
                                    I was pleasantly surprised by how fast my order arrived. The customer
                                    service team was helpful and responsive. Great shopping experience!
                                </p>
                            </div>
                            <span class="br-line d-block"></span>
                            <div class="box-avt">
                                <div class="avatar">
                                    <img src="{{ asset('front_assets/images') }}/testimonial/author/author-electric3.jpg" alt="author">
                                </div>
                                <div class="box-price">
                                    <p class="name-item text-xs">
                                        <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                            <span class="fw-medium text-sm link">Amazfit Bip 5 Smart Watch
                                                46mm</span> </a>
                                    </p>
                                    <p class="price text-md fw-medium">
                                        $120.00
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- item 4 -->
                <div class="swiper-slide">
                    <div class="wg-testimonial wow fadeInLeft">
                        <div class="content">
                            <div class="content-top">
                                <div class="box-author">
                                    <p class="name-author text-sm fw-medium">InvenPro P.</p>
                                    <div class="box-verified text-main">
                                        <i class="icon-verifi"></i>
                                        <p class="text-xs fst-italic">
                                            Verified Buyer
                                        </p>
                                    </div>
                                </div>
                                <div class="list-star-default">
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                </div>
                                <p class="text-review text-sm text-main">
                                    The quality of the electronics exceeded my expectations. Every device feels
                                    premium, and the performance is outstanding. I'm absolutely impressed.
                                </p>
                            </div>
                            <span class="br-line d-block"></span>
                            <div class="box-avt">
                                <div class="avatar">
                                    <img src="{{ asset('front_assets/images') }}/testimonial/author/author-electric1.jpg" alt="author">
                                </div>
                                <div class="box-price">
                                    <p class="name-item text-xs">
                                        <a href="product-detail.html" class="text-line-clamp-2">Item purchased:
                                            <span class="fw-medium text-sm link">Instax Mini 12 Camera</span>
                                        </a>
                                    </p>
                                    <p class="price text-md fw-medium">
                                        $130.00
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="sw-dot-default sw-pagination-tes justify-content-center"></span>
        </div>
    </div>
</section>
<!-- /Testimonial -->
<!-- Brand -->
<div class="flat-spacing-2">
    <div class="container">
        <div dir="ltr" class="swiper tf-swiper sw-brand" data-swiper='{
                "slidesPerView": 2,
                "spaceBetween": 0,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "slidesPerGroup": 2,
                "pagination": { "el": ".sw-pagination-brand", "clickable": true },
                "breakpoints": {
                "575": { "slidesPerView": 3},
                "991": { "slidesPerView": 4},
                "1200": { "slidesPerView": 6}
                }
            }'>
            <div class="swiper-wrapper">
                @foreach ($brands as $brand)
                    <div class="swiper-slide">
                        <div class="brand-item wow fadeInLeft d-flex justify-content-center">
                            <img src="{{ $brand->imageURL }}" alt="{{ $brand->title }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex d-xl-none sw-dot-default sw-pagination-brand justify-content-center"></div>
    </div>
</div>
<!-- /Brand -->

@endsection