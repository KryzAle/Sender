<?php



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/detalle/{id}', 'HomeController@detalle')->name('contactos.detalle');