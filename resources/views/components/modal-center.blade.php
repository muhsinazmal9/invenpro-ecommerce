@props(['id', 'modal_title', 'method', 'methodSecond', 'action', 'success_btn'])
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <form id="assignRoleForm" method="{{ $method }}" action="{{ $action }}" class="p-6">
                @csrf
                @isset($methodSecond)
                    @method($methodSecond)
                @endisset
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
                    <button type="button" class="btn-close assign-role-modal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                @isset($success_btn)
                    <div class="modal-footer">
                        <x-secondary-button :type="'button'" :data_bs_dismiss="'modal'">Close</x-secondary-button>
                        <x-primary-button :type="'submit'">{{ $success_btn }}</x-primary-button>
                    </div>
                @endisset
            </form>
        </div>
    </div>
</div>
