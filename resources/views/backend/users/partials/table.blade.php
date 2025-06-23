<x-table :title="request()->input('type') == 'customers' ? \App\Models\User::CUSTOMER : \App\Models\User::USER" :addItemRoute="route('admin.users.create').((request()->input('type') == 'customers') ? '?type=customers' : '')" :permissionName="App\Models\User::CREATE">
    <style>
        .dataTable {
            width: calc(100% - 10px) !important;
        }
    </style>
    <table class="table" id="userTable">
        <thead>
            <tr>
                <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</x-table>

<x-modal-center :success_btn="'Assign'" :id="'roleModal'" :modal_title="'User Role'" :method="'PUT'" :action="'javascript:void(0)'"
:submitBtnId="'assignRoleBtn'">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Name</label>
            <x-input-group :type="'text'" :value="''" :id="'assign-role-selected-user'" :disabled="'disabled'">
                <i class="lni lni-user"></i>
            </x-input-group>
            <x-input-group :type="'hidden'" :value="''" :name="'assign_role_selected_user_id'" :id="'assign-role-selected-user-id'">
            </x-input-group>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Role</label>
            <x-input-group :type="'text'" :id="'assign-role-name'" :disabled="'disabled'">
                <span class="mdi mdi-account-key"></span>
            </x-input-group>
        </div>
    </div>
    <div class="col-md-12 mt-2">
        <x-input-select :name="'role'" :id="'assign-role'" :label="'Change Role'">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </x-input-select>
    </div>
</div>
</x-modal-center>

<script>
    $(document).ready(function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const type = "{{ request()->type ?? '' }}";

        if (type != '') {
            url = "{{ route('admin.users.getList') }}?type=" + type;
        } else {
            url = "{{ route('admin.users.getList') }}";
        }

        let data = $('#userTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "responsive": true, // make table responsive
            "autoWidth": false, // disable auto width
            "lengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            "pageLength": 5,
            "pagingType": "full_numbers", // pagination type1
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: token,
                }
            },
            "columns": [
                {
                    "data": "image",
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "data": "fname",
                },
                  {
                    "data": "lname",   
                },
                {
                    "data": "email",
                    "render": function(data, type, row, meta) {
                        return `<a href="mailto:${data}" style="word-wrap: break-word; color:#333">${data}</a>`;
                    }
                },
                {
                    "data": "status",
                },
                {
                    "data": "role",
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "actions",
                }
            ]
        });

        $("#assignRoleForm").submit(function() {
            let url = "{{ route('admin.role.assign', [':user', ':role']) }}";
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            url = url.replace(':user', $("#assign-role-selected-user-id").val());
            url = url.replace(':role', $("#assign-role").val());

            fetch(url, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: "PUT",
                    credentials: "same-origin",
                    body: data
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    $(".assign-role-modal").click();
                    if (200 == data.status) {
                        let roleBtn = ".role-btn-" + data.data.username;

                        $(roleBtn).text(data.data.roles[0].name);
                        Swal.fire(
                            'Success',
                            data.message,
                            'success'
                        );

                    } else {
                        Swal.fire(
                            'Failed',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(function(error) {
                    $(".assign-role-modal").click();
                    Swal.fire(
                        'Failed',
                        error.message,
                        'error'
                    );
                });
        })
    })

    function setAssignRoleModaldata(value) {
        let userName = document.getElementById('assign-role-selected-user');
        let userId = document.getElementById('assign-role-selected-user-id');
        let assignRoleName = document.getElementById('assign-role-name');
        userName.value = value.getAttribute('data-name');
        userId.value = value.getAttribute('data-id');
        assignRoleName.value = value.getAttribute('data-role');
    }


    function statusUpdate(username, btn) {
        let url = "{{ route('admin.users.status.update', ':username') }}";
        url = url.replace(':username', username);
        console.log(url)

        let method = "PATCH";
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to change the status of this user",
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

                            if (response.data.status ==
                                "{{ App\Models\User::STATUS['active'] }}") {
                                $(btn).text("ACTIVE");
                                $(btn).removeClass('danger-btn-light ');
                                $(btn).addClass('success-btn-light ');
                            } else {
                                $(btn).text("BLOCKED");
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
