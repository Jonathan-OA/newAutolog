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
Route::get('users/updTime', 'UserController@updTime');
Route::resource('users', 'UserController');


Route::get('userTypes/datatable', 'UserTypeController@getData');
Route::resource('userTypes', 'UserTypeController');


Route::get('userPermissions/datatable', 'UserPermissionController@getData');
Route::resource('userPermissions', 'UserPermissionController');


Route::get('customers/datatable', 'CustomerController@getData');
Route::resource('customers', 'CustomerController');


Route::get('suppliers/datatable', 'SupplierController@getData');
Route::resource('suppliers', 'SupplierController');


Route::get('packingTypes/datatable', 'PackingTypeController@getData');
Route::resource('packingTypes', 'PackingTypeController');


Route::get('products/datatable', 'ProductController@getData');
Route::resource('products', 'ProductController');


Route::get('productTypes/datatable', 'ProductTypeController@getData');
Route::resource('productTypes', 'ProductTypeController');


Route::get('groups/datatable', 'GroupController@getData');
Route::resource('groups', 'GroupController');


Route::get('locationFunctions/datatable', 'LocationFunctionController@getData');
Route::resource('locationFunctions', 'LocationFunctionController');


Route::get('locationTypes/datatable', 'LocationTypeController@getData');
Route::resource('locationTypes', 'LocationTypeController');


Route::get('depositTypes/datatable', 'DepositTypeController@getData');
Route::resource('depositTypes', 'DepositTypeController');


Route::get('departments/datatable', 'DepartmentController@getData');
Route::resource('departments', 'DepartmentController');


Route::get('deposits/datatable', 'DepositController@getData');
Route::resource('deposits', 'DepositController');


Route::get('sectors/datatable', 'SectorController@getData');
Route::resource('sectors', 'SectorController');


Route::get('locations/datatable', 'LocationController@getData');
Route::resource('locations', 'LocationController');


Route::get('stockTypes/datatable', 'StockTypeController@getData');
Route::resource('stockTypes', 'StockTypeController');


Route::get('companies/datatable', 'CompanyController@getData');
Route::resource('companies', 'CompanyController');


Route::get('pallets/datatable', 'PalletController@getData');
Route::resource('pallets', 'PalletController');


Route::get('configs/datatable', 'ConfigController@getData');
Route::resource('configs', 'ConfigController');


Route::get('palletItems/datatable/{id}', 'PalletItemController@getData');
Route::resource('palletItems', 'PalletItemController');
Route::get('palletItems/ix/{id}', 'PalletItemController@index');
