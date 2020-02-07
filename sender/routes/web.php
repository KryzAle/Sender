<?php



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/detalle/{id}', 'HomeController@detalle')->name('contactos.detalle');
Route::get('contact-list-excel',    'ContactoController@exportExcel')->name('contacts.excel');
Route::post('import-list-excel', 'ContactoController@importExcel')->name('contacts.import.excel');
Route::get('/home/enviar',    'HomeController@envio')->name('envio');