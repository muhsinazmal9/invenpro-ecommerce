@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ 'Dashboard' }}</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Dashboard' }}
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
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon purple">
                            <i class="lni lni-cart-full"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">{{ __('app.new_orders') }}</h6>
                            <h3 class="text-bold mb-10">{{ $newOrder }}</h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon success">
                            <i class="lni lni-dollar"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">{{ __('app.total_income') }}</h6>
                            <h3 class="text-bold mb-10">{{ getSetting('currency_symbol').number_format($totalIncome, 2) }}</h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon primary">
                            <i class="lni lni-credit-cards"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">{{ __('app.total_expense') }}</h6>
                            <h3 class="text-bold mb-10">0</h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon orange">
                            <i class="lni lni-user"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">{{ __('app.total_customer') }}</h6>
                            <h3 class="text-bold mb-10">{{ $totalCustomer }}</h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->

             {{--  top selling end  --}}
                 {{--  sale Revenue start  --}}
                 
            <div class="row">
                <div class=" col-xl-7">
                @include('backend.dashboard.partials.order_details')

            </div>

            <div class=" col-xl-5">
                @include('backend.dashboard.partials.sale_revenue')
            </div>

            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-5">
                        @include('backend.dashboard.partials.user_activity')
                    </div>
                    <div class="col-md-7">
                        @include('backend.dashboard.partials.top_products')
                    </div>
                    
                </div>
                
              </div>
            
            <div class=" col-12">
                <div class="row">
                    <div class="col-md-6">
                        @include('backend.dashboard.partials.todays_transactions')
                    </div>
                    <div class="col-md-6">
                        @include('backend.dashboard.partials.reviews_details')
                    </div>
                </div>
                
            </div>
        </div>
        <!-- end container -->
    </section>

    <!-- ========== section end ========== -->
@endsection

