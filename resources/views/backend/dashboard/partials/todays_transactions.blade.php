 <div class="card-style mb-30">
    <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
        <h6 class="text-medium mb-30">{{ 'Todays Transaction' }}</h6>
        </div>
    </div>
    <!-- End Title -->
    <div class="table-responsive">
        <table class="table transactions-table" id="transactionsTable">
            <thead>
                <tr>
                    <th>
                        <h6 class="text-sm text-medium">{{ 'Customer' }}</h6>
                    </th>
                    <th>
                        <h6 class="text-sm text-medium">{{ 'Transaction ID' }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ 'Payment Method' }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ 'Time' }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ 'Amount' }}</h6>
                    </th>
                </tr>
            </thead>
        </table>
        <!-- End Table -->
    </div>
</div>



<script>
    {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const data = $('#transactionsTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "sort" :false,
            "ajax": {
                "url": "{{ route('admin.dashboard.get.todays.transactions.list') }}",
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
                    "data": "transaction_id"
                },
                {
                    "data": "payment_method"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "amount"
                },
            ],

        })

    }

</script>

