<div class="mb-2 d-flex gap-2">
    <x-primary-anchor :href="route('admin.products.index')">
        {{ __('app.all') }}
    </x-primary-anchor>
    <x-primary-anchor :href="route('admin.products.index') . '?query=topproduct'">
        {{ __('app.top_products') }}
    </x-primary-anchor>
    <x-primary-anchor :href="route('admin.products.index') . '?query=lowstock'">
        {{ __('app.low_stock') }}
    </x-primary-anchor>
</div>
<x-table :title="__('app.products')" :addItemRoute="route('admin.products.create')" :permissionName="App\Models\PRODUCT::CREATE">
    <table class="table" id="productsTable">
        <thead>
            <tr>
                <th>{{ __('app.thumbnail') }}</th>
                <th>{{ __('app.title') }}</th>
                <th>{{ __('app.sku') }}</th>
                <th>{{ __('app.price') }}</th>
                <th>{{ __('app.stock') }}</th>
                <th>{{ __('app.category') }}</th>
                <th>{{ __('app.subcategory') }}</th>
                <th>{{ __('app.subsub_category') }}</th>
                <th>{{ __('app.brand') }}</th>
                <th>{{ __('app.featured') }}</th>
                <th>{{ __('app.new_arrival') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.created_at') }}</th>
                <th>{{ __('app.actions') }}</th>
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
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_will_not_be_able_to_revert_this') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_delete_it') }}",
            cancelButtonText: "{{ __('app.cancel') }}",
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
                                title: "{{ __('app.deleted') }}",
                                text: "{{ __('app.product_deleted_successfully') }}",
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
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_want_to_change_the_status_of_this_product') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_update_it') }}",
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
                                title: "{{ __('app.updated') }}",
                                text: "{{ __('app.status_has_been_updated') }}",
                                icon: 'success',
                            });

                            if (response.data.status ===
                                "{{ App\Models\PRODUCT::STATUS['published'] }}") {
                                $(btn).text("{{ __('app.published') }}");
                                $(btn).removeClass('secondary-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ __('app.draft') }}");
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
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.are_you_sure_to_update_featured_status') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_update_it') }}",
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
                                title: "{{ __('app.updated') }}",
                                text: "{{ __('app.featured_status_has_been_updated') }}",
                                icon: 'success',
                            });

                            if (response.data.featured) {
                                $(btn).text("{{ __('app.yes') }}");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ __('app.no') }}");
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
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.are_you_sure_to_update_new_arrival_status') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_update_it') }}",
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
                                title: "{{ __('app.updated') }}",
                                text: "{{ __('app.new_arrival_status_has_been_updated') }}",
                                icon: 'success',
                            });

                            if (response.data.new_arrival) {
                                $(btn).text("{{ __('app.yes') }}");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ __('app.no') }}");
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
