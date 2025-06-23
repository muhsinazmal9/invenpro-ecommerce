<x-table
    :title="'Roles'"
    :addItemRoute="route('admin.role.create')"
    :permissionName="'create_role'"
>
    <table class="table" id="rolesTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Permissions</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</x-table>
<x-modal-center
    :id="'roleModal'"
    :modal_title="'Permissions'"
    :method="'PUT'"
    :action="'javascript:void(0)'"
>
    <div id="permissions-list"></div>
</x-modal-center>

<script>
    $(document).ready(function () {
        const token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        let data = $("#rolesTable").DataTable({
            order: [],
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{route('admin.role.getList') }}",
                dataType: "json",
                type: "GET",
                data: {
                    _token: token,
                },
            },
            columns: [
                {
                    data: "name",
                },
                {
                    data: "permission",
                },
                {
                    data: "created_at",
                },
                {
                    data: "actions",
                },
            ],
        });
    });

    function deleteRole(id, row) {
        let url = "{{ route('admin.role.destroy', ':id') }}";
        url = url.replace(":id", id);
        let method = "DELETE";
        let token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                itemDelete(url, method, token, row);
            }
        });
    }
    function toggleActions(dropdown) {
        dropdown.parentElement.classList.toggle("show");
        dropdown.nextElementSibling.classList.toggle("show");

        $(document).click(function (e) {
            if (!$(e.target).closest(".dropdown").length) {
                $(".dropdown-menu").removeClass("show");
            }
        });
    }

    function viewRole(permissions) {

        let permissionsHTML = document.getElementById("permissions-list");

        permissionsHTML.innerHTML = "";
        permissions.forEach((element) => {
            let li = document.createElement("li");
            li.innerHTML = element;
            permissionsHTML.append(li);
        });
    }
</script>
