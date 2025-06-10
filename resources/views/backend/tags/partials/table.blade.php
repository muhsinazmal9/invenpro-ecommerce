<x-table :title="'Tags'" :addItemRoute="route('admin.tags.create')" :permissionName="App\Models\Tag::CREATE">
    <table class="table" id="tagsTable">
        <thead>
            <tr>
                <th>{{ 'Title' }}</th>
                <th>{{ 'Status' }}</th>
                <th  style="max-width: 15%">{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'Tag details'" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="tags-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#tagsTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.tags.getList') }}",
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

    function detailsModal(tag) {
        let tagsDetailHTML = document.getElementById("tags-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Title' }}</th>
                            <td class="p-2">${tag['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Status' }} </th>
                            <td class="p-2">${tag['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm tagStatusUpdate'>Enabled</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>Disabled</span"}</td>
                        </tr>
                    </table>
                </div>`;
        // console.log(tag);
        tagsDetailHTML.innerHTML = buildHTML;
    }

    function deletetags(slug, row) {
        let url = "{{ route('admin.tags.destroy', ':slug') }}";
        url = url.replace(':slug', slug);
        console.log('url', url);
        let method = "DELETE";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to delete this tag?' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, delete it!' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
            }
        })
    }

    function tagsStatusUpdate(slug, btn) {


        let url = "{{ route('admin.tags.status', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "patch";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this tag?' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, change it' }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: "PATCH",
                    url: url,
                    data: {
                        _token: token,
                    },
                    success: function(response) {

                        if (response.success) {
                            Swal.fire({
                                title: "{{ 'Success' }}",
                                text: response.message,
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
