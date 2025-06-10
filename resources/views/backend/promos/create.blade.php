@extends('backend.layouts.app')
@section('title', __('app.create_promo'))
@section('content')
    <style>
        .image-wrapper {
            max-width: 12rem;
            border: 2px dotted #000;
            padding: 5px;
            background: #f7f5f5;
        }

        .image-wrapper img {
            width: 100%;
        }
    </style>

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.create_promo') }}</h2>
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
                                        <a href="{{ route('admin.promo.index') }}">{{__('app.promos')}}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{__('app.create')}}
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
                        <form action="{{ route('admin.promo.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label for="title" class="mb-1"><strong>{{ __('app.title') }}</strong></label>
                                    <x-input-group
                                        :type="'text'"
                                        :value="old('title')"
                                        :name="'title'"
                                        :placeholder=" __('app.enter_title_of_promo')"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="limit" class="mb-1"><strong>{{ __('app.limit') }}</strong></label>
                                    <x-input-group
                                        :type="'number'"
                                        :value="old('limit')"
                                        :name="'limit'"
                                        :placeholder=" __('app.enter_limit_of_promo') "
                                        :id="'limit'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('limit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="code" class="mb-1"><strong>{{ __('app.code') }}</strong></label>
                                    <x-input-group
                                        :type="'text'"
                                        :value="old('code')"
                                        :name="'code'"
                                        :placeholder=" __('app.enter_code_of_promo') "
                                        :id="'code'"
                                        :class="'codeInput'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="discount" class="mb-1"><strong>{{ __('app.discount') }}</strong></label>
                                    <x-input-group
                                        :type="'number'"
                                        :value="old('discount')"
                                        :name="'discount'"
                                        :placeholder=" __('app.enter_discount_of_promo') "
                                        :id="'discount'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                     <x-input-select :label="__('app.discount_type')" :name="'discount_type'" :id="'discount_type'">

                                            <option value="FIXED" @selected(old('discount_type') == 'FIXED')>{{ __('app.fixed') }}</option>
                                            <option value="PERCENTAGE" @selected(old('discount_type') == 'PERCENTAGE')>{{ __('app.percentage') }}</option>

                                    </x-input-select>

                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 my-2">
                                    <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                                        {{ __('app.status') }}
                                    </x-success-checkbox>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        {{ __('app.create') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
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
    $(document).on('keyup', '.codeInput', function() {
            const code = $(this).val();
            //  Customized the code value

            let codeValue = code.replace(/\s+/g, '-').toUpperCase();
            codeValue = codeValue.replace(/-+/g, '-');

            $(this).val(codeValue);
        })
</script>

@endpush
