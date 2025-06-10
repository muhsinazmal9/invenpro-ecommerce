<div class="card-style mb-30">
    {{-- Table title and Add button --}}
    <div class="d-flex justify-content-between mb-3">
    </div>
    {{-- Table --}}
    <div class="table-wrapper table-responsive">
        <style>
            .dataTable {
                width: calc(100% - 10px) !important;
            }
        </style>
         <table class="table" id="transactionsTable">
            <thead>
                <tr>
                    <th>
                        <h6 class="text-sm text-medium">{{ __('app.customer') }}</h6>
                    </th>
                    <th>
                        <h6 class="text-sm text-medium">{{ __('app.transaction_id') }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ __('app.payment_method') }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ __('app.status') }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ __('app.created_at') }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ __('app.amount') }}</h6>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const requestStatus = "{{request()->status}}" != '' ? "{{request()->status}}" : null
    
    let url = "{{ route('admin.reports.transactions.getList') }}";

    if(requestStatus){
        url = "{{ route('admin.reports.transactions.getList') }}?status="+requestStatus;
    }

    const data = $('#transactionsTable').DataTable({
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
                "data": "customer_name"
            },
            {
                "data": "transaction_id"
            },
            {
                "data": "payment_method"
            },
            {
                "data": "status"
            },
            {
                "data": "created_at"
            },
            {
                "data": "amount"
            },
        ],

    })
</script>
