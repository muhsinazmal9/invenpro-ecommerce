<x-table :title="'Campaign'" :addItemRoute="route('admin.campaign.create')" :permissionName="App\Models\Campaign::CREATE">
    <table class="table" id="campaignTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Discount</th>
                <th>Discount Type</th>
                <th>Start Date</th>
                 <th>Start Time</th>
                 <th>End Date</th>
                 <th>End Time</th>
                 <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="'Campaign Details'" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="campaign-details"></div>
</x-modal-center>
<script>
     $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const data = $('#campaignTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.campaign.get.list') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [
                {
                    "data": "title"
                },
                {
                    "data": "image"

                },
                {
                    "data": "discount"
                },
                {
                    "data": "discount_type"
                },
                {
                    "data": "start_date"
                },
                {
                    "data": "start_time"
                },
                {
                    "data": "end_date"
                },
                {
                    "data": "end_time"
                }, {
                    "data": "status"
                }, {
                    "data": "actions"
                },
            ],

        })
    })

     function detailsModal(campaign) {
        let campaignDetailHTML = document.getElementById("campaign-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr>
                            <td class="p-2" colspan="2" align="center">
                               <img style="height:8rem" class="img-fluid rounded" src="/${campaign['image']}" />
                            </td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Title</th>
                            <td class="p-2">${campaign['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Discount</th>
                            <td class="p-2">${campaign['discount']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Discount Type</th>
                            <td class="p-2">${campaign['discount_type']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Start Date</th>
                            <td class="p-2"> ${new Date(campaign['start_date']).toLocaleDateString('en-US')}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Start Time</th>
                            <td class="p-2">${campaign['start_time']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">End Date</th>
                            <td class="p-2"> ${new Date(campaign['end_date']).toLocaleDateString('en-US')}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">End Time</th>
                            <td class="p-2">${campaign['end_time']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">Status</th>
                            <td class="p-2">${campaign['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>Enabled</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>Disabled</span"}</td>

                        </tr>
                    </table>
                </div>`;
        // console.log(category);
        campaignDetailHTML.innerHTML = buildHTML;
    }
    function statusUpdate(id, btn) {
        let url = "{{ route('admin.campaign.status.update', ':id') }}";
        url = url.replace(':id', id);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "Are you sure?",
            text: "You want change the status",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, Update it",
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
                                title: "Updated!",
                                text: "Status has been updated!",
                                icon: 'success',
                            });

                            if (response.data.status) {
                                $(btn).text("Enabled");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("Disabled");
                                $(btn).addClass('danger-btn-light ');
                                $(btn).removeClass('success-btn-light ');
                            }
                        }
                    },
                });
            }
        })
    }

    function deleteCampaign(id, row)
     {
        let url = "{{ route('admin.campaign.destroy', ':id') }}";
        url = url.replace(':id', id);
        let method = "DELETE";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
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

