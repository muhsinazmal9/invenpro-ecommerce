@props([
'type',
'style',
'data_bs_dismiss',
'class', 'id'

])
@php
if (!isset($type)) {
$type = 'button';
}
@endphp

<button @isset($data_bs_dismiss) data-bs-dismiss={{ $data_bs_dismiss }} @endisset @isset($id) id="{{ $id }}" @endisset
    type="{{$type}}" class="main-btn secondary-btn btn-hover btn-sm {{ isset($class) ? $class : '' }}"
    style="{{$style ?? ""}}">
    {{$slot}}
</button>