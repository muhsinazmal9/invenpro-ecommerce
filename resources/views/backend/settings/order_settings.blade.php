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
                            <h2>{{ 'Order settings' }} </h2>
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
                                        {{ 'Order settings' }}
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
                            <form action="{{ route('admin.settings.order.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-6 mt-1">
                                        <label for="invoice_prefix" class="mb-1"><strong>{{ 'Invoice Prefix' }}</strong></label>

                                        <x-input-group :type="'text'" :value="old('invoice_prefix', getSetting('invoice_prefix') ?? '')" :name="'invoice_prefix'"
                                            :placeholder="'Invoice Prefix'" :id="'invoice_prefix'">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>




                                        @error('invoice_prefix')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="color" name="primary_color" class="form-control">
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
