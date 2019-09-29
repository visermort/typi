@foreach ($rows as $row)
    <tr>
        {!! $row !!}
        <td class="multiinput-elem-remove" title="Remove Item"><i class="fa fa-lg fa-minus-circle"></i></td>
    </tr>
@endforeach
