<x-table :title="'Categories'" :addItemRoute="route('admin.category.create')" :permissionName="App\Models\Category::CREATE">
    <table class="table" id="categoryTable">
        <thead>
            <tr>
                <th>{{ 'Title' }}</th>
                <th>{{ 'Status' }}</th>
                <th width="100px">{{ 'Show in Quick Menu' }}</th>
                <th width="100px">{{ 'Show in Home Page' }}</th>
                <th>{{ 'Created at' }}</th>
                <th>{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'Category Details'" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="category-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#categoryTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.category.getList') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "status"
                },
                {
                    "data": "show_in_quick_menu"
                },
                {
                    "data": "show_in_home_page"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "actions"
                },
            ],

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

    function detailsModal(category) {
        let categoryDetailHTML = document.getElementById("category-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr>
                            <td class="p-2" colspan="2" align="center">
                                <img style="height:8rem" class="img-fluid rounded" src="/${category['image']}" />
                            </td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Title' }} </th>
                            <td class="p-2">${category['name']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Status' }}</th>
                            <td class="p-2">${category['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ 'Enabled' }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ 'Disabled' }}</span"}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Show in Quick Menu' }}</th>
                            <td class="p-2">${category['show_in_quick_menu'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ 'Enabled' }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ 'Disabled' }}</span"}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Show in Home Page' }}</th>
                            <td class="p-2">${category['show_in_home_page'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ 'Enabled' }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ 'Disabled' }}</span"}</td>
                        </tr>
                    </table>
                </div>`;
        // console.log(category);
        categoryDetailHTML.innerHTML = buildHTML;
    }

    function deleteCategory(slug, row) {
        let url = "{{ route('admin.category.destroy', ':slug') }}";
        url = url.replace(':slug', slug);
        let method = "DELETE";
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
                itemDelete(url, method, token, row)
            }
        })
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.category.statusUpdate', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this category?' }}",
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

                            if (response.data.status) {
                                $(btn).text("{{ 'Enabled' }}");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("{{ 'Disabled' }}");
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
