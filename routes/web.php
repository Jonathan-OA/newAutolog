<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Auth::routes();

Route::group(['middleware' => 'web'], function() {
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');
    Route::get('/install', 'InstallController@index');
    Route::get('/production', 'Modules\Production\ProductionController@index');
    Route::get('/recebimento', 'Modules\Receipt\ReceiptController@index');
    Route::get('/production/details/{document}', 'Modules\Production\ProductionController@items');
    Route::resource('documents', 'DocumentController');
    Route::get('customers/datatable', 'CustomersController@getData');
    Route::get('roles/datatable', 'RolesController@getData');
    Route::resource('customers', 'CustomerController');
    Route::resource('permissions', 'PermissionController');

    //Botões
    Route::get('getButtons/{modulo}', 'ButtonsController@getButtons');

    //API
    Route::get('/api/documentsProd', 'Modules\Production\ProductionController@getDocuments');
    Route::get('/api/itemsProd/{document}', 'Modules\Production\ProductionController@getItems');
    Route::post('/api/grid/', 'Modules\Geral\GridController@setColumns');
    Route::get('/api/grid/{module}', 'Modules\Geral\GridController@getColumns');

    //IMPORTAÇÃO
    Route::get('/import', 'ImportacaoGeralController@index');
});



Route::resource('permissions', 'PermissionController');

Route::resource('customers', 'CustomersController');

Route::resource('suppliers', 'SuppliersController');

Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');


Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');

Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');

Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');

Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');

Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');

Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');

Route::resource('roles', 'RolesController');
Route::get('roles/datatable', 'RolesController@getData');

Route::resource('customers', 'CustomersController');
Route::get('customers/datatable', 'CustomersController@getData');