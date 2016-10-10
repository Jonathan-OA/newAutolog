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
    //API
    Route::get('/api/documentsProd', 'Modulos\Producao\ProductionController@getDocuments');
    Route::post('/api/grid/', 'Modulos\Geral\GridController@setColumns');
    Route::get('/api/grid/{module}', 'Modulos\Geral\GridController@getColumns');
});



