@extends('backend.layouts.app')
@section('title', 'Transaction Report')
@section('content')

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>Transaction Report</h2>
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
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Transaction Report
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
                    
                    <div class="mb-2 d-flex justify-content-between">
                       
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Export
                            </button>
                            @php
                                $exportToXlsx = route('admin.reports.transactions.export','xlsx');
                                $exportToCsv = route('admin.reports.transactions.export','csv');
                                $exportToPdf = route('admin.reports.transactions.export','pdf');

                                if(request()->status == 'success'){
                                    $exportToXlsx = route('admin.reports.transactions.export','xlsx').'?status=success';
                                    $exportToCsv = route('admin.reports.transactions.export','csv').'?status=success';
                                    $exportToPdf = route('admin.reports.transactions.export','pdf').'?status=success';
                                }
                            @endphp
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item send-quotation" href="{{ $exportToXlsx }}">Excel</a></li>
                                <li><a class="dropdown-item send-confirmation" href="{{ $exportToCsv }}">CSV</a></li>
                                <li><a class="dropdown-item send-confirmation" href="{{ $exportToPdf }}">PDF</a></li>
                            </ul>
                        </div>
                        <div>
                            <x-primary-anchor :href="route('admin.reports.transactions.index')" :style="'padding:8px 30px'">
                                All
                            </x-primary-anchor>
                            <x-primary-anchor :href="route('admin.reports.transactions.index').'?status=success'">
                                Success
                            </x-primary-anchor>
                        </div>
                    </div>
                    @include('backend.reports.partials.transaction_table')
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

@endsection
