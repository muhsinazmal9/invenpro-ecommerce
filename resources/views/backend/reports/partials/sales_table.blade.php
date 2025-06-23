

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
        <table class="table stripe" id="salesReportTable">
            <thead>
                <tr>
                    <th>Invoice Id</th>
                    <th>Customer</th>
                    <th>Subtotal</th>
                    <th>Shipping Charge</th>
                    <th>TAX</th>    
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<script>

    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#salesReportTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.reports.sales.getList') }}",
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
                    "data": "user_id"
                },
                {
                    "data": "subtotal"
                },
                {
                    "data": "shipping_charge"
                },{
                    "data": "tax"
                },
                {
                    "data": "grand_total"
                },
                {
                    "data": "actions"
                },
            ],

        });
    });


</script>
