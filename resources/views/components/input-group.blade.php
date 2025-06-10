@props([
    'type',
    'placeholder',
    'id',
    'name',
    'value',
    'required',
    'autocomplete',
    'disabled',
    'step',
    'max',
    'min',
    'class',
    'style',
])
<div class="input-style-3 @isset($class) {{ $class }} @endisset">

    <input @isset($type) type="{{ $type }}" @else  type="text" @endisset
        @isset($step) step="{{ $step }}"  @endisset
        @isset($placeholder) placeholder="{{ $placeholder }}"  @endisset
        @isset($id) id="{{ $id }}" @endisset
        @isset($name) name="{{ $name }}" @endisset value="{{ $value ?? '' }}"
        @isset($class) class="{{ $class }}" @endisset
        @isset($max) max="{{ $max }}" @endisset
        @isset($min) min="{{ $min }}" @endisset
        @isset($style) style="{{ $style }}" @endisset
        @isset($required) required @endisset
        @isset($disabled) disabled @endisset
        @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset />

    <span class="icon">
        {{ $slot }}
    </span>
</div>
