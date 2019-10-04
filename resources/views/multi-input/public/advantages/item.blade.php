<div class="multiinput-item">
    <div class="multiimput-item-title">{{ $row->title->publish() }}</div>
    <div class="multiimput-item-description">{{ $row->description->publish() }}</div>
    <div class="multiimput-item-status">{{ $row->status->publish() }}</div>
    <div class="multiimput-item-date">{{ $row->start_date->publish() }}</div>
    <div class="multiimput-item-image">{!! $row->advantage_image->publish() !!}</div>
    <div class="multiimput-item-file">{!! $row->document->publish() !!}</div>
    @if ($row->features)
        <div class="multiimput-item-features">
            <h5>Features</h5>
            @foreach ($row->features->rows as $feature)
                <div class="multiimput-item-features-item multiimput-item-features-item-title">
                    {{ $feature->feature_title->publish() }}
                </div>
                <div class="multiimput-item-features-item multiimput-item-features-item-image">
                    {{ $feature->feature_image->publish() }}
                </div>
            @endforeach
        </div>
    @endif
</div>
