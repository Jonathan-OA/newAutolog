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
    Route::get('/producao', 'Modulos\Producao\ProductionController@index');
    Route::get('/recebimento', 'Modulos\Recebimento\ReceiptController@index');
    Route::get('/producao/detalhes/{document}', 'Modulos\Producao\ProductionController@items');
    Route::resource('documents', 'DocumentController');

    //API
    Route::get('/api/documentsProd', 'Modulos\Producao\ProductionController@getDocuments');
    Route::get('/api/itemsProd/{document}', 'Modulos\Producao\ProductionController@getItems');
    Route::post('/api/grid/', 'Modulos\Geral\GridController@setColumns');
    Route::get('/api/grid/{module}', 'Modulos\Geral\GridController@getColumns');

    //IMPORTAÇÃO
    Route::get('/import', 'ImportacaoGeralController@index');
});



