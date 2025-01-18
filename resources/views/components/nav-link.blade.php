@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-main-color'
            : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} style="text-transform: uppercase; font-weight: 600; font-size: 18px;">
    {{ $slot }}
</a>
