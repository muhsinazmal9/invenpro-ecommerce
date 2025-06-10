@extends('backend.layouts.app')
@section('title', __('app.color_settings'))
@section('content')
<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">

        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="title">
                        <h2>{{ __('app.color_settings') }} </h2>
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
                                    {{ __('app.color_settings') }}
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
                        <form action="{{ route('admin.settings.color.update') }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="row flex-column">
                                <div class="col-md-2 mt-1 ">
                                    <label for="primary_color" class="mb-1"><strong>{{ __('app.primary_color')
                                            }}</strong></label><br>
                                    <input name="primary_color" id="primary_color" type="color" class="form-control"
                                        value="{{ old('primary_color',getSetting('primary_color')) }}">
                                    @error('primary_color')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-2 mt-1 ">
                                    <label for="secondary_color" class="mb-1"><strong>{{ __('app.secondary_color')
                                            }}</strong></label><br>
                                    <input name="secondary_color" id="secondary_color" type="color"
                                        class="form-control" value="{{ old('secondary_color',getSetting('secondary_color')) }}">
                                    @error('secondary_color')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        {{ __('app.update') }}
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
