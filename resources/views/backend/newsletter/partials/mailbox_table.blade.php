<x-table :title="__('app.news_letter')" :addItemRoute="route('admin.newsletter.create')"
    :permissionName="App\Models\Newsletter::CREATE">
    <table class="table" id="mailboxTable">
        <thead>
            <tr>
                <th>{{ __('app.subject') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.created_at') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
    </table>
</x-table>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#mailboxTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.newsletter.mail.List') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "subject"
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

    function deletemailBox(id, row)
    {
        let url = "{{ route('admin.newsletter.destroy', ':id') }}";
        url = url.replace(':id', id);
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
        cancelButtonText: "{{ __('app.cancel') }}",
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
