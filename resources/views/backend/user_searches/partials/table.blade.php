<x-table :title="'User searches'">
    <table class="table" id="userSearchTable">
        <thead>
            <tr>
                <th>{{ 'Keyword' }}</th>
                <th>{{ 'Count' }}</th>
                <th>{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="__('app.user_search_details')" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="user-search-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#userSearchTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.user-searches.getList') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "keyword"
                },
                {
                    "data": "count"
                },
                {
                    "data": "actions"
                },
            ],

        })
        console.log(data);
    })

    function deleteUserSearch(id, row) {
        let url = "{{ route('admin.user-searches.destroy', ':id') }}";
        url = url.replace(':id', id);
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
</script>
