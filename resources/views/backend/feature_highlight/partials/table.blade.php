<x-table :title="__('app.feature_highlight')" :addItemRoute="route('admin.feature-highlights.create')" :permissionName="App\Models\FeatureHighlight::CREATE">
    <table class="table" id="featureHighlightTable">
        <thead>
            <tr>
                <th>{{ __('app.image') }}</th>
                <th>{{ __('app.title') }}</th>
                <th>{{ __('app.description') }}</th> 
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center :id="'detailsModal'" :modal_title="__('app.feature_highlight_details')" :method="'PUT'" :action="'javascript:void(0)'">
    <div id="feature-highlight-details"></div>
</x-modal-center>
<script>
     $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const data = $('#featureHighlightTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.feature-highlights.get.list') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
                "columns": [    
                {
                    "data": "image"
                },
                {
                    "data": "title"
                },
                {
                    "data": "description"
                }, {
                    "data": "status"
                }, {
                    "data": "actions", 'sortable': false
                },
            ],

        })
    })

     function detailsModal(campaign) {
        let campaignDetailHTML = document.getElementById("feature-highlight-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr>
                            <td class="p-2" colspan="2" align="center">
                               <img style="height:8rem" class="img-fluid rounded" src="/${campaign['image']}" />
                            </td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.title') }}</th>
                            <td class="p-2">${campaign['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.description') }}</th>
                            <td class="p-2">${campaign['description']}</td>
                        </tr> 
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.status') }}</th>
                            <td class="p-2">${campaign['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm'>{{ __('app.enabled') }}</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>{{ __('app.disabled') }}</span"}</td>
                        </tr>
                        
                    </table>
                </div>`;
        // console.log(category);
        campaignDetailHTML.innerHTML = buildHTML;
    }
    function statusUpdate(id, btn) {
        let url = "{{ route('admin.feature-highlights.status.update', ':id') }}";
        url = url.replace(':id', id);

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_want_change_the_status') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_update_it') }}",
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

    function deleteFeatureHighlight(id, row)
     {
        let url = "{{ route('admin.feature-highlights.destroy', ':id') }}";
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

