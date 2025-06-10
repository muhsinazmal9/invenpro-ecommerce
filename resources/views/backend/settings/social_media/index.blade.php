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
                        <h2>{{ __('app.social_media') }} </h2>
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
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('app.social_media') }}
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
                            <div class="title">
                                <h3>{{ __('app.social_media') }}</h3>
                            </div>
                            <div class="title">
                                <button class='main-btn primary-btn icon-btn btn-hover btn-sm details-btn'
                                    data-bs-toggle='modal' data-bs-target='#createModal'>
                                    <i class="fas fa-plus"></i>
                                    {{ __('app.add_social') }}
                                </button>
                            </div>
                        </div>
                        <div class="table-wrapper table-responsive mt-3">
                            <table class="table" id="socialTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('app.name') }}</th>
                                        <th>{{ __('app.icon') }}</th>
                                        <th>{{ __('app.url') }}</th>
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
<x-modal-center :id="'createModal'" :modal_title="__('app.add_social')" :method="'PUT'" :action="'javascript:void(0)'">

    @csrf
    <div class="row">

        <div class="col-md-12">
            <x-input-select :label="__('app.platform')" :name="'platform_id'" :id="'platform_id'">

                @foreach ($platforms as $platform)
                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                @endforeach
                </x-select-input>
                <span class="text-danger platform_error"></span>
        </div>

        <div class="col-md-12 mt-2">
            <label for="username" class="mb-1"><strong>{{ __('auth.username') }}</strong></label>
            <x-input-group :type="'text'" :name="'username'" :placeholder="__('auth.enter_username')" :id="'username'"
                :class="'username'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>

            <span class="text-danger username_error"></span>
        </div>

        <div class="col-md-6">
            <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                {{ __('app.status') }}
            </x-success-checkbox>
        </div>

        <div class="col-md-12 mt-3 text-center">
            <x-primary-button :id="'social_create_btn'" :type="'submit'" :style="'padding:8px 50px'">
                {{ __('app.save') }}
            </x-primary-button>
        </div>
    </div>
</x-modal-center>

{{-- Edit Modal --}}
<x-modal-center :id="'editModal'" :modal_title="__('app.edit_social_media')" :method="'PUT'"
    :action="'javascript:void(0)'">
    @csrf
    <div class="row">

        <div class="col-md-12">
            <x-input-select :label="__('app.platform')" :name="'platform_id_edit'" :id="'platform_id_edit'">

                @foreach ($platforms as $platform)
                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                @endforeach
                </x-select-input>
                <span class="text-danger platform_edit_error"></span>
        </div>

        <div class="col-md-12 mt-2">
            <label for="username_edit" class="mb-1"><strong>{{ __('auth.username') }}</strong></label>
            <x-input-group :type="'text'" :name="'username_edit'" :placeholder="__('auth.enter_username')"
                :id="'username_edit'" :class="'username_edit'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>

            <span class="text-danger username_edit_error"></span>
        </div>

        <div class="col-md-6">
            <x-success-checkbox :id="'status_edit'" :value="'1'" :name="'status_edit'">
                {{ __('app.status') }}
            </x-success-checkbox>
        </div>

        <div class="col-md-12 mt-3 text-center">
            <x-primary-button :id="'social_edit_btn'" :type="'submit'" :style="'padding:8px 50px'">
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
        const data = $('#socialTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.settings.social-media.getList') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "icon"
                },
                {
                    "data": "url"
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

        $(document).on('click', '#social_create_btn', function() {
            const platform_id = $('#platform_id').val();
            const username = $('#username').val();
            const status = $('#status').is(':checked') ? 1 : 0;

            let isError = false;

            if (platform_id == '') {
                $('.platform_error').text('The platform field is required.');
                isError = true;
            } else {
                $('.platform_error').text('');
            }

            if (username == '') {
                $('.username_error').text('The username field is required.');
                isError = true;
            } else {
                $('.username_error').text('');
            }

            if (isError) {
                return;
            }

            // add spinnter to the button
            $('#social_create_btn').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajax({
                url: "{{ route('admin.settings.social-media.store') }}",
                type: "POST",
                data: {
                    _token: token,
                    platform_id: platform_id,
                    username: username,
                    status: status
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {


                        const timeout = 1000;

                        setTimeout(() => {
                            $('#createModal').modal('hide');
                            $('#platform').val('');
                            $('#username').val('');
                            $('#status').prop('checked', false);
                            $('#social_create_btn').html('Save');
                            data.ajax.reload();
                        }, timeout);
                    } else {

                        $('#social_create_btn').html('Save');
                        $('.platform_error').text(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#social_create_btn').html('Save');
                    console.log(xhr.responseJSON);

                    if (xhr.responseJSON.errors.platform_id) {
                        $('.platform_error').text(xhr.responseJSON.errors.platform_id[0]);
                    } else {
                        $('.platform_error').text('');
                    }

                    if (xhr.responseJSON.errors.username) {
                        $('.username_error').text(xhr.responseJSON.errors.username[0]);
                    } else {
                        $('.username_error').text('');
                    }

                }
            });
        });
        $(document).on('click', '#social_edit_btn', function() {
            const platform_id = $('#platform_id_edit').val();
            const username = $('#username_edit').val();
            const status = $('#status_edit').is(':checked') ? 1 : 0;
            const social_id = $(this).attr('data-id');

            let isError = false;

            if (platform_id == '') {
                $('.platform_edit_error').text('The platform field is required.');
                isError = true;
            } else {
                $('.platform_edit_error').text('');
            }

            if (username == '') {
                $('.username_edit_error').text('The username field is required.');
                isError = true;
            } else {
                $('.username_edit_error').text('');
            }

            if (isError) {
                return;
            }

            // add spinnter to the button
            $('#social_edit_btn').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
            );

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let url = "{{ route('admin.settings.social-media.update', ':id') }}";
            url = url.replace(':id', social_id);

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: token,
                    _method: 'PUT',
                    platform_id: platform_id,
                    username: username,
                    status: status
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {

                        const timeout = 1000;

                        setTimeout(() => {
                            $('#editModal').modal('hide');
                            $('#platform_edit').val('');
                            $('#username_edit').val('');
                            $('#status_edit').prop('checked', false);
                            $('#social_edit_btn').html('Update');
                            data.ajax.reload();
                        }, timeout);
                    } else {
                        $('#social_edit_btn').html('Update');
                        $('.platform_edit_error').text(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#social_edit_btn').html('Update');
                    console.log(xhr);

                    if (xhr.responseJSON.errors.platform_id) {
                        $('.platform_edit_error').text(xhr.responseJSON.errors.platform_id[0]);
                    } else {
                        $('.platform_edit_error').text('');
                    }

                    if (xhr.responseJSON.errors.username) {
                        $('.username_edit_error').text(xhr.responseJSON.errors.username[0]);
                    } else {
                        $('.username_edit_error').text('');
                    }
                }
            });
        });



        function deleteSocial(id, row) {
            let url = "{{ route('admin.settings.social-media.destroy', ':id') }}";
            url = url.replace(':id', id);
            console.log(url);
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

        function socialStatusUpdate(id, btn) {


            let url = "{{ route('admin.settings.social-media.status', ':id') }}";
            url = url.replace(':id', id);

            let method = "patch";
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: "{{ __('app.are_you_sure') }}",
                text: "{{ __('app.you_want_to_change_the_status_of_this_social_media') }}",
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
                                    text: "{{ __('app.social_status_has_been_updated') }}",
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

        $(document).on('click', '.social_edit_btn', function() {
            const data = JSON.parse($(this).attr('data'));
            $('#platform_id_edit').val(data.platform_id);
            $('#username_edit').val(data.username);
            $('#status_edit').prop('checked', data.status);
            $('#social_edit_btn').attr('data-id', data.id);
        });

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
