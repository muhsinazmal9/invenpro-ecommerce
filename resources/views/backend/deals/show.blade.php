@extends('backend.layouts.app')
@section('title', __('app.deals'))
@section('content')

<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="title">
                        <h2>{{ __('app.deals') }}</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item ">
                                    <a href="{{ route('admin.dashboard.index') }}">{{ __('app.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item ">
                                    <a href="{{ route('admin.deals.index') }}">{{ __('app.deals') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('app.deals') }}
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
              <div class="card-style">
                <div class="table-wrapper table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>{{ __('app.title') }}</h6>
                                </th>
                                <th>
                                    <h6>{{ __('app.date') }}</h6>
                                </th>
                                <th>
                                    <h6>{{ __('app.created_at') }}</h6>
                                </th>
                                <th>
                                    <h6>{{ __('app.status') }}</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td class="min-width">
                                    <p>{{ $deal->title }}</p>
                                </td>
                                <td class="min-width">
                                    <p>{{ $deal->date->format('y/m/d') }}</p>
                                </td>
                                <td class="min-width">
                                    <p>{{ $deal->created_at->format('y/m/d') }}</p>
                                </td>
                                <td class="min-width">
                                    @if($deal->status==1)
                                    <span class="success-btn-light fs-6" style='padding:2px 4px'>Enabled</span>
                                    @endif
                                    @if($deal->status==0)
                                    <span class="primary-btn-light fs-6" style='padding:2px 4px'>Disabled</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><br>
            </div><br>
            </div>
            <div class="col-md-12">
                @include('backend.deals.partials.details_table')
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- end container -->
</section>
<!-- ========== section end ========== -->

@endsection
