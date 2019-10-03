<?php

namespace App\Classes\Forms\lib;
use App\Classes\Forms\Multiinput;

trait HasRows
{
    public $rows = [];
    public $className;
    public $title;
    public $data;
    public $value;
    public $attribute;
    public $fullAttributeName;
    public $config;

    public function init($title, $className, $data, $value, $attribute, $fullAttributeName, $config)
    {
        $this->title = $title;
        $this->className = $className;
        $this->data = $data;
        $this->value = $value;
        $this->attribute = $attribute;
        $this->fullAttributeName = $fullAttributeName;
        $this->config = $config;
    }

    public function makeRows($columnsConfig, $values, $parent)
    {
        if (!$values || !count($values)) {
            $this->rows[] = new MultiInputRow($parent, $columnsConfig, 0, null);
        } else {
            $index = 0;
            foreach ($values as $value) {
                $this->rows[] = new MultiInputRow($parent, $columnsConfig, $index++, $value);
                if (!empty($parent->config['single_row'])) {
                    break;
                }
            }
        }
    }

    public function view()
    {
        $templates = Multiinput::getTemplates();
        $rows = [];
        foreach ($this->rows as $row) {
            $rows[] = $row->view();
        }
        $body = view($templates['body'], ['rows' => $rows]);
        return view($templates['main'], [
            'title' => $this->title,
            'body' => $body,
            'className' => $this->className,
            'attribute' => $this->fullAttributeName,
        ]);
    }

}