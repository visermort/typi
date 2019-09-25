<?php

namespace App\Classes\Menu;

/**
 * Class Menu
 * @package App\Classes\Menu
 */
class Menu
{

    /**
     * @param $config
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public static function render($config)
    {
        $config = Config('menu.'.$config);
        if (!$config) {
            return '';
        }
        return view($config['template'], ['sections' => $config['sections'], 'currentUrl' => request()->path()]);
    }
}