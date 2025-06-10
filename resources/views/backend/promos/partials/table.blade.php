<x-table :title="__('app.promos')" :addItemRoute="route('admin.promo.create')" :permissionName="App\Models\Promo::CREATE">
    <table class="table" id="promoTable">
        <thead>
            <tr>
                <th>{{ __('app.title') }}</th>
                <th>{{ __('app.limit') }}</th>
                <th>{{ __('app.code') }}</th>
                <th>{{ __('app.discount') }}</th>
                <th>{{ __('app.discount_type') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center
    :id="'detailsModal'"
    :modal_title="__('app.promo_details')"
    :method="'PUT'"
    :action="'javascript:void(0)'"
    >

    <div id="promo-details"></div>
</x-modal-center>

<script>
    $(document).ready(function() {

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let data = $('#promoTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('admin.promo.getList') }}",
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
                    "data": "limit"
                },
                {
                    "data": "code"
                },
                {
                    "data": "discount"
                },{
                    "data": "discount_type"
                },
                {
                    "data": "status"
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
    
    function detailsModal(promo) {
        let promoDetailHTML = document.getElementById("promo-details");
        let buildHTML = `
                <div class="">
                    <table  class="table-bordered p-5 mx-auto" style="border-color:#00000052 !important; width: 100%">
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.title') }} </th>
                            <td class="p-2">${promo['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{__('app.limit')}} </th>
                            <td class="p-2">${promo['limit']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{__('app.code')}} </th>
                            <td class="p-2">${promo['code']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{__('app.discount')}} </th>
                            <td class="p-2">${promo['discount']}%</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{__('app.discount_type')}} </th>
                            <td class="p-2">${promo['discount_type']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ __('app.status') }} </th>
                            <td class="p-2">${promo['status'] == '1' ? "<span class='main-btn success-btn-light btn-hover btn-sm promoStatusUpdate'>Enabled</span" : "<span class='main-btn danger-btn-light btn-hover btn-sm'>Disabled</span"}</td>
                        </tr>
                    </table>
                </div>`;
        // console.log(promo);
        promoDetailHTML.innerHTML = buildHTML;
    }
    function deletePromo(slug, row) {
        let url = "{{ route('admin.promo.destroy', ':slug') }}";
        url = url.replace(':slug', slug);
        let method = "DELETE";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_will_not_be_able_to_revert_this') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_delete_it') }}"
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row)
            }
        })
    }

    function promoStatusUpdate(slug,btn){


        let url = "{{ route('admin.promo.status', ':slug') }}";
        url = url.replace(':slug', slug);

        let method = "patch";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title:"{{ __('app.are_you_sure') }}",
            text: "{{ __('app.you_want_to_change_the_status_of_this_promo!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('app.yes_update_it!') }}",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: "PATCH",
                    url: url,
                    data: {
                        _token: token,
                    },
                    success: function(response) {

                        if(response.success){
                            Swal.fire({
                                title: "{{ __('app.updated!') }}",
                                text: "{{ __('app.promo_status_has_been_updated.') }}",
                                icon: 'success',
                            });



                            if(response.data.status){

                                $(btn).text('Enabled');
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');

                            }else{

                                $(btn).text('Disabled');
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
