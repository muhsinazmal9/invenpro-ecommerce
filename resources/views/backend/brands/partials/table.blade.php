<x-table :title="__('app.brands')" :addItemRoute="route('admin.brand.create')" :permissionName="App\Models\Brand::CREATE">
    <table class="table" id="brandTable">
        <thead>
            <tr>
                <th>{{ __('app.title') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.created_at') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="__('app.brand_details')" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="brand-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let data = $('#brandTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.brand.getList') }}",
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
                    "data": "status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "actions"
                }
            ]
        });

        function convertToReadableString(inputString) {
            // Split the input string into words based on underscores
            const words = inputString.split('_');

            // Capitalize the first letter of each word and convert the rest to lowercase
            const formattedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1)
                .toLowerCase());

            // Join the formatted words with spaces to create the readable string
            const readableString = formattedWords.join(' ');

            return readableString;
        }
    })

    function detailsModal(brand) {
        let brandDetailHTML = document.getElementById("brand-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.image') }}</th>
                            <td class="p-2"><img src="${brand['image'] ? (brand['image'].startsWith('/') ? '' : '/') + brand['image'] : '{{ getPlaceholderImage('160','100') }}'}" alt="brand image" style="width:100px;height:60px;object-fit:cover;border-radius:4px;" onerror="this.onerror=null;this.src='{{ getPlaceholderImage('160','100') }}';"></td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.title') }} </th>
                            <td class="p-2">${brand['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.status') }} </th>
                            <td class="p-2">${brand['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ __('app.enabled') }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ __('app.disabled') }}</span"}</td>
                        </tr>
                    </table>
                </div>`;
        brandDetailHTML.innerHTML = buildHTML;
    }

    function deleteBrand(slug, row) {
        let url = "{{ route('admin.brand.destroy', ':slug') }}";
        url = url.replace(':slug', slug);
        let method = "DELETE";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_will_not_be_able_to_revert_this') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_delete_it') }}",
            cancelButtonText: "{{ __('app.cancel') }}"
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
            }
        })
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.brand.status.update', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_want_to_change_the_status_of_this_brand') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_change_it') }}",
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

                            if (response.data.status) {
                                $(btn).text("{{ __('app.enabled') }}");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ __('app.disabled') }}");
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
