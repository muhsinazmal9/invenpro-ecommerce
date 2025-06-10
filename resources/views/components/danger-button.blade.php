@props([
    'type',
    'style',
    'id',
    'class',
    'data_id'
])
@php
    if(!isset($type)){
        $type= 'button';
    }
@endphp

<button
    type="{{$type}}"
    class="main-btn danger-btn btn-hover btn-sm {{ $class ?? "" }}"
    style="{{$style ?? ""}}"
    @isset($id) id="{{$id}}" @endisset
    @isset($data_id) data_id="{{$data_id}}" @endisset
    >
    {{$slot}}
</button>
