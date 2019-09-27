<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('reports', '\App\Http\Controllers\Admin\ReportsController@index');
    Route::get('reports/data', '\App\Http\Controllers\Admin\ReportsController@data');
});
