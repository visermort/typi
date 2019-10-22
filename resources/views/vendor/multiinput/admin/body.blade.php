@foreach ($rows as $row)
    <tr class="multiinput-row">
        @if (!empty($config['sort-enable']))
            <td class="sortable-handle"><i class="fa fa-sort"></i></td>
        @endif
        {!! $row !!}
        @if (empty($config['single-row']) || !empty($config['clone-enable']) )
            <td class="multiinput-elem-actions">
                <i title="{{ __('multiinput::admin.remove-item') }}" class="fa fa-lg fa-minus-circle multiinput-elem-remove"></i>
                @if (!empty($config['clone-enable']))
                    <i title="{{ __('multiinput::admin.clone-item') }}" class="fa fa-lg fa-copy multiinput-elem-clone"></i>
                @endif
            </td>
        @endif
    </tr>
@endforeach
