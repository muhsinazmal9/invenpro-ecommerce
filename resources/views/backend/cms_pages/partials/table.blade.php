<x-table :title="'Pages'" :addItemRoute="route('admin.pages.create')" :permissionName="App\Models\CmsPage::CREATE">
    <table class="table" id="pagesTable">
        <thead>
            <tr>
                <th>{{ 'Title' }}</th>
                <th>{{ 'Slug' }}</th>
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

        let data = $('#pagesTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.pages.getList') }}",
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
                    "data": "slug"
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

    function deletePage(slug, row) {
        let url = "{{ route('admin.pages.destroy', ':slug') }}";
        url = url.replace(':slug', slug);
        let method = "DELETE";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
            }
        })
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.pages.statusUpdate', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this page!' }}",
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
