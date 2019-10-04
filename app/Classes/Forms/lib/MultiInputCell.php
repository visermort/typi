<?php

namespace App\Classes\Forms\lib;

use TranslatableBootForm;
use TypiCMS\Modules\Files\Models\File;
use App\Classes\Forms\MultiInput;
use Illuminate\Support\Facades\App;

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
        return MultiInput::$admin ? $this->render() : $this->publish();
    }

    protected function render()
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

    public function publish()
    {
        if (empty($this->value)) {
            return '';
        }
        $templates = Multiinput::getTemplates();
        $type = strtolower($this->config['type']);
        if ($type == 'image') {
            $file = File::find($this->value);
            if ($file) {
                return view($templates['image'], ['image' => $file, 'group' => $this->attribute ]);
            }
        }
        if ($type == 'file') {
            $file = File::find($this->value);
            if ($file) {
                return view($templates['file'], ['file' => $file]);
            }
        }
        $locale = App::getLocale();
        if (is_object($this->value) && property_exists($this->value, $locale)) {
            $out = $this->value->$locale;
            if ($type == 'dropdown' && isset($this->config['items'][$out])) {
                   //field type dropdown - get item value
                $out = $this->config['items'][$out];
            }
            return $out;
        }
        if ($type == 'multiinput') {
            return $this->rows;
        }
        return !is_object($this->value) ? $this->value : print_r($this->value, 1);
    }

}
