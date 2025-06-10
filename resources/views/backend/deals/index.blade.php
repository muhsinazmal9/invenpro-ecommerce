@extends('backend.layouts.app')
@section('title', 'Deals')
@push('css')
<style>
    .table-responsive {
        overflow-x: inherit;
    }

    .dropdown-item:hover {
        background-color: #f1f2f3;
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
                            <h2>{{ 'Deals' }}
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
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Deals' }}
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
                    @include('backend.deals.partials.table')
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->
@endsection

@push('script')
@if (session('success'))
    <script>
        const deal_products = 'deals_products';
        const edit_deal_products = 'deals_product_edit_screen';
        if (localStorage.getItem(deal_products)) {
            localStorage.removeItem(deal_products);
        }
        if (localStorage.getItem(edit_deal_products)) {
            localStorage.removeItem(edit_deal_products);
        }
    </script>
@endif
@endpush

