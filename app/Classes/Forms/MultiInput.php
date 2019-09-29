<?php

namespace App\Classes\Forms;

use TranslatableBootForm;

class MultiInput
{
    protected $config;
    protected $attribute;
    protected $value;

    protected static $instance;

    public static function render($attribute, $config, $model)
    {
        self::$instance = new self();
        $self = self::$instance;
        $self->config = $self->getJsonStructure($config);
        $self->config = !empty($self->config) ? $self->config : $self->getPhpStructure($config);
        if (!is_array($self->config)) {
            return 'Config file not found or it\'s not valid - '.$config;
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

    protected function view($template, $params)
    {
        return view('multi-input.admin.'.$template, $params);
    }

}