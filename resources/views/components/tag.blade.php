@props(['tag'=>null, 'size' => 'base'])

@php
    $classes = 'bg-white/10 py-2 rounded-xl hover:bg-white/30';

if($size === 'base'){
   $classes .= ' text-2xs px-2';
}else if($size === 'medium'){
    $classes .= ' text-base px-4';
}else if($size=== 'large'){
   $classes .= ' text-2xl px-4';
}
@endphp


<a href="/tags/{{$tag->name??'?'}}" class="{{$classes}}">{{$tag->name??$slot}}</a>
