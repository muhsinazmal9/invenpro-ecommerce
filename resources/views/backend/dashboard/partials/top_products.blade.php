 <div class="card-style mb-30">
    <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
        <h6 class="text-medium mb-30">{{ 'Top Selling Products' }}</h6>
        </div>
    </div>
    <!-- End Title -->
    <div class="table-responsive">
        <table class="table top-product-table" id="topProductTable">
            <thead>
                <tr>
                <th>
                    <h6 class="text-sm text-medium">{{ 'Products' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Category' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Subcategory' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Price' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Sold' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Stock' }}</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">{{ 'Actions' }}</h6>
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

