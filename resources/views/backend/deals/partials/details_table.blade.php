<x-table :title="'Deal Products'">
    <table class="table" id="dealsTable">
        <thead>
            <tr>
                <th>{{ 'Thumbnail' }}</th>
                <th>{{ 'Title' }}</th>
                <th>{{ 'SKU' }}</th>
                <th>{{ 'Price' }}</th>
                <th>{{ 'Stock' }}</th>
                <th>{{ 'Category' }}</th>
                <th>{{ 'Subcategory' }}</th>
                <th>{{ 'Sub subcategory' }}</th>
                <th>{{ 'Brand' }}</th>
                <th>{{ 'Featured' }}</th>
                <th>{{ 'New Arrival' }}</th>
                <th>{{ 'Status' }}</th>
            </tr>
        </thead>
    </table>

</x-table>

<script>
    const dealSlug = "{{ $deal->slug }}";
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let url = "{{ route('admin.deals.detailsList') }}/?slug="+dealSlug;


        const data = $('#dealsTable').DataTable({
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
                    "data": "thumbnail"
                },
                {
                    "data": "title"
                },
                {
                    "data": "sku"

                },
                {
                    "data": "price"
                },
                {
                    "data": "stock"
                },
                {
                    "data": "category_id"
                },
                {
                    "data": "subcategory_id"
                },
                {
                    "data": "subsub_category_id"
                },
                {
                    "data": "brand_id"
                },
                {
                    "data": "featured"
                },
                {
                "data": "new_arrival"
                },
                {
                    "data": "status"
                },
            ],

        })
    })

</script>
