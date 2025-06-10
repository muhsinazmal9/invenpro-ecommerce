<x-table :title="__('app.orders')" >
    <style>
        .dataTable {
            width: calc(100% - 10px) !important;
        }
    </style>
    <table class="table" id="orderTable">
        <thead>
            <tr>
                <th style="min-width: 200px">{{ __('app.invoice_id') }}</th>
                <th style="min-width: 200px">{{ __('app.amount') }}</th>
                <th style="min-width: 200px">{{ __('app.status') }}</th>
                <th style="min-width: 100px">{{ __('app.products') }}</th>
                <th style="min-width: 150px">{{ __('app.actions') }}</th>
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
