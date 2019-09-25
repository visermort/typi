<?php

namespace App\Http\Controllers\Admin;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;

class ReportsController extends BaseAdminController
{
    public function index()
    {
        return view('reports.admin.index');
    }
}