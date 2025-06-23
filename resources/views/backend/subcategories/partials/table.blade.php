<x-table :title="'Subcategories'" :addItemRoute="route('admin.subcategory.create')"
    :permissionName="App\Models\Subcategory::CREATE">
    <table class="table" id="subcategoryTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Parent Category</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'Subcategory Details'" :method="'PUT'"
    :action="'javascript:void(0)'">
    <div id="subcategory-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#subcategoryTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.subcategory.getList') }}",
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
                    "data": "category"
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

    function detailsModal(subcategory) {
        let categoryDetailHTML = document.getElementById("subcategory-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr>
                            <td class="p-2" colspan="2" align="center">
                                <img style="height:8rem" class="img-fluid rounded" src="/${subcategory['image']}" />
                            </td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Title</th>
                            <td class="p-2">${subcategory['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Parent Category</th>
                            <td class="p-2">${subcategory.category?.name}</td>

                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Status</th>
                            <td class="p-2">${subcategory['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>Enabled</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>Disabled</span"}</td>
                        </tr>
                    </table>
                </div>`;
        // console.log(category);
        categoryDetailHTML.innerHTML = buildHTML;
    }



    function deleteSubCat(slug, row) {
        let url = "{{ route('admin.subcategory.destroy', ':slug') }}";
        url = url.replace(':slug', slug);
        let method = "DELETE";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
           }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
            }
            })
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.subcategory.statusUpdate', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to change the status of this subcategory!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update it!',
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
                                title: "Updated!",
                                text: "Status has been updated!",
                                icon: 'success',
                            });
                            console.log(response.data);
                            if (response.data.status) {
                                $(btn).text("Enabled");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("Disabled");
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
