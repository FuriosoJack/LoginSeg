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

Route::get('/', [
  'uses'=>'Auth\LoginController@view',
  'as'=>'login'
]);

Route::group(['prefix'=>'admin'],function(){
  Route::get('view',[
    'uses'=>'Administracion@view',
    'as'=>'viewAdmin'
  ]);

  Route::group(['prefix'=>'reportes'],function(){
    Route::get('reportes/',[
      'uses'=>'Administracion@reportesView',
      'as'=>'resportesViewAdmin'
    ]);

    Route::get('registros/{filtro}',[
      'uses'=>'Administracion@registrosView',
      'as'=>'registrosViewAdmin'
    ]);
    Route::get('graficas',[
      'uses'=>'Administracion@graficasView',
      'as'=>'graficasView'
    ]);
  });

  Route::get('listaUsuarios',[
    'uses'=>'Administracion@listaUsuarios',
    'as'=>'listaUsuarios'
  ]);

});
// Authentication Routes...
Route::post('login', [
  'uses'=>'Auth\LoginController@login',
  'as'=>'loginP'
]);
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register',[
  'uses'=> 'Auth\RegisterController@view',
  'as'=>'registerView'
]);
Route::post('register', [
  'uses'=>'Auth\RegisterController@register',
  'as'=>'registerCreate']);


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('home',[
  'uses'=>'HomeController@index',
  'as'=>'home'
]);


Route::group(['prefix'=>'marcar'],function(){
  Route::get('{tipo}',[
    'uses'=>'HomeController@createMarcacion',
    'as'=>'marcar'
  ]);
});
