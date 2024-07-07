<div>
    @if ($items->count())
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-nowrap">
                                {{ $item->created_at->toDateTimeHuman() }}
                            </td>
                            <td class="text-nowrap">
                                {{ $item->description }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{ $items->render() }}
</div>
