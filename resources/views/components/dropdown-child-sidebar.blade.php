@props(['active', 'type'=>'', 'name', 'link', 'permissionCheck'])

@if (isset($link) && checkUserPermission($permissionCheck))
    <li class="nav-item {{ $active && (request()->query('status') == $type) ? 'active' : '' }}">
        <a href="{{ $link }}">{!! $name !!}</a>
    </li>
@endisset
