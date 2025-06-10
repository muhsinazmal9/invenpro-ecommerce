<div class="mb-2 d-flex gap-2">
    <x-primary-anchor :href="route('admin.products.index')">
        {{ 'All' }}
    </x-primary-anchor>
    <x-primary-anchor :href="route('admin.products.index') . '?query=topproduct'">
        {{ 'Top Products' }}
    </x-primary-anchor>
    <x-primary-anchor :href="route('admin.products.index') . '?query=lowstock'">
        {{ 'Low Stock' }}
    </x-primary-anchor>
</div>
<x-table :title="'Products'" :addItemRoute="route('admin.products.create')" :permissionName="App\Models\PRODUCT::CREATE">
    <table class="table" id="productsTable">
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
                <th>{{ 'Created at' }}</th>
                <th>{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const requestStock = "{{ request()->input('query') }}" != '' ? "{{ request()->input('query') }}" :
            null

        let url = "{{ route('admin.products.get.list') }}";

        if (requestStock) {
            url = "{{ route('admin.products.get.list') }}?query=" + requestStock;
        }

        const data = $('#productsTable').DataTable({
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
                {
                    "data": "created_at"
                },
                {
                    "data": "actions"
                },
            ],

        })
    })



    function deleteProduct(slug) {
        let url = "{{ route('admin.products.destroy', ':slug') }}";
        url = url.replace(':slug', slug);
        let method = "delete";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You will not be able to revert this!' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, delete it!' }}",
            cancelButtonText: "{{ 'Cancel' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: {
                        _token: token,
                        _method: method,
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "{{ 'Deleted' }}",
                                text: "{{ 'Product deleted successfully' }}",
                                icon: 'success',
                            });

                            $('#productsTable').DataTable().ajax.reload();
                        }
                    },
                });
            }
        })
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.products.status.update', ':slug') }}";
        url = url.replace(':slug', slug);


        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this product?' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, Update it' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: "PATCH",
                    url: url,
                    data: {
                        _token: token,
                        _method: method,
                    },
                    success: function(response) {
                        console.log(response)

                        if (response.success) {
                            Swal.fire({
                                title: "{{ 'Updated!' }}",
                                text: "{{ 'Status has been updated!' }}",
                                icon: 'success',
                            });

                            if (response.data.status ===
                                "{{ App\Models\PRODUCT::STATUS['published'] }}") {
                                $(btn).text("{{ 'Published' }}");
                                $(btn).removeClass('secondary-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ 'Draft' }}");
                                $(btn).addClass('secondary-btn-light ');
                                $(btn).removeClass('success-btn-light ');
                            }
                        }
                    },
                });
            }
        })
    }

    function featuredUpdate(slug, btn) {
        let url = "{{ route('admin.products.featured.update', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'Are you sure to update featured status?' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, Update it' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: "PATCH",
                    url: url,
                    data: {
                        _token: token,
                        _method: method,
                    },
                    success: function(response) {
                        console.log(response)

                        if (response.success) {
                            Swal.fire({
                                title: "{{ 'Updated!' }}",
                                text: "{{ 'Featured status has been updated' }}",
                                icon: 'success',
                            });

                            if (response.data.featured) {
                                $(btn).text("{{ 'Yes' }}");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ 'No' }}");
                                $(btn).addClass('danger-btn-light ');
                                $(btn).removeClass('success-btn-light ');
                            }
                        }
                    },
                });
            }
        })
    }

    function newarrivalUpdate(slug, btn) {
        let url = "{{ route('admin.products.new-arrival.update', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'Are aou sure to update new arrival status' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, Update it' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: "PATCH",
                    url: url,
                    data: {
                        _token: token,
                        _method: method,
                    },
                    success: function(response) {
                        console.log(response)

                        if (response.success) {
                            Swal.fire({
                                title: "{{ 'Updated!' }}",
                                text: "{{ 'New arrival status has been updated' }}",
                                icon: 'success',
                            });

                            if (response.data.new_arrival) {
                                $(btn).text("{{ 'Yes' }}");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ 'No' }}");
                                $(btn).addClass('danger-btn-light ');
                                $(btn).removeClass('success-btn-light ');
                            }
                        }
                    },
                });
            }
        })
    }

    function toggleActions(dropdown) {
        dropdown.parentElement.classList.toggle('show')
        dropdown.nextElementSibling.classList.toggle('show')

        $(document).click(function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show')
            }
        })

    }
</script>
