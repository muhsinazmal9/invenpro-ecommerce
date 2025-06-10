@props(['name', 'id', 'class', 'value', 'checked', 'mainClass', 'data_bs_toggle', 'data_bs_placement', 'title'])
@php
    $class = $class ?? '';
@endphp
<div class="form-check checkbox-style checkbox-success d-inline-flex align-items-center gap-2 {{ $mainClass ?? '' }}" @isset($data_bs_toggle)
data-bs-toggle="tooltip" data-bs-placement="{{ $data_bs_placement }}" title="{{ $title }}" @endisset>
    <input class="form-check-input {{ $class }} @isset($data_bs_toggle) bs-tooltip @endisset" type="checkbox" value="{{ $value ?? '' }}" id="{{ $id }}"
        name="{{ $name }}" @isset ($checked) checked @endisset>
    <label class="form-check-label" for="{{ $id }}">{{ $slot }}</label>

</div>

