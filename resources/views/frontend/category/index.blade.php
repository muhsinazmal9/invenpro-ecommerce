@extends('layouts.frontend.main-layout')

@section('title', $category->name)

@section('content')
    {{-- <!-- Sub Collection -->
    <div class="flat-spacing-24">
        <div class="container-6">
            <div dir="ltr" class="swiper tf-swiper" data-swiper='{
                "slidesPerView": 3,
                "spaceBetween": 12,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "slidesPerGroup": 3,
                "navigation": {
                    "clickable": true,
                    "nextEl": ".nav-next-cls",
                    "prevEl": ".nav-prev-cls"
                },
                "pagination": { "el": ".sw-pagination-cls", "clickable": true },
                "breakpoints": {
                "575": { "slidesPerView": 5, "spaceBetween": 12 ,"slidesPerGroup": 3 },    
                "768": { "slidesPerView": 6, "spaceBetween": 24, "slidesPerGroup": 3 },
                "1200": { "slidesPerView": 8, "spaceBetween": 45, "slidesPerGroup": 3}
                }
            }'>
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md hover-img">
                            <a href="shop-default.html" class="image img-style d-block">
                                <img src="images/cls-categories/fashion/circle-new-arrival.jpg"
                                    data-src="images/cls-categories/fashion/circle-new-arrival.jpg" alt="categories"
                                    class="lazyload">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">New Arrivals</a>
                            </div>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md hover-img">
                            <a href="shop-default.html" class="image img-style d-block">
                                <img src="images/cls-categories/fashion/circle-top-rate.jpg"
                                    data-src="images/cls-categories/fashion/circle-top-rate.jpg" alt="categories"
                                    class="lazyload">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">Top Rated</a>
                            </div>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md hover-img">
                            <a href="shop-default.html" class="image img-style d-block">
                                <img src="images/cls-categories/fashion/circle-seller.jpg"
                                    data-src="images/cls-categories/fashion/circle-seller.jpg" alt="categories"
                                    class="lazyload">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">Best sellers</a>
                            </div>
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md hover-img">
                            <a href="shop-default.html" class="image img-style d-block">
                                <img src="images/cls-categories/fashion/circle-trending.jpg"
                                    data-src="images/cls-categories/fashion/circle-trending.jpg" alt="categories"
                                    class="lazyload">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">Trendings</a>
                            </div>
                        </div>
                    </div>
                    <!-- item 5 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md hover-img">
                            <a href="shop-default.html" class="image img-style d-block">
                                <img src="images/cls-categories/fashion/circle-men.jpg"
                                    data-src="images/cls-categories/fashion/circle-men.jpg" alt="categories"
                                    class="lazyload">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">Mens</a>
                            </div>
                        </div>
                    </div>
                    <!-- item 6 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md hover-img">
                            <a href="shop-default.html" class="image img-style d-block">
                                <img src="images/cls-categories/fashion/circle-women.jpg"
                                    data-src="images/cls-categories/fashion/circle-women.jpg" alt="categories"
                                    class="lazyload">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">Womens</a>
                            </div>
                        </div>
                    </div>
                    <!-- item 7 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md hover-img">
                            <a href="shop-default.html" class="image img-style d-block">
                                <img src="images/cls-categories/fashion/circle-promotion.jpg"
                                    data-src="images/cls-categories/fashion/circle-promotion.jpg" alt="categories"
                                    class="lazyload">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">Promotions</a>
                            </div>
                        </div>
                    </div>
                    <!-- item 8 -->
                    <div class="swiper-slide">
                        <div class="wg-cls style-circle-md">
                            <a href="shop-default.html" class="image shop-all">
                                <img src="images/logo/logo.svg" alt="">
                            </a>
                            <div class="cls-content text-center">
                                <a href="shop-default.html" class="link text-sm fw-medium">Shop All</a>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="d-flex d-xl-none sw-dot-default sw-pagination-cls justify-content-center"></span>
            </div>
        </div>
    </div>
    <!-- /Sub Collection --> --}}
    <!-- Breadcrumb -->
    <div class="tf-breadcrumb mt-0">
        <div class="container">
            <ul class="breadcrumb-list">
                <li class="item-breadcrumb">
                    <a href="index.html" class="text">Home</a>
                </li>
                <li class="item-breadcrumb dot">
                    <span></span>
                </li>
                <li class="item-breadcrumb">
                    <a href="shop-collection-list.html" class="text">Categories</a>
                </li>
                <li class="item-breadcrumb dot">
                    <span></span>
                </li>
                <li class="item-breadcrumb">
                    <span class="text">{{ $category->name }}</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breadcrumb -->
    <!-- Title Page -->
    <section class="page-title flat-spacing-4 pt-0">
        <div class="container">
            <div class="box-title text-center justify-items-center">
                <h4 class="title">{{ $category->name }}</h4>
                <p class="text-main text-md">{{ $category->description }}</p>
            </div>
        </div>
    </section>
    <!-- /Title Page -->
    {{-- <!-- Section Product -->
    <section class="flat-spacing-2 pt-0">
        <div class="container">
            <div class="tf-shop-control">
                <div class="tf-group-filter">
                    <a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="filterShop"
                        class="tf-btn-filter">
                        <span class="icon icon-filter"></span><span class="text">Filter</span></a>
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">Best selling</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="select-item active" data-sort-value="best-selling">
                                <span class="text-value-item">Best selling</span>
                            </div>
                            <div class="select-item" data-sort-value="a-z">
                                <span class="text-value-item">Alphabetically, A-Z</span>
                            </div>
                            <div class="select-item" data-sort-value="z-a">
                                <span class="text-value-item">Alphabetically, Z-A</span>
                            </div>
                            <div class="select-item" data-sort-value="price-low-high">
                                <span class="text-value-item">Price, low to high</span>
                            </div>
                            <div class="select-item" data-sort-value="price-high-low">
                                <span class="text-value-item">Price, high to low</span>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="tf-control-layout">
                    <li class="tf-view-layout-switch sw-layout-list list-layout" data-value-layout="list">
                        <div class="item icon-list">
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-2" data-value-layout="tf-col-2">
                        <div class="item icon-grid-2">
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-3" data-value-layout="tf-col-3">
                        <div class="item icon-grid-3">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-4 active" data-value-layout="tf-col-4">
                        <div class="item icon-grid-4">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="wrapper-control-shop">
                <div class="meta-filter-shop">
                    <div id="product-count-grid" class="count-text"></div>
                    <div id="product-count-list" class="count-text"></div>
                    <div id="applied-filters"></div>
                    <button id="remove-all" class="remove-all-filters" style="display: none;"><i
                            class="icon icon-close"></i> Clear all filter</button>
                </div>
                <div class="tf-list-layout wrapper-shop" id="listLayout" style="display: none;">
                    <!-- Card Product 1 -->
                    <div class="card-product style-list" data-availability="In stock" data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-16.jpg"
                                    src="images/products/fashion/product-16.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-9.jpg"
                                    src="images/products/fashion/product-9.jpg" alt="image-product">
                            </a>
                            <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Graphic
                                    Printed Pure Cotton T-shirt</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$50.00</span>
                                    <span class="price-old">$70.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Yellow</span>
                                        <span class="swatch-value bg-light-orange-2"></span>
                                        <img class="lazyload" data-src="images/products/fashion/product-16.jpg"
                                            src="images/products/fashion/product-16.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class=" lazyload" data-src="images/products/fashion/product-9.jpg"
                                            src="images/products/fashion/product-9.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class=" lazyload" data-src="images/products/fashion/product-4.jpg"
                                            src="images/products/fashion/product-7.jpg" alt="image-product">
                                    </li>
                                </ul>
                                <ul class="size-box">
                                    <li class="size-item text-xs">S</li>
                                    <li class="size-item text-xs">M</li>
                                    <li class="size-item text-xs">L</li>
                                    <li class="size-item text-xs">XL</li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal"
                                    class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 2 -->
                    <div class="card-product style-list" data-availability="In stock" data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-17.jpg"
                                    src="images/products/fashion/product-17.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-19.jpg"
                                    src="images/products/fashion/product-19.jpg" alt="image-product">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Graphic
                                    Printed Drop Shoulder Sleeves</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$80.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip line active">
                                        <span class="tooltip color-filter">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class="lazyload" data-src="images/products/fashion/product-17.jpg"
                                            src="images/products/fashion/product-17.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Dark Green</span>
                                        <span class="swatch-value bg-dark-green"></span>
                                        <img class=" lazyload" data-src="images/products/fashion/product-21.jpg"
                                            src="images/products/fashion/product-21.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class="lazyload" data-src="images/products/fashion/product-19.jpg"
                                            src="images/products/fashion/product-19.jpg" alt="image-product">
                                    </li>
                                </ul>
                                <ul class="size-box">
                                    <li class="size-item text-xs">S</li>
                                    <li class="size-item text-xs">M</li>
                                    <li class="size-item text-xs">L</li>
                                    <li class="size-item text-xs">XL</li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal"
                                    class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 3 -->
                    <div class="card-product style-list" data-availability="In stock" data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload"
                                    data-src="images/products/fashion/women-grey-2.jpg"
                                    src="images/products/fashion/women-grey-2.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/women-grey-1.jpg"
                                    src="images/products/fashion/women-grey-1.jpg" alt="image-product">
                            </a>
                            <div class="on-sale-wrap"><span class="on-sale-item">10% Off</span></div>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Women
                                    Solid Scoop Neck Slim Fit T-shirt</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$80.00</span>
                                    <span class="price-old">$90.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class="lazyload" data-src="images/products/fashion/women-grey-2.jpg"
                                            src="images/products/fashion/women-grey-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Yellow</span>
                                        <span class="swatch-value bg-yellow"></span>
                                        <img class="lazyload" data-src="images/products/fashion/women-yellow-2.jpg"
                                            src="images/products/fashion/women-yellow-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Light Grey</span>
                                        <span class="swatch-value bg-light-blue-2"></span>
                                        <img class="lazyload"
                                            data-src="images/products/fashion/women-light-blue-1.jpg"
                                            src="images/products/fashion/women-light-blue-1.jpg"
                                            alt="image-product">
                                    </li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal"
                                    class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 4 -->
                    <div class="card-product style-list" data-availability="Out of stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-18.jpg"
                                    src="images/products/fashion/product-18.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-12.jpg"
                                    src="images/products/fashion/product-12.jpg" alt="image-product">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Asymmetric
                                    Neck Tank Top</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$85.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Light Orange</span>
                                        <span class="swatch-value bg-light-orange"></span>
                                        <img class="lazyload" data-src="images/products/fashion/product-18.jpg"
                                            src="images/products/fashion/product-18.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Black</span>
                                        <span class="swatch-value bg-dark"></span>
                                        <img class="lazyload" data-src="images/products/fashion/women-black-6.jpg"
                                            src="images/products/fashion/women-black-6.jpg" alt="image-product">
                                    </li>

                                </ul>
                                <ul class="size-box">
                                    <li class="size-item text-xs">S</li>
                                    <li class="size-item text-xs">M</li>
                                    <li class="size-item text-xs">L</li>
                                    <li class="size-item text-xs">XL</li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product animate-btn add-to-cart">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal"
                                    class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Card Product 5 -->
                    <div class="card-product style-list" data-availability="Out of stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-15.jpg"
                                    src="images/products/fashion/product-15.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-1.jpg"
                                    src="images/products/fashion/product-1.jpg" alt="image-product">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <div class="info-list">
                                <a href="product-detail.html" class="name-product link fw-medium text-md">Short
                                    Sleeve Sweat</a>
                                <p class="price-wrap fw-medium text-md">
                                    <span class="price-new">$55.00</span>
                                </p>
                                <p class="desc text-sm text-main text-line-clamp-2">
                                    Product Specifications Care for fiber: 30% more recycled polyester. We label
                                    garments
                                    manufactured using environmentally friendly technologies and raw materials with
                                    the
                                    Join
                                    Life label.
                                </p>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch hover-tooltip active">
                                        <span class="tooltip color-filter">Light Pink</span>
                                        <span class="swatch-value bg-light-pink-4"></span>
                                        <img class="lazyload" data-src="images/products/fashion/product-15.jpg"
                                            src="images/products/fashion/product-15.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip line">
                                        <span class="tooltip color-filter">White</span>
                                        <span class="swatch-value bg-white"></span>
                                        <img class="lazyload" data-src="images/products/fashion/product-1.jpg"
                                            src="images/products/fashion/product-1.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch hover-tooltip">
                                        <span class="tooltip color-filter">Light Grey</span>
                                        <span class="swatch-value bg-grey-4"></span>
                                        <img class="lazyload" data-src="images/products/fashion/product-19.jpg"
                                            src="images/products/fashion/product-19.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                            <div class="list-product-btn">
                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                    class="tf-btn btn-main-product add-to-cart animate-btn">Add
                                    To
                                    cart</a>
                                <a href="javascript:void(0);" class="box-icon wishlist hover-tooltip">
                                    <span class="icon icon-heart2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                                <a href="#quickView" data-bs-toggle="modal"
                                    class="box-icon hover-tooltip quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                    class="box-icon compare hover-tooltip">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Pagination -->
                    <ul class="wg-pagination">
                        <li class="active">
                            <div class="pagination-item">1</div>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">2</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">3</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item"><i class="icon-arr-right2"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                    <!-- Card Product 1 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-19.jpg"
                                    src="images/products/fashion/product-19.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/women-grey-2.jpg"
                                    src="images/products/fashion/women-grey-2.jpg" alt="image-product">
                            </a>
                            <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="hover-tooltip tooltip-left box-icon quickview">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">XS</li>
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                                <li class="size-item text-xs text-white">XL</li>
                                <li class="size-item text-xs text-white">2XL</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Loose Fit
                                Tee</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$120.00</span>
                                <span class="price-old">$150.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item hover-tooltip tooltip-bot color-swatch active">
                                    <span class="tooltip color-filter">Grey</span>
                                    <span class="swatch-value bg-grey-4"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-19.jpg"
                                        src="images/products/fashion/product-19.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-9.jpg"
                                        src="images/products/fashion/product-9.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot line">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-4.jpg"
                                        src="images/products/fashion/product-4.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 2 -->
                    <div class="card-product grid out-of-stock" data-availability="Out of stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-2.jpg"
                                    src="images/products/fashion/product-2.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-2.jpg"
                                    src="images/products/fashion/product-2.jpg" alt="image-product">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Regular Fit
                                Pima Cotton Polo Shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$130.00</span>
                            </p>

                        </div>
                    </div>
                    <!-- Card Product 3 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-3.jpg"
                                    src="images/products/fashion/product-3.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-4.jpg"
                                    src="images/products/fashion/product-4.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="hover-tooltip tooltip-left box-icon quickview">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="countdown-box">
                                <div class="js-countdown" data-timer="1007500" data-labels="D  :,H  :,M  :,S"></div>
                            </div>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                                <li class="size-item text-xs text-white">XL</li>
                            </ul>
                            <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Long Regular
                                Fit Tee</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$60.00</span>
                                <span class="price-old">$70.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Yellow</span>
                                    <span class="swatch-value bg-yellow"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-3.jpg"
                                        src="images/products/fashion/product-3.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Grey</span>
                                    <span class="swatch-value bg-grey-4"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-6.jpg"
                                        src="images/products/fashion/product-6.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot line">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-4.jpg"
                                        src="images/products/fashion/product-4.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 4 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-17.jpg"
                                    src="images/products/fashion/product-17.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-1.jpg"
                                    src="images/products/fashion/product-1.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Regular Fit
                                Pima Cotton Polo Shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$80.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch active hover-tooltip tooltip-bot line">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-17.jpg"
                                        src="images/products/fashion/product-17.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Orange</span>
                                    <span class="swatch-value bg-light-orange"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-16.jpg"
                                        src="images/products/fashion/product-16.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Grey</span>
                                    <span class="swatch-value bg-grey-4"></span>
                                    <img class="lazyload" data-src="images/products/fashion/product-5.jpg"
                                        src="images/products/fashion/product-5.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 5 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-25.jpg"
                                    src="images/products/fashion/product-25.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-24.jpg"
                                    src="images/products/fashion/product-24.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">XS</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">XL</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Midi Knit
                                Dress</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$40.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch active hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Beige</span>
                                    <span class="swatch-value bg-beige"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-25.jpg"
                                        src="images/products/fashion/product-25.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-22.jpg"
                                        src="images/products/fashion/product-22.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Grey</span>
                                    <span class="swatch-value bg-grey-4"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/women-grey-2.jpg"
                                        src="images/products/fashion/women-grey-2.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 6 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-6.jpg"
                                    src="images/products/fashion/product-6.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-21.jpg"
                                    src="images/products/fashion/product-21.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">XS</li>
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Oversized Fit
                                Tee</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$60.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot line active">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-6.jpg"
                                        src="images/products/fashion/product-6.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Dark Green</span>
                                    <span class="swatch-value bg-dark-green"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-21.jpg"
                                        src="images/products/fashion/product-21.jpg" alt="image-product">
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 7 -->
                    <div class="card-product grid" data-availability="In stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload"
                                    data-src="images/products/fashion/women-yellow-2.jpg"
                                    src="images/products/fashion/women-yellow-2.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-28.jpg"
                                    src="images/products/fashion/product-28.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Puff Sleeve
                                Shirred Blouse</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$57.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Yellow</span>
                                    <span class="swatch-value bg-yellow-2"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/women-yellow-2.jpg"
                                        src="images/products/fashion/women-yellow-2.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Orange</span>
                                    <span class="swatch-value bg-light-orange-2"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-28.jpg"
                                        src="images/products/fashion/product-28.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Beige</span>
                                    <span class="swatch-value bg-beige"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-7.jpg"
                                        src="images/products/fashion/product-7.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 8 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-26.jpg"
                                    src="images/products/fashion/product-26.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-26.jpg"
                                    src="images/products/fashion/product-26.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Printed
                                T-shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$120.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch line hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-26.jpg"
                                        src="images/products/fashion/product-26.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Grey</span>
                                    <span class="swatch-value bg-grey-4"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/women-grey-1.jpg"
                                        src="images/products/fashion/women-grey-1.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/women-black-6.jpg"
                                        src="images/products/fashion/women-black-6.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 9 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-27.jpg"
                                    src="images/products/fashion/product-27.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-23.jpg"
                                    src="images/products/fashion/product-23.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                                <li class="size-item text-xs text-white">XL</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Basic Sports
                                T-Shirt Crew Neck Ribbed</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">80.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Light Purple</span>
                                    <span class="swatch-value bg-light-purple-3"></span>
                                    <img class="lazyload" data-src="images/products/fashion/product-27.jpg"
                                        src="images/products/fashion/product-27.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Grey</span>
                                    <span class="swatch-value bg-grey-4"></span>
                                    <img class="lazyload" data-src="images/products/fashion/product-11.jpg"
                                        src="images/products/fashion/product-11.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Orange</span>
                                    <span class="swatch-value bg-light-orange"></span>
                                    <img class="lazyload" data-src="images/products/fashion/product-12.jpg"
                                        src="images/products/fashion/product-12.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 10 -->
                    <div class="card-product grid" data-availability="In stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-10.jpg"
                                    src="images/products/fashion/product-10.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-20.jpg"
                                    src="images/products/fashion/product-20.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Regular Fit
                                Fine Knit Polo Shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$130.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Light Blue</span>
                                    <span class="swatch-value bg-light-blue-2"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-10.jpg"
                                        src="images/products/fashion/product-10.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-13.jpg"
                                        src="images/products/fashion/product-13.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Purple</span>
                                    <span class="swatch-value bg-light-purple"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-14.jpg"
                                        src="images/products/fashion/product-14.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 11 -->
                    <div class="card-product grid" data-availability="In stock" data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-21.jpg"
                                    src="images/products/fashion/product-21.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/women-black-3.jpg"
                                    src="images/products/fashion/women-black-3.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Crop College
                                T-Shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$82.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Dark Green</span>
                                    <span class="swatch-value bg-dark-green"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-21.jpg"
                                        src="images/products/fashion/product-21.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/women-black-3.jpg"
                                        src="images/products/fashion/women-black-3.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Purple</span>
                                    <span class="swatch-value bg-light-purple-3"></span>
                                    <img class="lazyload" data-src="images/products/fashion/product-23.jpg"
                                        src="images/products/fashion/product-23.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 12 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-22.jpg"
                                    src="images/products/fashion/product-22.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-5.jpg"
                                    src="images/products/fashion/product-5.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">XS</li>
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                                <li class="size-item text-xs text-white">XL</li>
                                <li class="size-item text-xs text-white">2XL</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Bow-Tie
                                T-Shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$92.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-22.jpg"
                                        src="images/products/fashion/product-22.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Beige</span>
                                    <span class="swatch-value bg-beige"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-5.jpg"
                                        src="images/products/fashion/product-5.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip line tooltip-bot">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-1.jpg"
                                        src="images/products/fashion/product-1.jpg" alt="image-product">
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 13 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-13.jpg"
                                    src="images/products/fashion/product-13.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-14.jpg"
                                    src="images/products/fashion/product-14.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">L</li>
                                <li class="size-item text-xs text-white">XL</li>
                                <li class="size-item text-xs text-white">2XL</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">COOLMAX® Loose
                                Fit Tee</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$66.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-13.jpg"
                                        src="images/products/fashion/product-13.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Purple</span>
                                    <span class="swatch-value bg-purple-3"></span>
                                    <img class="lazyload" data-src="images/products/fashion/product-14.jpg"
                                        src="images/products/fashion/product-14.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 14 -->
                    <div class="card-product grid card-product-size" data-availability="In stock"
                        data-brand="Vineta">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-20.jpg"
                                    src="images/products/fashion/product-20.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-9.jpg"
                                    src="images/products/fashion/product-9.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">XS</li>
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                                <li class="size-item text-xs text-white">XL</li>
                                <li class="size-item text-xs text-white">2XL</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Long Sleeve
                                T-Shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$100.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Black</span>
                                    <span class="swatch-value bg-dark"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-20.jpg"
                                        src="images/products/fashion/product-20.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Orange</span>
                                    <span class="swatch-value bg-light-orange"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-16.jpg"
                                        src="images/products/fashion/product-16.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch line hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-1.jpg"
                                        src="images/products/fashion/product-1.jpg" alt="image-product">
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 15 -->
                    <div class="card-product grid card-product-size" data-availability="Out of stock"
                        data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-7.jpg"
                                    src="images/products/fashion/product-7.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-11.jpg"
                                    src="images/products/fashion/product-11.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="size-box">
                                <li class="size-item text-xs text-white">S</li>
                                <li class="size-item text-xs text-white">M</li>
                                <li class="size-item text-xs text-white">L</li>
                                <li class="size-item text-xs text-white">XL</li>
                                <li class="size-item text-xs text-white">2XL</li>
                            </ul>

                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Muscle Fit
                                Polo Shirt</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$111.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                    <span class="tooltip color-filter">Beige</span>
                                    <span class="swatch-value bg-beige"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-7.jpg"
                                        src="images/products/fashion/product-7.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch line hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-11.jpg"
                                        src="images/products/fashion/product-11.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Orange</span>
                                    <span class="swatch-value bg-light-orange"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-18.jpg"
                                        src="images/products/fashion/product-18.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card Product 16 -->
                    <div class="card-product grid" data-availability="Out of stock" data-brand="Zotac">
                        <div class="card-product-wrapper">
                            <a href="product-detail.html" class="product-img">
                                <img class="img-product lazyload" data-src="images/products/fashion/product-17.jpg"
                                    src="images/products/fashion/product-16.jpg" alt="image-product">
                                <img class="img-hover lazyload" data-src="images/products/fashion/product-26.jpg"
                                    src="images/products/fashion/product-26.jpg" alt="image-product">
                            </a>
                            <ul class="list-product-btn">
                                <li>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li>
                                <li class="wishlist">
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#quickView" data-bs-toggle="modal"
                                        class="box-icon quickview hover-tooltip tooltip-left">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Quick View</span>
                                    </a>
                                </li>
                                <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                        class="box-icon hover-tooltip tooltip-left">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-product-info">
                            <a href="product-detail.html" class="name-product link fw-medium text-md">Graphic
                                Printed Drop Shoulder Sleeves</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new">$88.00</span>
                            </p>
                            <ul class="list-color-product">
                                <li class="list-color-item color-swatch hover-tooltip line tooltip-bot active">
                                    <span class="tooltip color-filter">White</span>
                                    <span class="swatch-value bg-white"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-17.jpg"
                                        src="images/products/fashion/product-17.jpg" alt="image-product">
                                </li>
                                <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                    <span class="tooltip color-filter">Light Purple</span>
                                    <span class="swatch-value bg-light-purple-3"></span>
                                    <img class=" lazyload" data-src="images/products/fashion/product-23.jpg"
                                        src="images/products/fashion/product-23.jpg" alt="image-product">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <ul class="wg-pagination">
                        <li class="active">
                            <div class="pagination-item">1</div>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">2</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item">3</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-item"><i class="icon-arr-right2"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- /Section Product --> --}}
@endsection
