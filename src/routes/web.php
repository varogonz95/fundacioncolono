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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('test', function(){
    return Filter::test();
});

Route::middleware(['auth'])->group(function(){

    Route::get('expedientes/all','ExpedientesController@all');
    Route::resource('expedientes','ExpedientesController');

    Route::resource('personas','PersonasController');

    Route::resource('referentes','ReferentesController');

    Route::resource('ayudas','AyudasController');

});
