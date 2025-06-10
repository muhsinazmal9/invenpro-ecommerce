<x-table :title="'FAQs'" :addItemRoute="route('admin.faq.create')" :permissionName="App\Models\Faq::CREATE">
    <table class="table" id="faqTable">
        <thead>
            <tr>
                <th>{{ 'Question' }}</th>
                <th>{{ 'Category' }}</th>
                <th>{{ 'Status' }}</th>
                <th>{{ 'Created at' }}</th>
                <th>{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'FAQ Details'" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="faq-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#faqTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.faq.getList') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "question"
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

        })
        console.log(data);
    })

    function detailsModal(faq) {
        let faqDetailHTML = document.getElementById("faq-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr>
                            <th class="p-2">{{ 'Question' }} </th>
                            <td class="p-2">${faq['question']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Answer' }} </th>
                            <td class="p-2">${faq['answer']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Category' }} </th>
                            <td class="p-2">${faq.category.name}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Status' }}</th>
                            <td class="p-2">${faq['status'] ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ 'Enabled' }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ 'Disabled' }}</span"}</td>
                        </tr>
                    </table>
                </div>`;
        faqDetailHTML.innerHTML = buildHTML;
    }

    function deleteFaq(slug, row) {
        let url = "{{ route('admin.faq.destroy', ':slug') }}";
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
                itemDelete(url, method, token, row)
            }
        })
    }

    function statusUpdate(slug, btn) {
        let url = "{{ route('admin.faq.statusUpdate', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this FAQ!' }}",
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
