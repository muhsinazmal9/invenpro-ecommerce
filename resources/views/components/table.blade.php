@props(['title', 'addItemRoute', 'permissionName'])
<div class="card-style mb-30 rounded-3">
    {{-- Table title and Add button --}}
    <div class="d-flex justify-content-between mb-3">
        <h4 class="mb-10 card-title">{{ $title }}</h4>
        @if (isset($addItemRoute, $permissionName) && $addItemRoute != '' && checkUserPermission($permissionName))
            <x-primary-anchor :href="$addItemRoute" data-bs-toggle="modal" data-bs-target="#exampleModal">
                {{ 'Add' }}
            </x-primary-anchor>
        @endif
    </div>
    {{-- Table --}}
    <div class="table-wrapper table-responsive">
        {{ $slot }}
    </div>
</div>
