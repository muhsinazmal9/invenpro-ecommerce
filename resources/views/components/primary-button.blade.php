@props(['type', 'style', 'id', 'class'])
@php
if (!isset($type)) {
$type = 'button';
}
@endphp

<button {{ isset($id) ? "id={$id}" : '' }} type="{{ $type }}"
    class="main-btn primary-btn btn-hover btn-sm {{ isset($class) ? $class : '' }}" style="{{ $style ?? '' }}">
    {{ $slot }}
</button>