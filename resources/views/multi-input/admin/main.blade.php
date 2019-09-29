<div class="multiinput" data-value='{{ $data }}' data-attribute="{{ $attribute }}">
    <div class="multiinput-header">
        <label>{{ $title }}</label>
        <span class="multiinput-elem-add" title="Add Item"><i class="fa fa-lg fa-plus-circle"></i></span>
    </div>
    <table class="multiinput-body">
        <tbody>
            {!! $body !!}
        </tbody>
    </table>
</div>
