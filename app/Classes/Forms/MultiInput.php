<?php

namespace App\Classes\Forms;

use TranslatableBootForm;
use Illuminate\Support\Facades\App;
use TypiCMS\Modules\Files\Models\File;

class MultiInput
{
    protected $config;
    protected $attribute;
    protected $value;
    protected $error;
    protected $imageTemplate;

    /**
     * on admin form
     *
     * @param $attribute
     * @param $configName
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function render($attribute, $configName, $model)
    {
        $self = self::getSelf($attribute, $configName, $model);
        if ($self->error) {
            return $self->error;
        }
        return $self->view('main', [
            'title' => $self->title(),
            'body' => $self->body(),
            'data' => $model->$attribute,
            'attribute' => $attribute,
        ]);
    }

    /**
     * in front
     *
     * @param $attribute
     * @param $configName
     * @param $model
     * @param array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public static function publish($attribute, $configName, $model, $options = [])
    {
        $self = self::getSelf($attribute, $configName, $model, true);
        if ($self->error || !$self->value) {
            return '';
        }
        $template = isset($options['template']) ? $options['template'] : 'multi-input.public.main';
        $itemTemplate = isset($options['item-template']) ? $options['item-template'] : 'multi-input.public.item';
        $self->imageTemplate = isset($options['item-image-template']) ? $options['item-image-template'] :
            'multi-input.public.image';
        $items = '';
        foreach ($self->value as $item) {
            $items .= $self->view($itemTemplate, $self->prepareShow($item), false);
        }
        return  $self->view($template, ['items' => $items], false);
    }

    /**
     * create self instance
     *
     * @param $attribute
     * @param $configName
     * @param $model
     * @return MultiInput
     */
    public static function getSelf($attribute, $configName, $model, $valueIsArray = false)
    {
        $self = new self();
        $self->getConfig($configName);
        $self->attribute = $attribute;
        $self->value = $model->$attribute ? json_decode($model->$attribute, $valueIsArray) : false;
        return $self;
    }

    public function getConfig($configName)
    {
        $this->config = Config('multiinput.'.$configName);
        if (!$this->config) {
            $this->error = 'Config not found or not valid - '.$configName;
            return ;
        }
        foreach ($this->config['columns'] as $column) {
            $columns[$column['name']] = $column;
        }
        $this->config['columns'] = $columns;
    }

    /**
     * get translated output with dropdown values replaces and images in fancybox
     *
     * @param $item
     * @return array
     */
    protected function prepareShow($item)
    {
        $out = [];
        $locale = App::getLocale();
        foreach ($item as $key => $column) {
            $columnType = strtolower($this->config['columns'][$key]['type']);
            if ($columnType == 'image') {
                $file = File::find($column);
                if ($file) {
                    $out[$key] = $this->view($this->imageTemplate, ['image' => $file, 'group' => $this->attribute ], false);
                }
            } else {
                if (in_array($locale, array_keys($column))) {
                    $out[$key] = $column[$locale];
                    if ($columnType == 'dropdown' && isset($this->config['columns'][$key]['items'][$out[$key]])) {
                        //field type dropdown - get item value
                        $out[$key] = $this->config['columns'][$key]['items'][$out[$key]];
                    }
                }
            }
        }
        return $out;
    }

    protected function title()
    {
        return __(ucfirst($this->attribute));
    }

    protected function body()
    {
        //dd($this->value);
        $rows = [];
        if (!$this->value || !count($this->value)) {
            $rows[] = $this->addRow();
        } else {
            $index = 0;
            foreach ($this->value as $valueItem) {
                $rows[] = $this->addRow($valueItem, $index++);
            }
        }
        return $this->view('body', ['rows' => $rows]);
    }
    protected function addRow($values = false, $index = 0)
    {
        $out = '';
        foreach ($this->config['columns'] as $column) {
            $columnName = $column['name'];
            $value = $values && property_exists($values, $columnName) ? $values->$columnName : null;
            $out .= $this->view('element', [
                    'element' => $this->makeElement($column, $index, $value),
                ]);
        }
        return $out;
    }
    protected function makeElement($column, $index, $value)
    {
        $type = strtolower($column['type']);
        $columnName =  $this->attribute.'['.$index.']['.$column['name'].']';
        if ($type == 'text') {
            return TranslatableBootForm::textarea($column['title'], $columnName)->rows(4);
        }
        if ($type == 'dropdown') {
            return TranslatableBootForm::select($column['title'], $columnName, $column['items']);
        }
        if ($type == 'date') {
            return TranslatableBootForm::date($column['title'], $columnName);
        }
//        if ($type == 'datetime') {
            //error ((
//            return TranslatableBootForm::dateTimeLocal($column['title'], $columnName);
//        }
        if ($type == 'image') {
            $file = null;
            if ($value > 0) {
                $file = File::find($value);
            }
            return $this->view('image', ['attribute' => $columnName, 'value' => $file]);
        }

        return TranslatableBootForm::text($column['title'], $columnName);
    }

    protected function view($template, $params, $admin = true)
    {
        return view(($admin ? 'multi-input.admin.' : '') . $template, $params);
    }

}