<?php

namespace App\Classes\Observers;

use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Tags\Models\Tag;

class TaggableObserver
{
    /**
     * @param Base $model
     */
    public function saving(Base $model)
    {
        $model->inputTags = $model->formtags;
        unset($model->formtags);
    }

    /**
     * @param Base $model
     */
    public function saved(Base $model)
    {
        $tags = Tag::whereIn('slug', $model->inputTags)->get();
        $model->tags()->sync($tags->pluck('id'));
    }

}
