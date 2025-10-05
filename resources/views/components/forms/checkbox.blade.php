@props(['label', 'name','description'=>null])

@php
    $defaults = [
        'type' => 'checkbox',
        'id' => $name,
        'name' => $name,
        'value' => old($name)
    ];
@endphp

<x-forms.field :$label :$name>
    <div class="rounded-xl bg-blue-main/20 border border-white/10 px-5 py-1">
        <input {{ $attributes($defaults) }}>
        <span class="pl-1">{{ $description }}</span>
    </div>
</x-forms.field>
