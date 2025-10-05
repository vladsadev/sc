@props(['label'=>null, 'name' => null])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => 'px-2 py-2 w-full rounded-xl border focus:border-yellow-main focus:ring-0 placeholder:text-blue-main/35',
        'value' => old($name)
    ];
@endphp

<x-forms.field :$label :$name>

    <input {{ $attributes($defaults) }}>

</x-forms.field>
