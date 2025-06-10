@props(['active', 'link', 'icon', 'can', 'permissionCheck'])

@php
    $classes = $active ? ' active' : '';
@endphp

@if (isset($link) && checkUserPermission($permissionCheck))
    <li {{ $attributes->merge(['class' => 'nav-item' . $classes]) }}>
        <a href="{{ $link }}">
            @isset($icon)
                <span class="icon">
                    <i class="{{ $icon }}"></i>
                </span>
            @endisset
            <span class="text">{{ $slot }}</span>
        </a>
    </li>
@endisset

