<?php

namespace App\Classes\Forms;

use TranslatableBootForm;
use Illuminate\Support\Facades\App;

class MultiInput
{
    protected $config;
    protected $attribute;
    protected $value;

    public static function render($attribute, $configName, $model)
    {
        $self = new self();
        //$self = self::$instance;
        $self->getConfig($configName);

        if (!is_array($self->config)) {
            return 'Config file not found or it\'s not valid - '.$configName;
        }
        $self->attribute = $attribute;
        $self->value = $model->$attribute ? json_decode($model->$attribute) : false;
        return $self->view('main', [
            'title' => $self->title(),
            'body' => $self->body(),
            'data' => $model->$attribute,
            'attribute' => $attribute,
        ]);
    }
    public static function publish($attribute, $configName, $model, $options = [])
    {
        $self = new self();
        $self->getConfig($configName);
        if (!is_array($self->config)) {
            return 'Config file not found or it\'s not valid - '.$configName;
        }
        $self->attribute = $attribute;
        $items = json_decode($model->$attribute, 1);
        if (!$items) {
            return '';
        }
        $template = isset($options['template']) ? $options['template'] : 'multi-input.public.main';
        $itemTemplate = isset($options['item-template']) ? $options['item-template'] : 'multi-input.public.item';
        $itemsOut = '';
        foreach ($items as $item) {
            $itemsOut .= $self->view($itemTemplate, $self->translate($item), false);
        }
        return  $self->view($template, ['items' => $itemsOut], false);
    }

    public function getConfig($configName)
    {
        $this->config = $this->getJsonStructure($configName);
        $this->config = !empty($this->config) ? $this->config : $this->getPhpStructure($configName);
        $columns = [];
        foreach ($this->config['columns'] as $column) {
            $columns[$column['name']] = $column;
        }
        $this->config['columns'] = $columns;
    }

    protected function translate($item)
    {
        $out = [];
        $locale = App::getLocale();
        foreach ($item as $key => $column) {
            if (in_array($locale, array_keys($column))) {
                $out[$key] = $column[$locale];

                if (strtolower($this->config['columns'][$key]['type']) == 'dropdown' &&
                    isset($this->config['columns'][$key]['items'][$out[$key]])) {
                    //field type dropdown - get item value
                    $out[$key] = $this->config['columns'][$key]['items'][$out[$key]];
                }
            }
        }
        return $out;
    }

    protected function getJsonStructure($config)
    {
        $configFile = __DIR__.'/Configs/'.$config.'.json';
        if (!file_exists($configFile)) {
            return false;
        }
        return json_decode(file_get_contents($configFile), true);
    }

    protected function getPhpStructure($config)
    {
        $configFile = __DIR__.'/Configs/'.$config.'.php';
        if (!file_exists($configFile)) {
            return false;
        }
        return include $configFile;
    }

    protected function title()
    {
        return __(ucfirst($this->attribute));
    }
    protected function body()
    {
        $rows = [];
        if (!$this->value || !count($this->value)) {
            $rows[] = $this->addRow(null);
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
        return TranslatableBootForm::text($column['title'], $columnName);
    }

    protected function view($template, $params, $admin = true)
    {
        return view(($admin ? 'multi-input.admin.' : '')  . $template, $params);
    }

}