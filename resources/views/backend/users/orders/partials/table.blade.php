<x-table :title="'Orders'" >
    <style>
        .dataTable {
            width: calc(100% - 10px) !important;
        }
    </style>
    <table class="table" id="orderTable">
        <thead>
            <tr>
                <th style="min-width: 200px">{{ 'Invoice Id' }}</th>
                <th style="min-width: 200px">{{ 'Amount' }}</th>
                <th style="min-width: 200px">{{ 'Status' }}</th>
                <th style="min-width: 100px">{{ 'Products' }}</th>
                <th style="min-width: 150px">{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>
</x-table>
<script>
    $(document).ready(function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        url = "{{ route('admin.orders.getUserOrderList', $user->username) }}";

        let data = $('#orderTable').DataTable({
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
                    "data": "invoice_id"
                },
                {
                    "data": "amount"
                },
                {
                    "data": "status"
                },
                {
                    "data": "product_id"
                },
                {
                    "data": "actions"
                }
            ]
        });
    })
</script>
