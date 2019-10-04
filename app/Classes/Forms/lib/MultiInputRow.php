<?php

namespace App\Classes\Forms\lib;

use App\Classes\Forms\MultiInput;

class MultiInputRow
{
    public $fullAttributeName;
    public $columns;
    protected $config;
    protected $parent;
    protected $value;
    protected $index;

    public function __construct($parent, $config, $index, $value)
    {
        $this->parent = $parent;
        $this->config = $config;
        $this->value = $value;
        $this->index = $index;
        $this->fullAttributeName = $parent->fullAttributeName.'['.$index.']';
        foreach ($config as $key => $column) {
            $columnValue = $value && property_exists($value, $key) ? $value->$key : null;
            $cell = new MultiInputCell($this);
            $cell->init(
                $column['title'], //tile
                $parent->className.'-'.$column['name'], //css className
                json_encode($columnValue), //data in json
                $columnValue, //values
                $column['name'], //attribute
                $parent->fullAttributeName.'['.$index.']['.$column['name'].']', //full attribute
                $column //config
            );
            if (!empty($column['columns'])) {
                $cell->makeRows($column['columns'], $columnValue, $cell);
            }

            $this->columns[] = $cell;
            $property = $column['name'];
            $this->{$property} = $cell;//as property
        }
    }

    public function render()
    {
        $templates = Multiinput::getTemplates();
        $out = '';
        foreach ($this->columns as $cell) {
            $out .= view($templates['element'], [
                'element' => $cell->element(),
                'value' => $cell->data,
                'attribute' => $cell->fullAttributeName,
            ]);
        }
        return $out;
    }
}