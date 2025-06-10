@extends('backend.layouts.app')
@section('title','Pages')
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
                        <h2>{{ __('app.pages') }}</h2>
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
                                {{ __('app.pages') }}
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
                    @include('backend.cms_pages.partials.table')

                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

@endsection

