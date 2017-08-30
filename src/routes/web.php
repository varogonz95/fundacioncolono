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

Route::get('/', function () {return view('index');});
Route::get('home', function () {return view('templates.home');});

Route::get('chart1', function () {return view('charts.example1');});
Route::get('chart2', function () {return view('charts.example2');});


Route::resource('person', 'PersonaController',['except'=>['edit','show','create']]);
Route::get('person/seed', 'PersonaController@seed');

Route::get('person/header', function(){return view('partials.person._header');});
Route::get('person/index', function(){return view('templates.person.index');});
Route::get('person/create', function(){return view('templates.person.create');});


Route::resource('records', 'ExpedienteController',['except'=>['edit','show','create']]);
Route::get('records/index', function(){return view('templates.records.index');});
Route::post('records/{person}','ExpedienteController@append');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
