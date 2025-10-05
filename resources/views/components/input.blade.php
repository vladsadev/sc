@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-yellow-main
focus:ring-yellow-main rounded-md shadow-2xs']) !!}>
