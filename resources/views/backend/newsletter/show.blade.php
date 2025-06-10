@extends('backend.layouts.app')
@section('title', 'Newsletter Details')
@section('content')

<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="title">
                        <h2>{{ 'Newsletter Details' }}</h2>
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
                                    <a href="{{ route('admin.newsletter.index') }}">{{ 'News Letter' }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ 'Newsletter Details' }}
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <h4>{{ 'Subject' }}: <u><em>{{ $newsletter->subject }}</em></u></h4>

                            </div>
                            <div class="mt-4">
                                <h4>{{ 'Body' }}</h4>
                                {!! $newsletter->body !!}
                            </div>
                            <div class="mt-4">
                                <h4>{{ 'Created at' }}: <u><em>{{ $newsletter->created_at->format('d/m/y') }}</em></u></h4>
                            </div>
                            <div>
                                <h4>{{ 'Status' }}
                                    &nbsp;
                                    @if($newsletter->status==1)
                                        <span class="success-btn-light fs-6" style='padding:2px 4px'>Sent</span>
                                    @endif
                                    @if($newsletter->status==0)
                                        <span class="primary-btn-light fs-6" style='padding:2px 4px'>Draft</span>
                                    @endif
                                </h4>

                            </div>
                        </div>
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
