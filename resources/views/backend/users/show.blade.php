@extends('backend.layouts.app')
@section('title', __('app.users'))
@section('content')

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.customers') }}</h2>
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
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a
                                            href="{{ route('admin.users.index') }}?type=customers">{{ __('app.customers') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $user->name }}
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
                    <div class="card-style rounded-3">
                        <div class="d-flex justify-content-between align-items-stretch">
                            <h4 class="card-header">{{ __('app.customers_details') }}</h4>
                            <a href="{{ route('admin.users.edit', $user->username) }}" type="button"
                                class="main-btn primary-btn btn-hover btn-sm">{{ __('app.edit') }}</a>
                        </div>

                        <div class="card-body d-flex align-items-center gap-3 my-3">
                            <div style="max-width: 60px;">
                                <img class="img-fluid rounded-circle" src="{{ asset($user->image) }}" alt="">
                            </div>

                            <div class="">
                                <p class="text-muted fw-semibold">{{ $user->name }}</p>
                                <p class="text-muted">{{ $user->email }}</p>
                            </div>

                        </div>
                        <div class="table-wrapper table-responsive">
                            <table class="table striped-table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p>{{ __('app.name') }}:</p>
                                        </td>
                                        <td>
                                            <p class="text-muted fw-semibold">{{ $user->name }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>{{ __('app.username') }}:</p>
                                        </td>
                                        <td>
                                            <p class="text-muted fw-semibold">{{ $user->username }}</p>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td>
                                            <p>{{ __('app.email') }}:</p>
                                        </td>
                                        <td>
                                            <p class="text-muted fw-semibold">{{ $user->email }}</p>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td>
                                            <p>{{ __('app.role') }}:</p>
                                        </td>
                                        <td>
                                            <p class="text-muted fw-semibold">{{ $user->roles[0]->name }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>{{ __('app.status') }}:</p>
                                        </td>
                                        <td>
                                            <p class="text-muted fw-semibold">{{ $user->status }}</p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <!-- end table -->
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mt-4 mt-md-0">
                    <div class="mb-3 d-flex gap-3">
                        <a class="main-btn primary-btn btn-hover btn-sm" href="{{ route('admin.users.show', $user->username) }}?tab=address">Address</a>
                        <a class="main-btn primary-btn btn-hover btn-sm" href="{{ route('admin.users.show', $user->username) }}?tab=orders">Orders</a>
                    </div>
                    @if (request()->input('tab') == 'orders')
                        @include('backend.users.orders.partials.table')
                        @else
                        @include('backend.users.addresses.partials.table')

                    @endif

                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->
@endsection
