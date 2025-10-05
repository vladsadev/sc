@props(['label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'px-2 py-2 w-full rounded-xl border focus:border-yellow-main focus:ring-0 placeholder:text-blue-main/25',

    ];
@endphp

<x-forms.field :$label :$name>
    <select {{ $attributes($defaults) }}>
        {{ $slot }}
    </select>
</x-forms.field>
