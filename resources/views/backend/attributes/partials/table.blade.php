<x-table :title="'Attributes'" :addItemRoute="route('admin.attributes.create')" :permissionName="App\Models\Attribute::CREATE">
    <table class="table" id="attributeTable">
        <thead>
            <tr>
                <th>{{ 'Title' }}</th>
                <th>{{ 'Status' }}</th>
                <th>{{ 'Created at' }}</th>
                <th>{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'Brand Details'" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="brand-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let data = $('#attributeTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.attributes.getList') }}",
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
                            <th class="p-2">{{ 'Image' }}</th>
                            <td class="p-2"><img src="${brand['image'] ? (brand['image'].startsWith('/') ? '' : '/') + brand['image'] : '{{ getPlaceholderImage('160','100') }}'}" alt="brand image" style="width:100px;height:60px;object-fit:cover;border-radius:4px;" onerror="this.onerror=null;this.src='{{ getPlaceholderImage('160','100') }}';"></td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Title' }} </th>
                            <td class="p-2">${brand['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Status' }} </th>
                            <td class="p-2">${brand['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ 'Enabled' }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ 'Disabled' }}</span"}</td>
                        </tr>
                    </table>
                </div>`;
        brandDetailHTML.innerHTML = buildHTML;
    }

    function deleteAttribute(slug, row) {
        let url = "{{ route('admin.attributes.destroy', ':slug') }}";
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
            cancelButtonText: "{{ 'Cancel' }}"
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
            }
        })
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.attributes.status.update', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this attribute?' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
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
