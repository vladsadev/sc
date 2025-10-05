@props([
    'variant' => 'primary',
    'size' => 'md',
    'class' => '',
    'disabled' => false
])

@php
    $baseClasses = 'cursor-pointer font-semibold rounded-md transition-colors duration-300 inline-flex items-center justify-center';

    $variants = [
        'primary' => 'bg-yellow-main hover:bg-blue-main text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-600 text-white',
        'action' => 'bg-blue',
        'danger' => 'bg-red-600 hover:bg-blue-main text-white',
        'db' => 'bg-rose-900 hover:bg-gray-600 text-white',
        'outline-solid' => 'border-2 border-yellow-main text-yellow-main hover:bg-yellow-main hover:text-white',
        'ghost' => 'text-yellow-main hover:bg-yellow-main hover:text-white',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm lg:text-md',
        'lg' => 'px-6 py-3 text-md lg:text-lg',
        'xl' => 'px-8 py-4 text-lg lg:text-xl',
    ];

    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';

    $classes = collect([
        $baseClasses,
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? $sizes['md'],
        $disabledClasses,
        $class
    ])->filter()->implode(' ');
@endphp

<button {{ $attributes->class($classes) }} @if($disabled) tabindex="-1" @endif>
    {{ $slot }}
</button>
