@props([
    'label',
    'disabled',
    'class',
    'name',
    'id',
    'label_class',
    'isMultiple',
    'style',
    'title',
    'data_id',
    'data_extra',
    'tooltip',
])
<div class="select-style-1 mb-0">
    @isset($label)
        <label @isset($id) for="{{ $id }}" @endisset
            class="{{ isset($label_class) ? $label_class : '' }} mb-2"><strong>{{ $label }}</strong>
            {!! isset($tooltip)
                ? "<span data-bs-toggle='tooltip' class='custom_tooltip' style='cursor: pointer;' title='{$tooltip}'><span class='mdi mdi-information'></span></span>"
                : '' !!}
        </label>
    @endisset
    <div class="select-position input-style-3">
        <select @isset($name)name="{{ $name }}" @endisset
            @isset($class) class="{{ $class }}" @endisset
            @isset($id) id="{{ $id }}"  @endisset
            @isset($disabled) disabled @endisset
            @isset($style) style="{{ $style }}" @endisset
            @isset($title) title="{{ $title }}" @endisset
            @isset($isMultiple) multiple="multiple" @endisset
            @isset($data_extra) data_extra="{{ $data_extra }}" @endisset
            @isset($data_id) data_id="{{ $data_id }}" @endisset>
            {{ $slot }}
        </select>
    </div>
</div>
