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
use Illuminate\Support\Facades\Storage;

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');
    // ----------------------------------------------------------------------------------------------
    // Modulo de Produção
    // ----------------------------------------------------------------------------------------------
    Route::get('production/{document_id}/print', 'Modules\ProductionController@showPrint'); //Mostra grid de impressão de etiquetas
    Route::get('production/{document_id}/liberate', 'Modules\ProductionController@showLibLocation'); //Mostra Tela de Endereço para Liberação
    Route::post('production/{document_id}/liberate', 'Modules\ProductionController@storeLibLocation'); //Salva Endereço para Liberação e chama regras de liberação
    Route::post('production/print', 'Modules\ProductionController@print')->name('production.print'); //Cria Etiquetas e retorna o arquivo de impressão com as variaveis preenchidas
    Route::post('production/printDoc', 'Modules\ProductionController@printDoc')->name('production.printDoc'); //Retorna o arquivo de impressão de documento
    Route::get('production/{document_id}/items', 'Modules\ProductionController@showItems'); //Mostra grid de itens
    Route::get('production/{document_id}/items/create', 'Modules\ProductionController@createItem'); //Form de criação de itens
    Route::get('production/{document_id}/items/{document_item_id}/edit', 'Modules\ProductionController@editItem'); //Form de edição de itens
    Route::patch('production/updateItem/{document_item_id}', 'Modules\ProductionController@updateItem')->name('production.updateItem');; //Atualiza item
    Route::post('production/storeItem', 'Modules\ProductionController@storeItem')->name('production.storeItem');; //Cria item
    Route::resource('production', 'Modules\ProductionController'); //Ações de documentos de produção
    // ----------------------------------------------------------------------------------------------
    // Modulo de Separação
    // ----------------------------------------------------------------------------------------------
    Route::get('separation/{document_id}/print', 'Modules\SeparationController@showPrint'); //Mostra grid de impressão de etiquetas
    Route::get('separation/{document_id}/liberate', 'Modules\SeparationController@showLibLocation'); //Mostra Tela de Endereço para Liberação
    Route::post('separation/print', 'Modules\SeparationController@print')->name('separation.print'); //Cria Etiquetas e retorna o arquivo de impressão com as variaveis preenchidas
    Route::post('separation/printDoc', 'Modules\SeparationController@printDoc')->name('separation.printDoc'); //Retorna o arquivo de impressão de documento
    Route::get('separation/{document_id}/items', 'Modules\SeparationController@showItems'); //Mostra grid de itens
    Route::get('separation/{document_id}/items/create', 'Modules\SeparationController@createItem'); //Form de criação de itens
    Route::get('separation/{document_id}/items/{document_item_id}/edit', 'Modules\SeparationController@editItem'); //Form de edição de itens
    Route::patch('separation/updateItem/{document_item_id}', 'Modules\SeparationController@updateItem')->name('separation.updateItem');; //Atualiza item
    Route::post('separation/storeItem', 'Modules\SeparationController@storeItem')->name('production.storeItem');; //Cria item
    Route::resource('separation', 'Modules\SeparationController'); //Ações de documentos de separação
    
    // ----------------------------------------------------------------------------------------------
    // Modulo de Recebimento
    // ----------------------------------------------------------------------------------------------
    Route::get('receipt/{document_id}/print', 'Modules\ReceiptController@showPrint'); //Mostra grid de impressão
    Route::post('receipt/print', 'Modules\ReceiptController@print')->name('receipt.print'); //Cria Etiquetas e envia para impressão
    Route::get('receipt/{document_id}/items', 'Modules\ReceiptController@showItems'); //Mostra grid de itens
    Route::get('receipt/{document_id}/items/create', 'Modules\ReceiptController@createItem'); //Form de criação de itens
    Route::get('receipt/{document_id}/items/{document_item_id}/edit', 'Modules\ReceiptController@editItem'); //Form de edição de itens
    Route::patch('receipt/updateItem/{document_item_id}', 'Modules\ReceiptController@updateItem')->name('receipt.updateItem'); //Atualiza item
    Route::post('receipt/storeItem', 'Modules\ReceiptController@storeItem')->name('receipt.storeItem'); //Cria item
    Route::get('receipt/importXml', 'Modules\ReceiptController@showImportXml'); //Mostra Tela de Importação XML
    Route::post('receipt/importXml', 'Modules\ReceiptController@importXml'); //Importa XML e cria documento
    Route::resource('receipt', 'Modules\ReceiptController'); //Ações de documentos de Recebimento

    
    // ----------------------------------------------------------------------------------------------
    // Modulo de Transferência
    // ----------------------------------------------------------------------------------------------
    Route::get('transfer/{document_id}/items', 'Modules\TransferController@showItems'); //Mostra grid de itens
    Route::get('transfer/{document_id}/items/create', 'Modules\TransferController@createItem'); //Form de criação de itens
    Route::get('transfer/{document_id}/items/{document_item_id}/edit', 'Modules\TransferController@editItem'); //Form de edição de itens
    Route::patch('transfer/updateItem/{document_item_id}', 'Modules\TransferController@updateItem')->name('transfer.updateItem');; //Atualiza item
    Route::post('transfer/storeItem', 'Modules\TransferController@storeItem')->name('transfer.storeItem');; //Cria item
    Route::resource('transfer', 'Modules\TransferController'); //Ações de documentos de transferencia
    Route::get('stockTransfer', 'Modules\TransferController@stockTransfer'); //Tela de Transferência Manual
    Route::post('stockTransfer/store', 'Modules\TransferController@storeStockTransfer')->name('transfer.storeStockTransfer');; //Cria Doc. de Transferencia Manual
    // ----------------------------------------------------------------------------------------------
    // Modulo de Inventário
    // ----------------------------------------------------------------------------------------------
    Route::get('inventory/importFile', 'Modules\InventoryController@showImportFile')->name('inventory.importFile'); //Mostra Tela de Importação Excel
    Route::get('inventory/reimportFile/{document_id}', 'Modules\InventoryController@showReimportFile')->name('inventory.reimportFile'); //Mostra Tela de Reimportação Excel
    Route::post('inventory/confirmImportFile', 'Modules\InventoryController@confirmImportFile'); //Confirma a ordem dos campos para importação
    Route::post('inventory/importFile', 'Modules\InventoryController@importFile'); //Importa Excel e Cria IVD com os itens
    Route::post('inventory/reimportFile', 'Modules\InventoryController@reimportFile'); //Atualiza o arquivo de itens do inventário em execução
    Route::get('inventory/{document_id}/exportFile', 'Modules\InventoryController@showExportFile'); //Mostra Tela de Exportação Excel / Txt
    Route::post('inventory/{document_id}/exportFile', 'Modules\InventoryController@exportFile'); //Exporta contagens
    Route::get('inventory/{document_id}/items', 'Modules\InventoryController@showItems'); //Mostra grid de itens
    Route::match(['GET', 'POST'],'inventory/{document_id}/selectItems', 'Modules\InventoryController@selectItems'); //Form de seleção de itens para o inventário
    Route::match(['GET', 'POST'],'inventory/{document_id}/selectItemsCount/{invCount}', 'Modules\InventoryController@selectItemsNextCount'); //Form de seleção de itens para segunda / terceira contagem
    Route::post('inventory/{document_id}/updateItemsNextCount', 'Modules\InventoryController@updateItemsNextCount'); //Atualiza os itens para próxima contagem
    Route::post('inventory/{document_id}/detItemsNextCount', 'Modules\InventoryController@detItemsNextCount'); //Detalhes dos itens para finalizar contagem
    Route::get('inventory/{document_id}/items/{document_item_id}/edit', 'Modules\InventoryController@editItem'); //Form de edição de itens
    Route::patch('inventory/updateItem/{document_item_id}', 'Modules\InventoryController@updateItem')->name('inventory.updateItem');; //Atualiza item
    Route::post('inventory/{document_id}/auditLocation', 'Modules\InventoryController@auditLocation')->name('inventory.auditLocation');; //Cria item
    Route::post('inventory/{document_id}/storeItem', 'Modules\InventoryController@storeItem')->name('inventory.storeItem'); //Cria item
    Route::resource('inventory', 'Modules\InventoryController'); //Ações de documentos de inventário
    Route::get('/inventory/{id}/liberate/{cont?}', 'Modules\InventoryController@liberate'); //Libera Contagem
    Route::get('/inventory/{id}/finalize', 'Modules\InventoryController@finalize'); //Finaliza Contagem
    Route::get('/inventory/{id}/return', 'Modules\InventoryController@return'); //Retorna Inventário
    Route::get('/inventory/{id}/returnLocation/{location_code}', 'Modules\InventoryController@returnLocation'); //Retorna Um Endereço Especifico
    Route::get('/inventory/{id}/audit/{location_code}', 'Modules\InventoryController@audit'); //Tela de Auditoria
    // ----------------------------------------------------------------------------------------------
    //Rota que libera documento(s)
    //Route::get('/document/liberate/{id}/{module?}', 'DocumentController@liberate');
    Route::post('/document/liberate/{module}', 'DocumentController@liberate');
    //Rota que retorna documento(s)
    Route::post('/document/return/{module?}', 'DocumentController@return');
    //Rota que cancela documento(s)
    Route::post('/document/cancel/{module?}', 'DocumentController@cancel');

    //Lista impressoras disponiveis com base no servidor de impressão
    Route::get('printConfig', 'PrintConfigController@index');

    //BOTÕES
    Route::get('getButtons/{modulo}', 'ButtonsController@getButtons');

    //Baixa um arquivo do storage public
    Route::get('/download/{file}', function($file){
        return Storage::disk('public')->download($file);
    });

    //API
    Route::get('/api/documents/{moviment}/{qty?}', function($moviment_code, $qty = '15000') {
        return App\Models\Document::getDocuments($moviment_code, $qty);
    });
    Route::get('/api/documentItems/{doc_id}/{statusDsc?}', function($document_id, $stsDsc = '') {
        return App\Models\DocumentItem::getItens($document_id, $stsDsc);
    });
    Route::get('/api/inventoryItems/{document_id}/{summarize}', function($document_id, $summarize) {
        return App\Models\InventoryItem::getAppointments($document_id, 1, $summarize);
    });
    Route::get('/api/inventoryItems/{doc_id}/{statusDsc?}', function($document_id, $stsDsc = '') {
        return App\Models\InventoryItem::getItens($document_id, $stsDsc);
    });
    Route::get('/api/inventoryItems/audit/{doc_id}/{location_code}', function($document_id, $location_code) {
        return App\Models\Activity::getItensAudit($document_id, $location_code);
    });
    Route::get('/api/itemsProd/{document}', 'Modules\ProductionController@getItems');
    Route::post('/api/grid/', 'GridController@setColumns');
    Route::get('/api/grid/{module}', 'GridController@getColumns');
    Route::get('/api/operations/{module}', 'Modules\Geral\Operation@getOperations');

    //Retorna informações de um gráfico cadastrado
    Route::get('/api/graphs/{id}', 'GraphController@getDataGraph');

    //IMPORTAÇÃO
    Route::get('/import', 'ImportacaoGeralController@index');

    //INSTALADOR
    Route::get('/install', 'InstallController@index');
    Route::post('/install/trans', 'InstallController@step1');

    //AUTOCOMPLETE
    Route::get('/search', 'AppBaseController@autoComplete');

    //CEP
    Route::get('/cep/{cep}', 'AppBaseController@getInfosByCep');


    Route::get('operations/datatable', 'OperationController@getData');
    Route::resource('operations', 'OperationController');

    Route::get('parameters/datatable', 'ParameterController@getData');
    Route::resource('parameters', 'ParameterController');

    Route::get('modules/datatable', 'ModuleController@getData');
    Route::resource('modules', 'ModuleController');

    Route::get('users/datatable', 'UserController@getData');
    Route::get('users/updTime', 'UserController@updTime');
    Route::get('users/online', 'UserController@usersOnline');
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

    Route::get('products/datatable/{qty?}', 'ProductController@getData');
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
    Route::get('labels/{id}/traceability', 'LabelController@traceability');
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
    //Route::resource('packings', 'PackingController');

    Route::get('packings/datatable/{code}', 'PackingController@getData');
    Route::resource('packings', 'PackingController',['except' => 'create']);
    Route::get('packings/ix/{code}', 'PackingController@index');
    Route::get('packings/create/{code}', 'PackingController@create');
    Route::get('packings/{product}/{uom}', 'PackingController@getLevel'); //Traz infos da unidade

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


    Route::get('liberationRules/datatable/{moviment}', 'LiberationRuleController@getData');
    Route::resource('liberationRules', 'LiberationRuleController',['except' => 'create']);
    Route::get('liberationRules/idx/{moviment}', 'LiberationRuleController@index');
    Route::get('liberationRules/create/{moviment}', 'LiberationRuleController@create');
    Route::get('liberationRules/{moviment}/{document_type}', function($moviment, $doc_type) {
        return App\Models\LiberationRule::getLiberationRules($moviment, $doc_type);
    });

    Route::get('documentTypeRules/datatable/{document_type}', 'DocumentTypeRuleController@getData');
    Route::get('documentTypeRules/{document_type}', 'DocumentTypeRuleController@index');
    Route::post('documentTypeRules/{document_type}', 'DocumentTypeRuleController@store');
    Route::delete('documentTypeRules/{document_type}', 'DocumentTypeRuleController@destroy');

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
    Route::get('logs/{operation?}', 'LogController@index');
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

    Route::get('inventoryItems/datatable', 'InventoryItemController@getData');
    Route::resource('inventoryItems', 'InventoryItemController');


    //Relatórios
    Route::get('admin/reportBranchs', 'AdminController@reportBranch');
    Route::get('admin/reportBranchs/datatable/{summarize}/{from?}/{to?}', 'AdminController@reportBranchDatatable');
    Route::get('admin/reportBranchsDet/{branch}', 'AdminController@reportBranchDet');
    Route::get('admin/reportBranchsDet/datatable/{branch}/{from?}/{to?}', 'AdminController@reportBranchDetDatatable');
    Route::get('inventoryItems/{document_id}/report', 'InventoryItemController@reportInv');
    Route::get('inventoryItems/{document_id}/datatable/{summarize}', 'InventoryItemController@reportDatatable');
    Route::get('inventoryItems/{document_id}/reportPDF/{summarize}', 'InventoryItemController@reportInv');

    Route::get('activityStatus/datatable', 'ActivityStatusController@getData');
    Route::resource('activityStatus', 'ActivityStatusController');


    Route::get('inventoryStatus/datatable', 'InventoryStatusController@getData');
    Route::resource('inventoryStatus', 'InventoryStatusController');


    Route::get('liberationStatus/datatable', 'LiberationStatusController@getData');
    Route::resource('liberationStatus', 'LiberationStatusController');

    Route::get('printerTypes/datatable', 'PrinterTypeController@getData');
    Route::resource('printerTypes', 'PrinterTypeController');

    Route::get('printerTypes/datatable', 'PrinterTypeController@getData');
    Route::resource('printerTypes', 'PrinterTypeController');

    Route::get('labelLayouts/datatable', 'LabelLayoutController@getData');
    Route::get('labelLayouts/{label_type}/printers', 'LabelLayoutController@getPrinters');
    Route::get('labelLayouts/{label_type}/{printer_type}/commands', 'LabelLayoutController@getCommands');
    Route::resource('labelLayouts', 'LabelLayoutController');

    Route::get('print', 'LabelLayoutController@index');



});



Route::get('labelVariables/datatable', 'LabelVariableController@getData');
Route::resource('labelVariables', 'LabelVariableController');

Route::get('notifications/datatable', 'NotificationController@getData');
Route::resource('notifications', 'NotificationController');





