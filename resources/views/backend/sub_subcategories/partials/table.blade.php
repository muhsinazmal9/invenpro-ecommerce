<x-table :title="'Sub Subcategories'" :addItemRoute="route('admin.subsub-category.create')" :permissionName="App\Models\SubsubCategory::CREATE">
    <table class="table" id="SubsubCategoryTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Parent Subcategory</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'Sub SubCategory Details'" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="SubsubCategory-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#SubsubCategoryTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.subsubcategory.getList') }}",
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
                    "data": "subcategory"
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

    function detailsModal(subsubcategory) {
        let subcategoryDetailHTML = document.getElementById("SubsubCategory-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr>
                            <th class="p-2">Image</th>
                            <td class="p-2"><img src="${subsubcategory.image}" alt="${subsubcategory.title}" width="75"></td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Title</th>
                            <td class="p-2">${subsubcategory['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Parent Subcategory</th>
                            <td class="p-2">${subsubcategory.subcategory?.title}</td>

                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Status</th>
                            <td class="p-2">${subsubcategory['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>Enabled</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>Disabled</span"}</td>
                        </tr>
                    </table>
                </div>`;
        // console.log(category);
        subcategoryDetailHTML.innerHTML = buildHTML;
    }

    function deleteSubsubCat(slug, row) {
        let url = "{{ route('admin.subsub-category.destroy', ':slug') }}";
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
        let url = "{{ route('admin.subsubcategory.statusUpdate', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to  the status of this subsubcategory!",
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

    function toggleActions(dropdown)
    {
            dropdown.parentElement.classList.toggle('show')
            dropdown.nextElementSibling.classList.toggle('show')

            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show')
                }
            })

    }

</script>
