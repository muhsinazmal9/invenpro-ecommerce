@extends('backend.layouts.app')
@section('title', 'Email Template')
@section('content')
<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">

        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="title">
                        <h2>Email Template </h2>
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
                                    Email Template
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
                @include('backend.settings.partials.email_sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Variable</th>
                                            <th scope="col">Meaning</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{ User Name }</td>
                                            <td>otp</td>

                                        </tr>
                                        <tr>
                                            <td>{otp-code}</td>
                                            <td>OTP</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div><br><br>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.email-template.email.update') }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-md-12 mt-1">
                                    <label for="email_template" class="mb-1"><strong>Description</strong></label>

                                    <x-textarea-group :type="'text'"
                                        :value="old('email_template', getSetting('email_template') ?? '')"
                                         :placeholder="'Enter the description'" :id="'email_template'">
                                    </x-textarea-group>

                                    @error('email_template')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        Update
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
