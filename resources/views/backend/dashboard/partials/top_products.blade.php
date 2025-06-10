 <div class="card-style mb-30">
    <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
        <h6 class="text-medium mb-30">{{ __('app.top_selling_products') }}</h6>
        </div>
    </div>
    <!-- End Title -->
    <div class="table-responsive">
        <table class="table top-product-table" id="topProductTable">
            <thead>
                <tr>
                <th>
                    <h6 class="text-sm text-medium">{{ __('app.products') }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Category' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Subcategory' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ __('app.price') }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ __('app.sold') }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ __('app.stock') }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ __('app.actions') }}</h6>
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

        const data = $('#topProductTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            'sort': false,
            "lengthMenu": [
                [5, 10, 25,50],
                [5, 10, 25,50]
            ],
            "ajax": {
                "url": "{{ route('admin.dashboard.get.top.products') }}",
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
                    "data": "category_id"
                },
                {
                    "data": "subcategory_id"
                },
                {
                    "data": "price"
                },
                {
                    "data": "sold"
                },
                {
                    "data": "stock"
                },
                {
                    "data": "actions"
                },
            ],

        })
    }

</script>

