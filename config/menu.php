<?php

return [

    'admin-sidebar' => [
        'template' => 'menu.admin.sidebar',
        'sections' => [
            [
                'title' => 'My actions',
                'items' => [
                    [
                        'title' => 'Reports',
                        'url' => '/admin/reports',
                        'icon' => 'fa fa-fw fa-bar-chart',
//                        'subitem' => [
//                            'icon' => 'fa fa-plus',
//                            'url' => '/admin/my-controller/add'
//                        ]
                    ],
//                    [
//                        'title' => 'Action 2',
//                        'url' => '/admin/url2',
//                        'icon' => 'fa fa-fw fa-file'
//                    ],
                ]
            ],
//            [
//                'title' => 'My actions 2',
//                'items' => [
//                    [
//                        'title' => 'Action 2.1',
//                        'url' => '/admin/url',
//                        'icon' => 'fa fa-fw fa-file'
//                    ],
//                    [
//                        'title' => 'Action 2.2',
//                        'url' => '/admin/url2',
//                        'icon' => 'fa fa-fw fa-file'
//                    ],
//                ]
//            ]
        ]
    ]
];