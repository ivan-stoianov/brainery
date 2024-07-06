@props([
    'href' => '#',
])
<a {{ $attributes->class(['btn', 'btn-primary'])->merge(['href' => $href]) }}>
    <i class="fa-solid fa-circle-plus me-1"></i>
    @if ($slot->isEmpty())
        {{ __('Add new') }}
    @else
        {{ $slot }}
    @endif
</a>