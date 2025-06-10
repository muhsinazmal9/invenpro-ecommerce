@extends('backend.layouts.app')
@section('title', __('app.business_settings'))
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
                        <h2>{{ __('app.tax_settings') }} </h2>
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
                                    {{ __('app.tax_settings') }}
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
                        <div class="title-section d-flex justify-content-between w-100">
                            <div class="title ">
                                <h3>{{ __('app.tax_settings') }}</h3>
                            </div>
                            <div class="title">
                                <button class='main-btn primary-btn icon-btn btn-hover btn-sm details-btn'
                                    data-bs-toggle='modal' data-bs-target='#createModal'>
                                    <i class="fas fa-plus"></i>
                                    {{ __('app.add_tax') }}
                                </button>
                            </div>
                        </div>
                        <div class="table-wrapper table-responsive mt-3">
                            <table class="table" id="taxTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('app.code') }}</th>
                                        <th>{{ __('app.rate') }}</th>
                                        <th>{{ __('app.status') }}</th>
                                        <th>{{ __('app.created_at') }}</th>
                                        <th>{{ __('app.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
</section>


{{-- Create Modal --}}
<x-modal-center :id="'createModal'" :modal_title="__('app.create_tax')" :method="'PUT'" :action="'javascript:void(0)'">

    @csrf
    <div class="row">
        <div class="col-md-6">
            <label for="code" class="mb-1"><strong>{{ __('app.code') }}</strong></label>
            <x-input-group :type="'text'" :value="''" :name="'code'" :placeholder="__('app.enter_tax_code')"
                :id="'code'" :class="'codeInput'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>

            <span class="text-danger tax_code_error"></span>
        </div>
        <div class="col-md-6">
            <label for="rate" class="mb-1"><strong>{{ __('app.rate') }}</strong></label>
            <x-input-group :max="100" :min="0" :type="'number'" :step="'any'" :value="''" :name="'text'"
                :placeholder="__('app.enter_tax_rate')" :id="'rate'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>

            <span class="text-danger tax_rate_error"></span>
        </div>
        <div class="col-md-6">
            <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                {{ __('app.status') }}
            </x-success-checkbox>
        </div>

        <div class="col-md-12 mt-3 text-center">
            <x-primary-button :id="'tax_create_btn'" :type="'submit'" :style="'padding:8px 50px'">
                {{ __('app.save') }}
            </x-primary-button>
        </div>
    </div>
</x-modal-center>

{{-- Edit Modal --}}
<x-modal-center :id="'editModal'" :modal_title="__('app.edit_tax')" :method="'PUT'" :action="'javascript:void(0)'">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label for="code" class="mb-1"><strong>{{ __('app.code') }}</strong></label>
            <x-input-group :type="'text'" :name="'codeEdit'" :placeholder="__('app.enter_tax_code')" :id="'codeEdit'"
                :class="'codeInput'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>

            <span class="text-danger tax_edit_code_error"></span>
        </div>
        <div class="col-md-6">
            <label for="rate" class="mb-1"><strong>{{ __('app.rate') }}</strong></label>
            <x-input-group :max="100" :min="0" :type="'number'" :step="'any'" :name="'rateEdit'"
                :placeholder="__('app.enter_tax_rate')" :id="'rateEdit'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>

            <span class="text-danger tax_edit_rate_error"></span>
        </div>
        <div class="col-md-6">
            <x-success-checkbox :id="'statusEdit'" :value="'1'" :name="'statusEdit'">
                {{ __('app.status') }}
            </x-success-checkbox>
        </div>

        <div class="col-md-12 mt-3 text-center">
            <x-primary-button :id="'tax_update_btn'" :type="'submit'" :style="'padding:8px 50px'">
                {{ __('app.update') }}
            </x-primary-button>
        </div>
    </div>
</x-modal-center>
<!-- ========== section end ========== -->
@endsection
@push('script')
<script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const data = $('#taxTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.settings.tax.getList') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "code"
                },
                {
                    "data": "rate"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "actions"
                },
            ],

        });

        $(document).on('click', '#tax_create_btn', function() {
            const code = $('#code').val();
            const rate = $('#rate').val();
            const status = $('#status').is(':checked') ? 1 : 0;

            console.log('code', code);
            console.log('rate', rate);
            console.log('status', status);

            let isError = false;

            if (code == '') {
                $('.tax_code_error').text('The code field is required.');
                isError = true;
            } else {
                $('.tax_code_error').text('');
            }

            if (rate == '') {
                $('.tax_rate_error').text('The rate field is required.');
                isError = true;
            } else if (rate < 0 || rate > 100) {
                $('.tax_rate_error').text('The rate must be between 0 and 100.');
                isError = true;
            } else {
                $('.tax_rate_error').text('');
            }

            if (isError) {
                return;
            }

            // add spinnter to the button
            $('#tax_create_btn').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajax({
                url: "{{ route('admin.settings.tax.store') }}",
                type: "POST",
                data: {
                    _token: token,
                    code: code,
                    rate: rate,
                    status: status
                },
                success: function(response) {
                    if (response.success) {

                        const timeout = 1500;

                        setTimeout(() => {
                            $('#createModal').modal('hide');
                            $('#code').val('');
                            $('#rate').val('');
                            $('#status').prop('checked', false);
                            $('#tax_create_btn').html('Save');
                            data.ajax.reload();
                        }, timeout);
                    } else {

                        // remove spinner from the button
                        $('#tax_create_btn').html('Save');

                        if (response.errors.code) {
                            $('.tax_code_error').text(response.errors.code[0]);
                        }
                        if (response.errors.rate) {
                            $('.tax_rate_error').text(response.errors.rate[0]);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    $('#tax_create_btn').html('Save');
                    console.log(xhr.responseJSON);

                    if (xhr.responseJSON.errors.code) {
                        $('.tax_code_error').text(xhr.responseJSON.errors.code[0]);
                    } else {
                        $('.tax_code_error').text('');

                    }

                    if (xhr.responseJSON.errors.rate) {
                        $('.tax_rate_error').text(xhr.responseJSON.errors.rate[0]);
                    } else {
                        $('.tax_rate_error').text('');
                    }

                }
            });
        });

        $('#tax_update_btn').on('click', function() {
            const code = $('#codeEdit').val();
            const rate = $('#rateEdit').val();
            const status = $('#statusEdit').is(':checked') ? 1 : 0;
            const slug = $(this).attr('data-slug');


            let isError = false;

            if (code == '') {
                $('.tax_edit_code_error').text('The code field is required.');
                isError = true;
            } else {
                $('.tax_edit_code_error').text('');
            }

            if (rate == '') {
                $('.tax_edit_rate_error').text('The rate field is required.');
                isError = true;
            } else if (rate < 0 || rate > 100) {
                $('.tax_edit_rate_error').text('The rate must be between 0 and 100.');
                isError = true;
            } else {
                $('.tax_edit_rate_error').text('');
            }

            if (isError) {
                return;
            }

            // add spinnter to the button
            $('#tax_update_btn').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
            );

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const method = "PUT";
            let url = "{{ route('admin.settings.tax.update', ':slug') }}";
            url = url.replace(':slug', slug);

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: token,
                    _method: method,
                    code: code,
                    rate: rate,
                    status: status
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {

                        const timeout = 1000;

                        setTimeout(() => {
                            $('#editModal').modal('hide');
                            $('#codeEdit').val('');
                            $('#rateEdit').val('');
                            $('#statusEdit').prop('checked', false);
                            $('#tax_update_btn').html('Save');
                            data.ajax.reload();
                        }, timeout);
                    } else {

                        $('#tax_update_btn').html('Update');
                        $('.tax_code_error').text(response.message);

                    }
                },
                error: function(xhr, status, error) {
                    $('#tax_update_btn').html('Update');
                    console.log(xhr.responseJSON);

                    if (xhr.responseJSON.errors.code) {
                        $('.tax_edit_code_error').text(xhr.responseJSON.errors.code[0]);
                    } else {
                        $('.tax_edit_code_error').text('');

                    }

                    if (xhr.responseJSON.errors.rate) {
                        $('.tax_edit_rate_error').text(xhr.responseJSON.errors.rate[0]);
                    } else {
                        $('.tax_edit_rate_error').text('');
                    }

                }
            });
        });

        function deleteTax(slug, row) {
            let url = "{{ route('admin.settings.tax.destroy', ':slug') }}";
            url = url.replace(':slug', slug);
            let method = "DELETE";
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: "{{ __('app.are_you_sure') }}",
                text: "{{ __('app.you_will_not_be_able_to_revert_this') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('app.yes_delete_it') }}",
                cancelButtonText: "{{ __('app.cancel') }}",
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    itemDelete(url, method, token, row)
                }
            })
        }

        function taxStatusUpdate(slug, btn) {


            let url = "{{ route('admin.settings.tax.status', ':slug') }}";
            url = url.replace(':slug', slug);

            let method = "patch";
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: "{{ __('app.are_you_sure') }}",
                text: "{{ __('app.you_want_to_change_the_status_of_this_tax_settings') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('app.yes_update_it') }}",
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    $.ajax({
                        type: "PATCH",
                        url: url,
                        data: {
                            _token: token,
                        },
                        success: function(response) {

                            if (response.success) {
                                Swal.fire({
                                    title: "{{ __('app.updated') }}",
                                    text: "{{ __('app.tax_status_has_been_updated') }}",
                                    icon: 'success',
                                });



                                if (response.data.status) {

                                    $(btn).text('Enabled');
                                    $(btn).removeClass('danger-btn-light ');
                                    $(btn).addClass('success-btn-light ');

                                } else {

                                    $(btn).text('Disabled');
                                    $(btn).addClass('danger-btn-light ');
                                    $(btn).removeClass('success-btn-light ');

                                }


                            }
                        },
                    });
                }
            })
        }

        function editTax(button) {
            const data = JSON.parse($(button).attr('data'));

            $('#editModal').modal('show');

            $('#codeEdit').val(data.code);
            $('#rateEdit').val(data.rate);
            $('#statusEdit').prop('checked', data.status);
            $('#tax_update_btn').attr('data-slug', data.slug);
        }

        $(document).on('keyup', '.codeInput', function() {
            const code = $(this).val();
            //  Customized the code value

            let codeValue = code.replace(/\s+/g, '-').toUpperCase();
            codeValue = codeValue.replace(/-+/g, '-');

            $(this).val(codeValue);
        })

        function toggleActions(dropdown) {
            dropdown.parentElement.classList.toggle('show')
            dropdown.nextElementSibling.classList.toggle('show')

            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show')
                }
            })

        }
</script>
@endpush
