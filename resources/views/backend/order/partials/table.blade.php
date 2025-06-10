<x-table :title="'Order'" :addItemRoute="route('admin.orders.create')" :permissionName="''">
    <table class="table" id="orderTable">
        <thead>
            <tr>
                <th>{{ 'Invoice Id' }}</th>
                <th>{{ 'Customer' }}</th>
                <th>{{ 'Email' }}</th>
                <th>{{ 'Amount' }}</th>
                <th>{{ 'Payment Method' }}</th>
                <th>{{ 'Payment Status' }}</th>
                <th>{{ 'Status' }}</th>
                @if (request()->input('cancel_request') == 'true')
                    <th>{{ 'Cancel Request' }}</th>
                @endif
                <th>{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'Order Details'" :method="'PUT'" :action="'javascript:void(0)'">

    <div id="order-details"></div>
</x-modal-center>

@push('script')
    <script>
        let statusParam = "{{ request()->input('status') }}";
        let cancelParam = "{{ request()->input('cancel_request') }}";


        $(document).ready(function() {

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let url = "{{ route('admin.orders.getList') }}";
            if (statusParam) {
                url = url + '?status=' + statusParam;
            }

            if (cancelParam) {
                url = url + '?cancel_request=' + cancelParam;
            }

            const columns = [{
                    "data": "invoice_id"
                },
                {
                    "data": "user_id"
                },
                {
                    "data": "email",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return '';
                        }
                        return data;
                    }
                },
                {
                    "data": "grand_total"
                }, {
                    "data": "payment_method"
                },
                {
                    "data": "payment_status"
                },
                {
                    "data": "status"
                },
                {
                    "data": "actions",
                    "orderable": false
                },
            ];

            if (cancelParam) {
                columns.splice(7, 0, {
                    "data": "cancel_request"
                });
            }


            let data = $('#orderTable').DataTable({

                "order": [[ 0, "desc" ]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "searching": true,
                "ajax": {
                    "url": url,
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: token,
                    }
                },
                "columns": columns,

            });



            function convertToReadableString(inputString) {
                // Split the input string into words based on underscores
                const words = inputString.split('_');

                // Capitalize the first letter of each word and convert the rest to lowercase
                const formattedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1)
                    .toLowerCase());

                // Join the formatted words with spaces to create the readable string
                const readableString = formattedWords.join(' ');

                return readableString;
            }

        })


        function updateStatus(orderId) {

            Swal.fire({
                title: "Select Status",
                input: "select",
                inputOptions: {
                    "{{ App\Models\Order::ORDER_STATUS['placed'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['placed']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['approved'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['approved']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['shipped'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['shipped']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['delivered'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['delivered']) }}",
                    "{{ App\Models\Order::ORDER_STATUS['cancelled'] }}": "{{ Str::ucfirst(App\Models\Order::ORDER_STATUS['cancelled']) }}",
                },
                showCancelButton: true,
                confirmButtonText: "{{ 'Confirm ' }}",
                allowOutsideClick: () => !Swal.isLoading(),
                showLoaderOnConfirm: true,

            }).then((status) => {
                if (status.isConfirmed) {

                    Swal.fire({
                        title: "{{ 'Loading...' }}",
                        text: "{{ 'Please wait...' }}",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    let url = "{{ route('admin.orders.status', ':id') }}";
                    url = url.replace(':id', orderId);
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    $.ajax({
                        url: url,
                        type: "PATCH",
                        data: {
                            status: status.value,
                            _token: token
                        },
                        success: function(response) {
                            if (response.success) {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ 'Updated!' }}",
                                        text: response.message,
                                        icon: "success",
                                    });
                                    $('#orderTable').DataTable().ajax.reload();
                                }, 1000);

                            } else {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ 'Error' }}",
                                        text: response.message,
                                        icon: "error",
                                    });
                                }, 1000);

                            }
                        },
                        error: function(response) {
                            setTimeout(() => {
                                Swal.fire({
                                    title: "{{ 'Error' }}",
                                    text: response.message,
                                    icon: "error",
                                });
                            }, 1000);

                            console.log(response);
                        }
                    });
                }
            });
        }

        function updateCancelStatus(orderId) {

            Swal.fire({
                title: "Select",
                input: "select",
                inputOptions: {
                    "2": "Approve",
                    "3": "Reject",
                },
                showCancelButton: true,
                confirmButtonText: "{{ 'Confirm ' }}",
                allowOutsideClick: () => !Swal.isLoading(),
                showLoaderOnConfirm: true,

            }).then((status) => {
                if (status.isConfirmed) {

                    Swal.fire({
                        title: "{{ 'Loading...' }}",
                        text: "{{ 'Please wait...' }}",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    let url = "{{ route('admin.orders.cancel.request.update', ':id') }}";
                    url = url.replace(':id', orderId);
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    $.ajax({
                        url: url,
                        type: "PATCH",
                        data: {
                            status: status.value,
                            _token: token
                        },
                        success: function(response) {
                            if (response.success) {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ 'Updated!' }}",
                                        text: response.message,
                                        icon: "success",
                                    });
                                    let orderViewLink =
                                        "{{ route('admin.orders.show', ':id') }}";
                                    orderViewLink = orderViewLink.replace(':id', orderId);


                                    setTimeout(() => {
                                        window.location.href = orderViewLink;
                                    }, 1000);
                                }, 1000);

                            } else {

                                setTimeout(() => {
                                    Swal.fire({
                                        title: "{{ 'Error' }}",
                                        text: response.message,
                                        icon: "error",
                                    });
                                }, 1000);
                                console.log(response);

                            }
                        },
                        error: function(response) {
                            setTimeout(() => {
                                Swal.fire({
                                    title: "{{ 'Error' }}",
                                    text: response.message,
                                    icon: "error",
                                });
                            }, 1000);
                            console.log(response);

                        }
                    });
                }
            });
        }
    </script>
@endpush
