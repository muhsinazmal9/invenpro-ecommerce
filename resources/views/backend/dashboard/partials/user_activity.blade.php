 <div class="card-style mb-30">
    <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
        <h6 class="text-medium mb-30">{{ 'User Engagement' }}</h6>
        </div>
    </div>
    <!-- End Title -->
    <div class="table-responsive">
        <table class="table transactions-table" id="userActivityTable">
            <thead>
                <tr>
                    <th>
                        <h6 class="text-sm text-medium">{{ 'User' }}</h6>
                    </th>
                    <th>
                        <h6 class="text-sm text-medium">{{ 'Logs' }}</h6>
                    </th>
                    <th class="min-width">
                        <h6 class="text-sm text-medium">{{ 'Date and Time' }}</h6>
                    </th>
                </tr>
            </thead>
        </table>
        <!-- End Table -->
    </div>
</div>



<script>
    {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const data = $('#userActivityTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "searching": false,
            
            "ordering": false,
            "ajax": {
                "url": "{{ route('admin.dashboard.get.user.activity.list') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [{
                    "data": "user_id"
                },
                {
                    "data": "activity"
                },
                {
                    "data": "created_at"
                },
            ],

        })

    }

</script>

