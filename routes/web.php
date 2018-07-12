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

use App\Models\Product;
use App\Models\Pallet;

Auth::routes();

Route::group(['middleware' => 'web'], function() {
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');
    //MODULOS
    Route::resource('production', 'Modules\ProductionController');
    Route::get('/recebimento', 'Modules\ReceiptController@index');
    Route::get('/production/details/{document}', 'Modules\ProductionController@items');
    //Route::resource('documents', 'DocumentsController');
    Route::get('/document/liberate/{id}', 'DocumentController@liberate');

    //BOTÕES
    Route::get('getButtons/{modulo}', 'ButtonsController@getButtons');

    //API
    Route::get('/api/documents/{moviment}/{qty?}', function($moviment_code, $qty = '500') {
        return App\Models\Document::getDocuments($moviment_code, $qty);
    });
    Route::get('/api/itemsProd/{document}', 'Modules\ProductionController@getItems');
    Route::post('/api/grid/', 'Modules\Geral\GridController@setColumns');
    Route::get('/api/grid/{module}', 'Modules\Geral\GridController@getColumns');
    Route::get('/api/operations/{module}', 'Modules\Geral\Operation@getOperations');

    //IMPORTAÇÃO
    Route::get('/import', 'ImportacaoGeralController@index');

    //INSTALADOR
    Route::get('/install', 'InstallController@index');
    Route::post('/install/trans', 'InstallController@step1');

    //AUTOCOMPLETE
    Route::get('search', 'AppBaseController@autocomplete');
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
Route::resource('partners', 'CustomerController');

Route::get('suppliers/datatable', 'SupplierController@getData');
Route::resource('suppliers', 'SupplierController');

Route::get('packingTypes/datatable', 'PackingTypeController@getData');
Route::resource('packingTypes', 'PackingTypeController');

Route::get('products/datatable', 'ProductController@getData');
Route::get('products/val/{barcode}', function($barcode) {
    return Product::valCBPD($barcode);
});

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
Route::get('pallets/val/{barcode}', function($barcode) {
    return Pallet::valPal($barcode);
});

Route::get('configs/datatable', 'ConfigController@getData');
Route::resource('configs', 'ConfigController');

Route::get('palletItems/datatable/{id}', 'PalletItemController@getData');
Route::resource('palletItems', 'PalletItemController',['except' => 'create']);
Route::get('palletItems/ix/{id}', 'PalletItemController@index');
Route::get('palletItems/create/{id}', 'PalletItemController@create');

Route::get('uoms/datatable', 'UomController@getData');
Route::resource('uoms', 'UomController');

Route::get('uoms/datatable', 'UomController@getData');
Route::resource('uoms', 'UomController');

Route::get('labels/datatable', 'LabelController@getData');
Route::resource('labels', 'LabelController');

Route::get('stocks/datatable', 'StockController@getData');
Route::view('entradaManual', 'stocks.entradaManual');
Route::resource('stocks', 'StockController');

Route::get('finalities/datatable', 'FinalityController@getData');
Route::resource('finalities', 'FinalityController');

Route::get('moviments/datatable', 'MovimentController@getData');
Route::resource('moviments', 'MovimentController');

Route::get('moviments/datatable', 'MovimentController@getData');
Route::resource('moviments', 'MovimentController');

Route::get('moviments/datatable', 'MovimentController@getData');
Route::resource('moviments', 'MovimentController');

Route::get('moviments/datatable', 'MovimentController@getData');
Route::resource('moviments', 'MovimentController');

Route::get('documentTypes/datatable', 'DocumentTypeController@getData');
Route::resource('documentTypes', 'DocumentTypeController');

Route::get('packings/{datatable}', 'PackingController@getData');
Route::resource('packings', 'PackingController');

Route::get('packings/datatable/{code}', 'PackingController@getData');
Route::resource('packings', 'PackinGController',['except' => 'create']);
Route::get('packings/ix/{code}', 'PackingController@index');
Route::get('packings/create/{code}', 'PackingController@create');

Route::get('packingTypes/datatable', 'PackingTypeController@getData');
Route::resource('packingTypes', 'PackingTypeController');


Route::get('labelTypes/datatable', 'LabelTypeController@getData');
Route::resource('labelTypes', 'LabelTypeController');


Route::get('vehicles/datatable', 'VehicleController@getData');
Route::resource('vehicles', 'VehicleController');


Route::get('couriers/datatable', 'CourierController@getData');
Route::resource('couriers', 'CourierController');


Route::get('couriers/datatable', 'CourierController@getData');
Route::resource('couriers', 'CourierController');


Route::get('couriers/datatable', 'CourierController@getData');
Route::resource('couriers', 'CourierController');


Route::get('vehicles/datatable', 'VehicleController@getData');
Route::resource('vehicles', 'VehicleController');


Route::get('volumes/datatable', 'VolumeController@getData');
Route::resource('volumes', 'VolumeController');


Route::get('volumeItems/datatable', 'VolumeItemController@getData');
Route::resource('volumeItems', 'VolumeItemController');


Route::get('volumeStatus/datatable', 'VolumeStatusController@getData');
Route::resource('volumeStatus', 'VolumeStatusController');


Route::get('palletStatus/datatable', 'PalletStatusController@getData');
Route::resource('palletStatus', 'PalletStatusController');


Route::get('allowedTransfers/datatable', 'AllowedTransferController@getData');
Route::resource('allowedTransfers', 'AllowedTransferController');


Route::get('allowedTransfers/datatable', 'AllowedTransferController@getData');
Route::resource('allowedTransfers', 'AllowedTransferController');


Route::get('labelStatus/datatable', 'LabelStatusController@getData');
Route::resource('labelStatus', 'LabelStatusController');


Route::get('blockedProducts/datatable', 'BlockedProductController@getData');
Route::resource('blockedProducts', 'BlockedProductController');


Route::get('blockedGroups/datatable', 'BlockedGroupController@getData');
Route::resource('blockedGroups', 'BlockedGroupController');


Route::get('liberationRules/datatable', 'LiberationRuleController@getData');
Route::resource('liberationRules', 'LiberationRuleController');


Route::get('documentTypeRules/datatable', 'DocumentTypeRuleController@getData');
Route::resource('documentTypeRules', 'DocumentTypeRuleController');


Route::get('liberationItems/datatable', 'LiberationItemController@getData');
Route::resource('liberationItems', 'LiberationItemController');


Route::get('liberationItems/datatable', 'LiberationItemController@getData');
Route::resource('liberationItems', 'LiberationItemController');


Route::get('liberationItems/datatable', 'LiberationItemController@getData');
Route::resource('liberationItems', 'LiberationItemController');


Route::get('blockedLocations/datatable', 'BlockedLocationController@getData');
Route::resource('blockedLocations', 'BlockedLocationController');


Route::get('blockedOperations/datatable', 'BlockedOperationController@getData');
Route::resource('blockedOperations', 'BlockedOperationController');


Route::get('documentStatus/datatable', 'DocumentStatusController@getData');
Route::resource('documentStatus', 'DocumentStatusController');
