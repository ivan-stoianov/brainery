<div class="table-responsive">
    <table {{ $attributes->class(['table', 'table-hover', 'align-middle']) }}>
        @isset($head)
            <thead>
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endisset

        <tbody class="table-group-divider">
            {{ $slot }}
        </tbody>
    </table>
</div>