<x-table :title="__('app.faqs')" :addItemRoute="route('admin.faq.create')" :permissionName="App\Models\Faq::CREATE">
    <table class="table" id="faqTable">
        <thead>
            <tr>
                <th>{{ __('app.question') }}</th>
                <th>{{ __('app.category') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.created_at') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="__('app.faq_details')" :method="'PUT'" :action="'javascript:void(0)'">
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
                            <th class="p-2">{{ __('app.question') }} </th>
                            <td class="p-2">${faq['question']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.answer') }} </th>
                            <td class="p-2">${faq['answer']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.category') }} </th>
                            <td class="p-2">${faq.category.name}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.status') }}</th>
                            <td class="p-2">${faq['status'] ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ __('app.enabled') }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ __('app.disabled') }}</span"}</td>
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
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_want_to_change_the_status_of_this_faq') }}",
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
