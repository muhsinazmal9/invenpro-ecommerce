<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="title-section d-flex justify-content-between w-100">
                <div class="title">
                    <h3>{{ 'Subscriber' }}</h3>
                </div>
                <div class="title">
                    <button class='main-btn primary-btn icon-btn btn-hover btn-sm details-btn' data-bs-toggle='modal'
                        data-bs-target='#createModal'>
                        <i class="fas fa-plus"></i>
                        {{ 'Create Subscriber' }}
                    </button>
                </div>
            </div>
            <div class="table-wrapper table-responsive mt-3">
                <table class="table" id="mailTable">
                    <thead>
                        <tr>
                            <th>{{ 'Email' }}</th>
                            <th>{{ 'Status' }}</th>
                            <th>{{ 'Actions' }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<x-modal-center :id="'createModal'" :modal_title="'Create Subscriber'" :method="'PUT'" :action="'javascript:void(0)'">

    @csrf
    <div class="row">
        <div class="col-md-12 mt-2">
            <label for="email" class="mb-1"><strong>{{ 'Email' }}</strong></label>
            <x-input-group :type="'text'" :name="'email'" :placeholder="'Enter email'" :id="'email'" :class="'email'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>

            <span class="text-danger email_error"></span>
        </div>

        <div class="col-md-6">
            <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                {{ 'Status' }}
            </x-success-checkbox>
        </div>

        <div class="col-md-12 mt-3 text-center">
            <x-primary-button :id="'social_create_btn'" :type="'submit'" :style="'padding:8px 50px'">
                {{ 'Save' }}
            </x-primary-button>
        </div>
    </div>
</x-modal-center>


<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#mailTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.subscriber.getList') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "email"
                },
                {
                    "data": "is_subscribed"

                },
                {
                    "data": "actions"
                },
            ],

        })
        console.log(data);
    })

    function deleteSubscriber(id, row) {
        let url = "{{ route('admin.subscriber.destroy', ':id') }}";
        url = url.replace(':id', id);
        let method = "DELETE";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You will not be able to revert this!' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, delete it!' }}",
            cancelButtonText: "{{ 'Cancel' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
            }
        })
    }

    function toggleSubscribe(token, btn) {
        let url = "{{ route('admin.subscriber.unsubscribe', ':token') }}";
        url = url.replace(':token', token);

        const method = "GET";

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'Are you sure to update status' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, Update it' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();

                $.ajax({
                    type: method,
                    url: url,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "{{ 'Updated!' }}",
                                text: "{{ 'Status has been updated!' }}",
                                icon: 'success',
                            });

                            if (response.data.is_subscribed) {
                                $(btn).text("{{ 'Subscribed' }}");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ 'Unsubscribed' }}");
                                $(btn).addClass('danger-btn-light ');
                                $(btn).removeClass('success-btn-light ');
                            }
                        }
                    },
                });
            }
        })
    }

    function validateEmail(email) {

        const regex = /^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        return regex.test(email);
    }


    $(document).on('click', '#social_create_btn', function() {
        const email = $('#email').val();
        const status = $('#status').is(':checked') ? 1 : 0;
        console.log('status', status);

        let isError = false;

        if (!email) {
            $('.email_error').text('The email field is required.');
            isError = true;
        } else if (!validateEmail(email)) {
            $('.email_error').text('The email must be a valid email address.');
            isError = true;
        } else {
            $('.email_error').text('');
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
            url: "{{ route('admin.subscriber.store') }}",
            type: "POST",
            data: {
                _token: token,
                email: email,
                status: status
            },
            success: function(response) {
                console.log('response', response)

                if (response.success) {
                    const timeout = 1000;

                    setTimeout(() => {
                        $('#createModal').modal('hide');
                        $('#email').val('');
                        $('#status').prop('checked', false);
                        $('#social_create_btn').html('Save');

                        $('#mailTable').DataTable().ajax.reload();

                    }, timeout);

                } else {

                    $('#social_create_btn').html('Save');

                }
            },
            error: function(xhr, status, error) {
                $('#social_create_btn').html('Save');
                console.log(xhr.responseJSON);


                if (xhr.responseJSON.errors.email) {
                    $('.email_error').text(xhr.responseJSON.errors.email[0]);
                } else {
                    $('.email_error').text('');
                }

            }
        });
    });
</script>
