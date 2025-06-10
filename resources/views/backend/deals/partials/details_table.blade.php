<x-table :title="__('app.deal_products')">
    <table class="table" id="dealsTable">
        <thead>
            <tr>
                <th>{{ __('app.thumbnail') }}</th>
                <th>{{ __('app.title') }}</th>
                <th>{{ __('app.sku') }}</th>
                <th>{{ __('app.price') }}</th>
                <th>{{ __('app.stock') }}</th>
                <th>{{ 'Category' }}</th>
                <th>{{ 'Subcategory' }}</th>
                <th>{{ __('app.subsub_category') }}</th>
                <th>{{ __('app.brand') }}</th>
                <th>{{ __('app.featured') }}</th>
                <th>{{ __('app.new_arrival') }}</th>
                <th>{{ __('app.status') }}</th>
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
