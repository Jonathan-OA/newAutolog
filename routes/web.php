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
use App\Models\PalletItem;

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');
    // ----------------------------------------------------------------------------------------------
    // Modulo de Produção
    // ----------------------------------------------------------------------------------------------
    Route::get('production/{document_id}/items', 'Modules\ProductionController@showItems'); //Mostra grid de itens
    Route::get('production/{document_id}/items/create', 'Modules\ProductionController@createItem'); //Form de criação de itens
    Route::get('production/{document_id}/items/{document_item_id}/edit', 'Modules\ProductionController@editItem'); //Form de edição de itens
    Route::patch('production/updateItem/{document_item_id}', 'Modules\ProductionController@updateItem')->name('production.updateItem');; //Atualiza item
    Route::post('production/storeItem', 'Modules\ProductionController@storeItem')->name('production.storeItem');; //Cria item
    Route::resource('production', 'Modules\ProductionController'); //Ações de documentos de produção
    // ----------------------------------------------------------------------------------------------
    // Modulo de Transferência
    // ----------------------------------------------------------------------------------------------
    Route::get('transfer/{document_id}/items', 'Modules\TransferController@showItems'); //Mostra grid de itens
    Route::get('transfer/{document_id}/items/create', 'Modules\TransferController@createItem'); //Form de criação de itens
    Route::get('transfer/{document_id}/items/{document_item_id}/edit', 'Modules\TransferController@editItem'); //Form de edição de itens
    Route::patch('transfer/updateItem/{document_item_id}', 'Modules\TransferController@updateItem')->name('production.updateItem');; //Atualiza item
    Route::post('transfer/storeItem', 'Modules\TransferController@storeItem')->name('transfer.storeItem');; //Cria item
    Route::resource('transfer', 'Modules\TransferController'); //Ações de documentos de transferencia
    Route::get('stockTransfer', 'Modules\TransferController@stockTransfer'); //Tela de Transferência Manual
    Route::post('stockTransfer/store', 'Modules\TransferController@storeStockTransfer')->name('transfer.storeStockTransfer');; //Cria Doc. de Transferencia Manual
    
    
    // ----------------------------------------------------------------------------------------------


    //Rota que libera um documento
    Route::get('/document/liberate/{id}/{module?}', 'DocumentController@liberateDoc');
    //Rota que retorna um documento
    Route::get('/document/return/{id}/{module?}', 'DocumentController@returnDoc');

    //BOTÕES
    Route::get('getButtons/{modulo}', 'ButtonsController@getButtons');

    //API
    Route::get('/api/documents/{moviment}/{qty?}', function($moviment_code, $qty = '15000') {
        return App\Models\Document::getDocuments($moviment_code, $qty);
    });
    Route::get('/api/documentItems/{doc_id}/{statusDsc?}', function($document_id, $stsDsc = '') {
        return App\Models\DocumentItem::getItens($document_id, $stsDsc);
    });
    Route::get('/api/itemsProd/{document}', 'Modules\ProductionController@getItems');
    Route::post('/api/grid/', 'Modules\Geral\GridController@setColumns');
    Route::get('/api/grid/{module}', 'Modules\Geral\GridController@getColumns');
    Route::get('/api/operations/{module}', 'Modules\Geral\Operation@getOperations');

    //Retorna informações de um gráfico cadastrado
    Route::get('/api/graphs/{id}', 'GraphController@getDataGraph');

    //IMPORTAÇÃO
    Route::get('/import', 'ImportacaoGeralController@index');

    //INSTALADOR
    Route::get('/install', 'InstallController@index');
    Route::post('/install/trans', 'InstallController@step1');

    //AUTOCOMPLETE
    Route::get('search', 'AppBaseController@autocomplete');

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

    Route::get('userPermissions/{user_type}/show', 'UserPermissionController@getPermissions');
    Route::get('userPermissions/{user_type}', 'UserPermissionController@index');
    Route::resource('userPermissions', 'UserPermissionController');
    
    Route::get('userPermissions/{user_type}/create', 'UserPermissionController@create');


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
        return Pallet::valPallet($barcode);
    });
    Route::get('pallets/items/{pallet_id}', function($pallet_id) {
        return PalletItem::getItems($pallet_id);
    });

    Route::post('stocks/verify', function($pallet_id, $location_code, $label_id, $produto) {
        return Stock::verStock($pallet_id, $location_code, $label_id, $produto);
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
    Route::get('entradaManual', 'StockController@create');
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
    Route::resource('packings', 'PackingController',['except' => 'create']);
    Route::get('packings/ix/{code}', 'PackingController@index');
    Route::get('packings/create/{code}', 'PackingController@create');

    Route::get('activities/datatable/{task_id}', 'ActivityController@getData');
    Route::resource('activities', 'ActivityController',['except' => 'create']);
    Route::get('activities/ix/{task_id}', 'ActivityController@index');
    Route::get('activities/create/{task_id}', 'ActivityController@create');


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


    Route::get('documentTypes/datatable', 'DocumentTypeController@getData');
    Route::resource('documentTypes', 'DocumentTypeController');


    Route::get('documentItems/datatable', 'DocumentItemController@getData');
    Route::resource('documentItems', 'DocumentItemController');


    Route::get('logs/datatable', 'LogController@getData');
    Route::resource('logs', 'LogController');


    Route::get('graphs/datatable', 'GraphController@getData');
    Route::resource('graphs', 'GraphController');


    Route::get('graphs/datatable', 'GraphController@getData');
    Route::resource('graphs', 'GraphController');


    Route::get('grids/datatable', 'GridController@getData');
    Route::resource('grids', 'GridController');


    Route::get('supports/datatable', 'SupportController@getData');
    Route::resource('supports', 'SupportController');

    Route::get('notification/{user_code}', function($user_code) {
        return App\Models\Notification::getLastNotification($user_code);
    });

    Route::get('tasks/datatable', 'TaskController@getData');
    Route::resource('tasks', 'TaskController');


    Route::get('taskStatus/datatable', 'TaskStatusController@getData');
    Route::resource('taskStatus', 'TaskStatusController');
});











