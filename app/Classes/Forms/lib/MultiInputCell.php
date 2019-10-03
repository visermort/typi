<?php

namespace App\Classes\Forms\lib;

use TranslatableBootForm;
use TypiCMS\Modules\Files\Models\File;
use App\Classes\Forms\MultiInput;

class MultiInputCell
{
    use HasRows;


    protected $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;
    }


    public function element()
    {
        return MultiInput::$admin ? $this->makeElement() : $this->showData();
    }

    protected function makeElement()
    {
        $templates = Multiinput::getTemplates();
        $type = strtolower($this->config['type']);
        $columnName = $this->fullAttributeName ;
        $title = $this->title;
        if ($type == 'text') {
            return TranslatableBootForm::textarea($title, $columnName)->rows(4);
        }
        if ($type == 'dropdown') {
            return TranslatableBootForm::select($title, $columnName, $this->config['items']);
        }
        if ($type == 'date') {
            return TranslatableBootForm::date($title, $columnName);
        }
        if (in_array($type, ['image', 'file'])) {
            $file = null;
            if ($this->value > 0) {
                $file = File::find($this->value);
            }
            return view($templates[$type], ['attribute' => $columnName, 'value' => $file]);
        }
        if ($type == 'multiinput') {
            return $this->view();
        }
        return TranslatableBootForm::text($title, $columnName);
    }

    protected function showData()
    {

    }
}
