<x-table :title="'Promos'" :addItemRoute="route('admin.promo.create')" :permissionName="App\Models\Promo::CREATE">
    <table class="table" id="promoTable">
        <thead>
            <tr>
                <th>{{ 'Title' }}</th>
                <th>{{ 'Limit' }}</th>
                <th>{{ 'Code' }}</th>
                <th>{{ 'Discount' }}</th>
                <th>{{ 'Discount Type' }}</th>
                <th>{{ 'Status' }}</th>
                <th>{{ 'Actions' }}</th>
            </tr>
        </thead>
    </table>

</x-table>
<x-modal-center
    :id="'detailsModal'"
    :modal_title="'Promo Details'"
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
                            <th class="p-2">{{ 'Title' }} </th>
                            <td class="p-2">${promo['title']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{'Limit'}} </th>
                            <td class="p-2">${promo['limit']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{'Code'}} </th>
                            <td class="p-2">${promo['code']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{'Discount'}} </th>
                            <td class="p-2">${promo['discount']}%</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{'Discount Type'}} </th>
                            <td class="p-2">${promo['discount_type']}</td>
                        </tr>
                        <tr class="mt-5">
                            <th class="p-2">{{ 'Status' }} </th>
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
            title: "{{ 'Are you sure?' }}",
            text: "{{ 'You will not be able to revert this!' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, delete it!' }}"
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
            title:"{{ 'Are you sure?' }}",
            text: "{{ 'You want to change the status of this promo!' }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ 'Yes, Update it!' }}",
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
                                title: "{{ 'Updated!' }}",
                                text: "{{ 'Promo status has been updated.' }}",
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
