<?php



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::group(['middleware' => ['role:administrador']], function () {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    //usuarios
    Route::get('/usuarios',    'UsuariosController@index')->name('usuarios');
    Route::get('/usuarios/detalle/{id}', 'UsuariosController@detalle')->name('usuarios.detalle');
    Route::get('/usuarios/editar/{id}', 'UsuariosController@editar')->name('usuarios.editar');
    Route::put('/usuarios/editar/{id}', 'UsuariosController@update')->name('usuarios.update');
    Route::delete('/usuarios/eliminar/{id}','UsuariosController@eliminar')->name('usuarios.eliminar');
});

//home
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/eliminarlote', 'HomeController@eliminarlote')->name('eliminarlote');
Route::get('/home/detalle/{id}', 'HomeController@detalle')->name('contactos.detalle');
Route::get('/home/editar/{id}', 'HomeController@editar')->name('contactos.editar');
Route::put('/home/editar/{id}', 'HomeController@update')->name('contactos.update');
Route::delete('/home/eliminar/{id}','HomeController@eliminar')->name('contactos.eliminar');
//parametros
Route::get('/parametros', 'HomeController@parametros')->name('parametros');

//importar exportar excel
Route::get('contact-list-excel',    'ContactoController@exportExcel')->name('contacts.excel');
Route::post('import-list-excel', 'ContactoController@importExcel')->name('contacts.import.excel');
//envio
Route::post('/home/enviar',    'HomeController@envio')->name('envio');
