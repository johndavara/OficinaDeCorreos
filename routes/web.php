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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Rutas Cliente
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cliente', 'ClienteController@index')->name('cliente');
Route::post('/cliente/registrar', 'ClienteController@store')->name('registrarCliente');
Route::put('/cliente/actualizar', 'ClienteController@update')->name('actualizarCliente');
Route::post('/cliente/eliminar', 'ClienteController@destroy')->name('eliminarCliente');
// Rutas Oficina
Route::get('/oficina', 'OficinaController@index')->name('oficina');
Route::post('/oficina/registrar', 'OficinaController@store')->name('registrarOficina');
Route::put('/oficina/actualizar', 'OficinaController@update')->name('actualizarOficina');
Route::post('/oficina/eliminar', 'OficinaController@destroy')->name('eliminarOficina');