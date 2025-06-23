<x-table :title="'Addresses'" :addItemRoute="route('admin.addresses.create', $user->username)" :permissionName="App\Models\Address::CREATE">
    <style>
        .dataTable {
            width: calc(100% - 10px) !important;
        }
    </style>
    <table class="table" id="addressTable">
        <thead>
            <tr>
                <th style="min-width: 200px">Title</th>
                <th style="min-width: 200px">Street Address</th>
                <th style="min-width: 200px">Apt, Suite</th>
                <th style="min-width: 100px">Zip Code</th>
                <th style="min-width: 150px">Actions</th>
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
            title: "Are you sure?",
            text: "You will not be able to revert this address",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
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
