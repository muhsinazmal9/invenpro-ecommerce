@extends('backend.layouts.app')
@section('title',request()->input('type') == 'customers' ? 'Customers' : 'Users' )
@push('css')
<style>
    .table-responsive {
        overflow-x: inherit;
    }

    .dropdown-item:hover {
        background-color: #f1f2f3;
    }

    .dropdown-toggle {
        background: transparent;
        border: 0;

    }

    .dropdown-toggle::after {
        border: 0;

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
                            <h2>{{ request()->input('type') == 'customers' ? \App\Models\User::CUSTOMER : \App\Models\User::USER  }}</h2>
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
                                        {{ request()->input('type') == 'customers' ? \App\Models\User::CUSTOMER : \App\Models\User::USER  }}
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

                    @include('backend.users.partials.table')
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

@endsection

