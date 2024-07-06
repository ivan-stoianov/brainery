<div>
    <div class="row mb-3 gx-2">
        <div class="col-auto">
            {{ html()->search('search')->attribute('wire:model.live.debounce.250ms', 'search')->placeholder(__('Search')) }}
        </div>
        <div class="col-auto">
            {{ html()->select('per_page', $perPageOptions)->attribute('wire:model.lazy', 'per_page') }}
        </div>
    </div>
    @if ($members->count())
        <x-admin.table>
            <x-slot name="head">
                <x-admin.table.heading sortable wire:click="sortBy('name')" :direction="$this->getColumnSortDirection('name')">
                    {{ __('Name') }}
                </x-admin.table.heading>
                <x-admin.table.heading sortable wire:click="sortBy('email')" :direction="$this->getColumnSortDirection('email')">
                    {{ __('Email') }}
                </x-admin.table.heading>
                <x-admin.table.heading sortable wire:click="sortBy('status')" :direction="$this->getColumnSortDirection('status')">
                    {{ __('Status') }}
                </x-admin.table.heading>
                <x-admin.table.heading sortable wire:click="sortBy('created_at')" :direction="$this->getColumnSortDirection('created_at')">
                    {{ __('Register date') }}
                </x-admin.table.heading>
            </x-slot>

            @foreach ($members as $member)
                <x-admin.table.row>
                    <x-admin.table.column>
                        <a href="{{ route('admin.member.show', $member) }}"
                            class="text-decoration-none fw-bold text-dark">
                            {{ $member->getName() }}
                        </a>
                    </x-admin.table.column>
                    <x-admin.table.column>
                        {{ $member->getEmail() }}
                    </x-admin.table.column>
                    <x-admin.table.column>
                        @if ($member->isActive())
                            <x-bs.badge variant="success">{{ __('Active') }}</x-bs.badge>
                        @else
                            <x-bs.badge variant="secondary">{{ __('Inactive') }}</x-bs.badge>
                        @endif
                    </x-admin.table.column>
                    <x-admin.table.column>
                        {{ $member->getCreatedAt()->toDateHuman() }}
                    </x-admin.table.column>
                </x-admin.table.row>
            @endforeach
        </x-admin.table>
    @endif

    {{ $members->render() }}
</div>
