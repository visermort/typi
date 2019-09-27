<?php

namespace App\Http\Controllers\Admin;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;

class ReportsController extends BaseAdminController
{
    public function index()
    {
        return view('reports.admin.index');
    }

    public function data()
    {
        $data = [
            'sections' => [
                [
                    'title' => 'Section 1',
                    'description' => 'Description of section1',
                    'items' => [
                        [
                            'title' => 'Item 1',
                            'description' => 'Descripiton of item1',
                            'value' => '34',
                            'measure' => '%'
                        ],
                        [
                            'title' => 'Item 2',
                            'description' => 'Descripiton of item 2',
                            'value' => '99',
                            'measure' => 'sq.m'
                        ],
                    ],
                ],
                [
                    'title' => 'Section 2',
                    'description' => 'Description of section 2',
                    'items' => [
                        [
                            'title' => 'Item 2.1',
                            'description' => 'Descripiton of item 2.1',
                            'value' => 'value 2.1',
                            'measure' => ''
                        ],
                        [
                            'title' => 'Item 2.2',
                            'description' => 'Descripiton of item 2.2',
                            'value' => '45',
                            'measure' => 'm'
                        ],
                    ],
                ]
            ],
        ];

        return response()->json($data);
    }
}