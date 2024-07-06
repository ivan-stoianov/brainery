@props([
    'sortable' => false,
    'direction' => null,
])
<th {{ $attributes->class(['text-nowrap']) }}>
    @if ($sortable)
        <div class="d-inline cursor-pointer">
            {{ $slot }}
            <div class="ms-1 d-inline">
                @if ($direction !== null)
                    @if ($direction === 'asc')
                        <i class="fa-solid fa-sort-up"></i>
                    @endif
                    @if ($direction === 'desc')
                        <i class="fa-solid fa-sort-down"></i>
                    @endif
                @else
                    <i class="fa-solid fa-sort"></i>
                @endif
            </div>
        </div>
    @else
        {{ $slot }}
    @endif
</th>
