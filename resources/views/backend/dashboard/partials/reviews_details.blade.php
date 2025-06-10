 <div class="card-style mb-30">
    <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
        <h6 class="text-medium mb-30">{{ __('app.all_reviews') }}</h6>
        </div>
    </div>
    <!-- End Title -->
    <div class="table-responsive">
        <table class="table review-table" id="reviewsTable">
            <thead>
                <tr>
                    <th>
                        <h6 class="text-sm text-medium">{{ __('app.invoice_id') }}</h6>
                    </th>
                    <th>
                        <h6 class="text-sm text-medium">{{ __('app.customer') }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ __('app.review') }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ __('app.rating') }}</h6>
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

        const data = $('#reviewsTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "sort" :false,
            "ajax": {
                "url": "{{ route('admin.dashboard.get.product.reviews') }}",
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
                    "data": "comment"
                },
                {
                    "data": "rating"
                },
            ],

        })

    }
</script>

