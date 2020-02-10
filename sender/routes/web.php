<?php



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/detalle/{id}', 'HomeController@detalle')->name('contactos.detalle');
Route::get('/home/editar/{id}', 'HomeController@editar')->name('contactos.editar');
Route::put('/home/editar/{id}', 'HomeController@update')->name('contactos.update');
Route::delete('/home/eliminar/{id}','HomeController@eliminar')->name('contactos.eliminar');
Route::get('contact-list-excel',    'ContactoController@exportExcel')->name('contacts.excel');
Route::post('import-list-excel', 'ContactoController@importExcel')->name('contacts.import.excel');
Route::post('/home/enviar',    'HomeController@envio')->name('envio');