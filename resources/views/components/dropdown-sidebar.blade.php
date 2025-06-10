@props(['name', 'icon_class', 'id'])

<li class="nav-item nav-item-has-children">
    <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#{{ $id }}"
        aria-controls="{{ $id }}"
        aria-expanded="{{ request()->is($id.'*') ? 'true' : 'false' }}"
        aria-label="Toggle navigation">
        <span class="icon">
            <span class="{{ $icon_class }}"></span>
        </span>
        <span class="text">
            {{ $name }}
        </span>
    </a>
    <ul id="{{ $id }}" class="collapse dropdown-nav {{ request()->is($id.'*') ? 'show' : '' }}" data-parent=".nav-item-has-children">
        {{ $slot }}
    </ul>
</li>
