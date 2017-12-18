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

Auth::routes();

Route::get('expedientes/test', 'ExpedientesController@test');

Route::get('/', 'HomeController@index')->name('home');

Route::post('expedientes/{expediente}/ayudas', 'AyudaExpedienteController@update');

// Route::post('historicos', 'AyudaExpedienteController@update');

//Route::get('inspectores/all', 'InspectoresController@all');
//Route::resource('inspectores', 'InspectoresController');


Route::middleware(['auth'])->group(function(){

    Route::get('expedientes/all','ExpedientesController@all');

    Route::post('expedientes/{expediente}/restore','ExpedientesController@restore');

    Route::resource('expedientes','ExpedientesController');

    Route::resource('historicos','HistoricoController');

    Route::resource('personas','PersonasController');

    Route::resource('referentes','ReferentesController');

    Route::resource('ayudas','AyudasController');

    Route::get('inspectores/all','InspectoresController@all');
    Route::resource('inspectores', 'InspectoresController');

});
