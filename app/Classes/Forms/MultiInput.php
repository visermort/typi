<?php

namespace App\Classes\Forms;

use TranslatableBootForm;
use Illuminate\Support\Facades\App;
use TypiCMS\Modules\Files\Models\File;
use App\Classes\Forms\lib\HasRows;

class MultiInput
{
    use HasRows;

    public $errors = [];

    public static $admin = true;
    public static $templates = [
        'admin' => [
            'directory' => 'multi-input.admin.',
            'main' => 'main',
            'body' => 'body',
            'element' => 'element',
            'file' => 'file',
            'image' => 'image',
        ],
        'public' => [
            'directory' => 'multi-input.public.',
            'main' => 'main',
            'body' => 'body',
            'element' => 'element',
            'file' => 'file',
            'image' => 'image',
        ],
    ];


    public static function getTemplates()
    {
        $key = self::$admin ? 'admin' : 'public';
        $templates = self::$templates[$key];
        foreach ($templates as $key => &$template) {
            if ($key != 'directory') {
                $template = $templates['directory'] . $template;
            }
        }
        return  $templates;
    }

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
        $self = self::make($attribute, $configName, $model);
        if (!empty($self->errors)) {
            return implode(', ', $self->errors);
        }
        //dump($self);
        return $self->view();
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
        $self = self::make($attribute, $configName, $model);
        if ($self->errors || !$self->value) {
            return '';
        }
        $template = isset($options['template']) ? $options['template'] : 'multi-input.public.main';
        $itemTemplate = isset($options['item-template']) ? $options['item-template'] : 'multi-input.public.item';
        $self->imageTemplate = isset($options['item-image-template']) ? $options['item-image-template'] :
            'multi-input.public.image';
        $self->fileTemplate = isset($options['item-file-template']) ? $options['item-file-template'] :
            'multi-input.public.file';
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
    public static function make($attribute, $configName, $model)
    {
        $self = new self();
        $config = $self->getConfig($configName);
        if (!$config) {
            return null;
        }
        $self->init(
            __(isset($self->config['title']) ? $self->config['title'] : ucfirst($attribute)), //title
            'multiinput multiinput-' . $attribute, //css className
            $model->$attribute, //data in json
            $model->$attribute ? json_decode($model->$attribute) : false, //values
            $attribute, //attribute
            $attribute, //full attributa
            $config //config
        );
        $self->makeRows($self->config['columns'], $self->value, $self);
        return $self;
    }

    protected function getConfig($configName)
    {
        $config = Config('multiinput.'.$configName);
        if (!$config) {
            $this->errors[] = 'Config not found or not valid - '.$configName;
            return ;
        }
        $config['columns']= $this->writeColumnKeys($config['columns']);
        return $config;
    }

    protected function writeColumnKeys($columns)
    {
        $out = [];
        foreach ($columns as $column) {
            if (isset($column['columns'])) {
                $column['columns'] = $this->writeColumnKeys($column['columns']);
            }
            $out[$column['name']] = $column;
        }
        return $out;
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
            } else if ($columnType == 'file') {
                $file = File::find($column);
                if ($file) {
                    $out[$key] = $this->view($this->fileTemplate, ['file' => $file], false);
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

}