<?php

namespace TypiCMS\Modules\Projects\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'category_id' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'website' => 'nullable|url|max:255',
            'image_id' => 'nullable|integer',
            'title.*' => 'required|max:255',
            'slug.*' => 'required|alpha_dash|max:255',
        ];
    }
}
