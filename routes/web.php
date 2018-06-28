<?php
Auth::routes();

Route::get('/','HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth','prefix' => 'painel'], function () {
    Route::any('{all}', function () {
        return view('layouts.app-painel');
    })->where(['all' => '.*']);
});

Route::group(['middleware' => 'auth','prefix' => 'api'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('usuario', 'UsuarioController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::resource('produto', 'ProdutoController');
    Route::resource('lista', 'ListaController');
    Route::resource('listapreco', 'ListaPrecoController');
    Route::POST('usuario/getpermission', 'UsuarioController@getPermission');
});