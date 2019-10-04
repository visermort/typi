<?php

namespace App\Classes\Forms;

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
            'item' => 'item',
            'file' => 'file',
            'image' => 'image',
        ],
    ];

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
        self::$admin = false;
        self::$templates['public']['directory'] =
            self::$templates['public']['directory'] . $attribute . '.';//default directory  multi-input.public.<attribute>.
        if (!empty($options['templates'])) {
            foreach ($options['templates'] as $key => $value) {
                self::$templates['public'][$key] = $value;
            }
        }
        if (isset($options['title'])) {
            $self->title = $options['title'];
        }
        if (isset($options['class-name'])) {
            $self->className = $options['class-name'];
        }
        return $self->viewPublic();
    }

    public function viewPublic()
    {
        $templates = self::getTemplates();
        $rows = '';
        foreach ($this->rows as $row) {
            $rows .= view($templates['item'], ['row' => $row]);
        }
        return view($templates['main'], [
            'title' => $this->title,
            'rows' => $rows,
            'className' => $this->className,
        ]);
    }

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
}