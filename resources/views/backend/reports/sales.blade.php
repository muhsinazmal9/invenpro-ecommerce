@extends('backend.layouts.app')
@section('title', 'Sales Report')
@section('content')

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ 'Sales Report' }}</h2>
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
                                        {{ 'Sales Report' }}
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
                <div class="col-md-4">
                    <div class="icon-card mb-30">
                        <div class="icon purple">
                            <i class="lni lni-cart-full"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">{{ 'Total Orders' }}</h6>
                            <h3 class="text-bold mb-10"> {{ $totalOrders }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-card mb-30">
                        <div class="icon purple">
                            <i class="lni lni-cart-full"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">{{ 'Todays Sales' }}</h6>
                            <h3 class="text-bold mb-10"> {{ getSetting('currency_symbol').number_format($todaysSales,2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-card mb-30">
                        <div class="icon purple">
                            <i class="lni lni-cart-full"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">{{ 'Total Sales' }}</h6>
                            <h3 class="text-bold mb-10"> {{ getSetting('currency_symbol').number_format($totalSales,2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row my-2">
                        <div class="col-2">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ 'Export' }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item send-quotation" href="{{ route('admin.reports.sales.export','xlsx') }}">{{ 'Excel' }}</a></li>
                                    <li><a class="dropdown-item send-confirmation" href="{{ route('admin.reports.sales.export','csv') }}">{{ 'CSV' }}</a></li>
                                    <li><a class="dropdown-item send-confirmation" href="{{ route('admin.reports.sales.export','pdf') }}">{{ 'PDF' }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @include('backend.reports.partials.sales_table')
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

@endsection
