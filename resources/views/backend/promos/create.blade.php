@extends('backend.layouts.app')
@section('title', 'Create Promo')
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
                            <h2>Create Promo</h2>
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
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.promo.index') }}">Promos</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Create
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
                                    <label for="title" class="mb-1"><strong>Title</strong></label>
                                    <x-input-group
                                        :type="'text'"
                                        :value="old('title')"
                                        :name="'title'"
                                        :placeholder=" 'Enter title of promo'"
                                        :id="'title'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="limit" class="mb-1"><strong>Limit</strong></label>
                                    <x-input-group
                                        :type="'number'"
                                        :value="old('limit')"
                                        :name="'limit'"
                                        :placeholder=" 'Enter limit of promo' "
                                        :id="'limit'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('limit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="code" class="mb-1"><strong>Code</strong></label>
                                    <x-input-group
                                        :type="'text'"
                                        :value="old('code')"
                                        :name="'code'"
                                        :placeholder=" 'Enter Code of Promo' "
                                        :id="'code'"
                                        :class="'codeInput'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                    <label for="discount" class="mb-1"><strong>Discount</strong></label>
                                    <x-input-group
                                        :type="'number'"
                                        :value="old('discount')"
                                        :name="'discount'"
                                        :placeholder=" 'Enter discount of promo' "
                                        :id="'discount'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>

                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 my-2">
                                     <x-input-select :label="'Discount Type'" :name="'discount_type'" :id="'discount_type'">

                                            <option value="FIXED" @selected(old('discount_type') == 'FIXED')>Fixed</option>
                                            <option value="PERCENTAGE" @selected(old('discount_type') == 'PERCENTAGE')>PERCENTAGE</option>

                                    </x-input-select>

                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 my-2">
                                    <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                                        Status
                                    </x-success-checkbox>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        Create
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
