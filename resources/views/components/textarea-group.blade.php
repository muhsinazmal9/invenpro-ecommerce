@props(['placeholder', 'class', 'name', 'id', 'rows'])
<div class="input-style-3">

    <textarea @isset($placeholder) placeholder="{{ $placeholder }}"@endisset
        @isset($rows) id="{{ $rows }}"@endisset
        @isset($id) id="{{ $id }}"@endisset
        @isset($class) class="{{ $class }}"@endisset
        @isset($name) name="{{ $name }}"@endisset>{{ $slot }}</textarea>

    <span class="icon"><i class="lni lni-text-format"></i></span>
</div>
