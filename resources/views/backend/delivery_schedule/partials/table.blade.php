<x-table :title="__('app.delivery_schedules')" >
    <table class="table" id="deliveryscheduleTable">
        <thead>
            <tr>
                <th>{{ __('app.name') }}</th>
                <th>{{ __('app.status') }}</th>
            </tr>
        </thead>
    </table>

</x-table>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#deliveryscheduleTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.delivery-schedule.getList') }}",
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

            ],

        })
        //console.log(data);
    })

    function statusUpdate(id, btn) {
        let url = "{{ route('admin.delivery-schedule.status', ':id') }}";
        url = url.replace(':id', id);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_want_to_change_the_status_of_this_delivery_schedule_status') }}",
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
                            $('#deliveryscheduleTable').DataTable().ajax.reload();
                        }
                    },
                });
            }
        })
    }
</script>
