@props([
    'type',
    'style',

])
@php
    if(!isset($type)){
        $type= 'button';
    }
@endphp

<button type="{{$type}}"  class="main-btn primary-btn-light btn-hover btn-sm" style="{{$style ?? ""}}">
    {{$slot}}
</button>

