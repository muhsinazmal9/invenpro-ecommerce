<x-table :title="request()->input('type') == 'popup' ? \App\Models\Banner::POPUP : \App\Models\Banner::BANNER" :addItemRoute="route('admin.banner.create').((request()->input('type') == 'popup') ? '?type=popup' : '')" :permissionName="App\Models\Banner::CREATE">
    <table class="table" id="bannerTable">
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
    <div id="banner-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const type = "{{ request()->type ?? '' }}";
        if (type != '') {
        url = "{{ route('admin.banner.getList') }}?type=" + type;
        } else {
        url = "{{ route('admin.banner.getList') }}";
        }

        let data = $('#bannerTable').DataTable({
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

    function detailsModal(banner) {
        let categoryDetailHTML = document.getElementById("banner-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr>
                            <td class="p-2" colspan="2" align="center">
                                <img style="height:8rem" class="img-fluid rounded" src="/${banner['image']}" />
                            </td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Title' }}</th>
                            <td class="p-2">${banner['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Link' }}</th>
                            <td class="p-2">${banner['link']}</td>
                        </tr>
                        @if (request()->input('type') == 'popup')

                        <tr class="mt-5">
                            <th class="p-2">{{ 'Countdown Start' }}</th>
                            <td class="p-2">${new Date(banner['countdown_start']).toLocaleString('en-US')}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Countdown End' }}</th>
                            <td class="p-2">${new Date(banner['countdown_end']).toLocaleString('en-US')}</td>
                        </tr>
                        @endif
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Status' }}</th>
                            <td class="p-2">${banner['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ 'Enabled' }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ 'Disabled' }}</span"}</td>
                        </tr>
                    </table>
                </div>`;
        // console.log(category);
        categoryDetailHTML.innerHTML = buildHTML;
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.banner.statusUpdate', ':slug') }}";
        url = url.replace(':slug', slug);
        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this card!' }}",
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

    function deleteBanner(slug, row) {
        let url = "{{ route('admin.banner.destroy', ':slug') }}";
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
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
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
