{{--common for taggable models--}}
<div class="form-group">
    <h4>Tags</h4>
    @foreach ($model->enabledTags() as $tag)
        <div class="form-check">
            <input type="checkbox" name="formtags[]" value="{{ $tag->slug }}" id="tags_{{ $tag->id }}" class="form-check-input" @if (in_array($tag->slug, $model->tags->pluck('slug')->toArray())) checked @endif>
            <label for="tags_{{ $tag->id }}" class="form-check-label">{{ $tag->tag }}</label>
        </div>
    @endforeach
</div>