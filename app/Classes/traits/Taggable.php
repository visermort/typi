<?php

namespace App\Classes\Traits;

use TypiCMS\Modules\Tags\Models\Tag;

trait Taggable
{
    public $inputTags;

    /**
     * @return mixed
     */
    public function enabledTags()
    {
        return Tag::all();
    }
}
