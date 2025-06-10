@extends('backend.layouts.app')
@section('title', 'Business Settings')
@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ 'Stock Settings' }} </h2>
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
                                        {{ 'Stock Settings' }}
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
                <div class="col-md-3">
                    @include('backend.settings.partials.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.settings.stock.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-6 mt-1">
                                        <label for="low_stock" class="mb-1"><strong>{{ 'Minimum Products for Alert' }}</strong></label>

                                        <x-input-group :type="'number'" :value="old('low_stock', getSetting('low_stock') ?? '')" :name="'low_stock'"
                                            :placeholder="'Minimum Products for Alert'" :id="'low_stock'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>

                                        @error('low_stock')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>




                                    <div class="col-md-12 mt-3">
                                        <x-primary-button :type="'submit'">
                                            {{ 'Update' }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
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

@push('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
