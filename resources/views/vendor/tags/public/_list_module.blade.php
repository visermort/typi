{{--common for taggable models--}}
@if ($model->tags)
    <div class="module-tags">
        <h5>Tags</h5>
        <ul class="module-tags-list">
            @foreach ($model->tags as $tag)
                <li>
                    {{ $tag->tag }}
                </li>
            @endforeach
        </ul>
    </div>
@endif