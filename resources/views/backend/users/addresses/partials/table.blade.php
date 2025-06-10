<x-table :title="__('app.addresses')" :addItemRoute="route('admin.addresses.create', $user->username)" :permissionName="App\Models\Address::CREATE">
    <style>
        .dataTable {
            width: calc(100% - 10px) !important;
        }
    </style>
    <table class="table" id="addressTable">
        <thead>
            <tr>
                <th style="min-width: 200px">{{ __('app.title') }}</th>
                <th style="min-width: 200px">{{ __('app.street_address') }}</th>
                <th style="min-width: 200px">{{ __('app.apt_suite') }}</th>
                <th style="min-width: 100px">{{ __('app.zip_code') }}</th>
                <th style="min-width: 150px">{{ __('app.actions') }}</th>
            </tr>
        </thead>
    </table>
</x-table>

<script>
    $(document).ready(function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        url = "{{ route('admin.addresses.getList', $user->username) }}";

        let data = $('#addressTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "street_address"
                },
                {
                    "data": "apt_or_floor"
                },
                {
                    "data": "zip_code"
                },
                {
                    "data": "actions"
                }
            ]
        });
    })

    function deleteAddress(id, row) {
        let addressRemoveUrl = "{{ route('admin.addresses.destroy', ':id') }}";
        addressRemoveUrl = addressRemoveUrl.replace(':id', id);
        const method = "delete";
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_will_not_be_able_to_revert_this_address') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_delete_it') }}",
            cancelButtonText: "{{ __('app.cancel') }}",
        }).then((result) => {
            if (result.value) {
                // itemDelete(addressRemoveUrl, method, token, row)
                let data = {};
                fetch(addressRemoveUrl, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: method,
                        credentials: "same-origin",
                        body: JSON.stringify(data)
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (200 == data.status) {
                            console.log(data.message);
                            Swal.fire(
                                'Success',
                                data.message,
                                'success'
                            );
                            row.remove();
                        } else {
                            Swal.fire(
                                'Failed',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(function(error) {
                        Swal.fire(
                            'Failed',
                            error.message,
                            'error'
                        );
                    });
            }
        })
    }
</script>
