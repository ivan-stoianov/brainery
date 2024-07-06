@props([
    'variant' => null,
])
<span {{ $attributes->class(['badge', "bg-{$variant}"]) }}>
    {{ $slot }}
</span>