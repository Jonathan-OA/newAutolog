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
    //MODULOS
    Route::get('/production', 'Modules\Production\ProductionController@index');
    Route::get('/recebimento', 'Modules\Receipt\ReceiptController@index');
    Route::get('/production/details/{document}', 'Modules\Production\ProductionController@items');
    Route::resource('documents', 'DocumentsController');

    //BOTÕES
    Route::get('getButtons/{modulo}', 'ButtonsController@getButtons');

    //API
    Route::get('/api/documentsProd', 'Modules\Production\ProductionController@getDocuments');
    Route::get('/api/itemsProd/{document}', 'Modules\Production\ProductionController@getItems');
    Route::post('/api/grid/', 'Modules\Geral\GridController@setColumns');
    Route::get('/api/grid/{module}', 'Modules\Geral\GridController@getColumns');
    Route::get('/api/operations/{module}', 'Modules\Geral\Operation@getOperations');

    //IMPORTAÇÃO
    Route::get('/import', 'ImportacaoGeralController@index');

    //INSTALADOR
    Route::get('/install', 'InstallController@index');
    Route::post('/install/trans', 'InstallController@step1');
});



Route::get('operations/datatable', 'OperationController@getData');
Route::resource('operations', 'OperationController');


Route::get('parameters/datatable', 'ParameterController@getData');
Route::resource('parameters', 'ParameterController');


Route::get('modules/datatable', 'ModuleController@getData');
Route::resource('modules', 'ModuleController');


Route::get('users/datatable', 'UserController@getData');
Route::resource('users', 'UserController');


Route::get('userTypes/datatable', 'UserTypeController@getData');
Route::resource('userTypes', 'UserTypeController');


Route::get('userPermissions/datatable', 'UserPermissionController@getData');
Route::resource('userPermissions', 'UserPermissionController');


Route::get('customers/datatable', 'CustomerController@getData');
Route::resource('customers', 'CustomerController');


Route::get('customers/datatable', 'CustomerController@getData');
Route::resource('customers', 'CustomerController');


Route::get('customers/datatable', 'CustomerController@getData');
Route::resource('customers', 'CustomerController');


Route::get('suppliers/datatable', 'SupplierController@getData');
Route::resource('suppliers', 'SupplierController');


Route::get('packingTypes/datatable', 'PackingTypeController@getData');
Route::resource('packingTypes', 'PackingTypeController');


Route::get('groups/datatable', 'GroupController@getData');
Route::resource('groups', 'GroupController');


Route::get('itemTypes/datatable', 'ItemTypeController@getData');
Route::resource('itemTypes', 'ItemTypeController');


Route::get('items/datatable', 'ItemController@getData');
Route::resource('items', 'ItemController');


Route::get('products/datatable', 'ProductController@getData');
Route::resource('products', 'ProductController');
