@extends('backend.layouts.app')
@section('title', 'Banners')

@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>Banners
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
                                        Banners
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
                    <div class="card-style mb-30">
                        <h4 class="mb-10">Fixed Banners</h4>

                        <div class="table-wrapper table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <h6>Banner Name</h6>
                                        </th>
                                        <th>
                                            <h6>Banner Image</h6>
                                        </th>
                                        <th>
                                            <h6>Actions</h6>
                                        </th>
                                    </tr>
                                    <!-- end table row-->
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td style="width: 40rem">
                                                <a href="{{ route('admin.banner.edit', $banner->slug) }}" class="d-block form-text m-0">
                                                    {{ $banner->banner_name }}
                                                </a>
                                            </td>
                                            <td>
                                                <img width="300" src="{{ asset($banner->image) }}"
                                                    alt="{{ $banner->title }}" loading="lazy">
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.banner.edit', $banner->slug) }}"
                                                    class="main-btn primary-btn btn-hover btn-sm edit-btn">
                                                    <i class="mdi mdi-pencil fs-5"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- end table -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->
@endsection
