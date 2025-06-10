@props([
    'href',
    'style',
    'class',
])
<a href="{{$href}}" class="main-btn primary-btn btn-hover btn-sm  {{ isset($class) ? $class :""}}" style="{{$style ?? ""}}">
    {{$slot}}
</a>
