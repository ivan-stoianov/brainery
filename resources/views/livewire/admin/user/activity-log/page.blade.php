<div>
    @if ($items->count())
        <x-admin.table>
            <x-slot name="head">
                <x-admin.table.heading>
                    {{ __('Date') }}
                </x-admin.table.heading>
                <x-admin.table.heading>
                    {{ __('Action') }}
                </x-admin.table.heading>
            </x-slot>

            @foreach ($items as $item)
                <x-admin.table.row>
                    <x-admin.table.column>
                        {{ $item->created_at->toDateTimeHuman() }}
                    </x-admin.table.column>
                    <x-admin.table.column>
                        {{ $item->description }}
                    </x-admin.table.column>
                </x-admin.table.row>
            @endforeach
        </x-admin.table>
    @endif

    {{ $items->render() }}
</div>
