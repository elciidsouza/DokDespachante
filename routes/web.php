<?php

use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return redirect()->route('login');
})->name('/');

Auth::routes();

/* Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::group(['prefix' => 'usuarios'], function () {
		Route::get('/', ['as' => 'usuarios', 'uses' => 'App\Http\Controllers\UsuariosController@index']);
		Route::get('novo', ['as' => 'usuarios.novo', 'uses' => 'App\Http\Controllers\UsuariosController@form']);
		Route::get('edit/{id}', ['as' => 'usuarios.edit', 'uses' => 'App\Http\Controllers\UsuariosController@form']);
		Route::post('store', ['as' => 'usuarios.store', 'uses' => 'App\Http\Controllers\UsuariosController@store']);
		Route::post('delete', ['as' => 'usuarios.delete', 'uses' => 'App\Http\Controllers\UsuariosController@delete']);
	});

	Route::group(['prefix' => 'veiculos'], function () {
		Route::get('/', ['as' => 'veiculos', 'uses' => 'App\Http\Controllers\VeiculosController@index']);
		Route::get('novo', ['as' => 'veiculos.novo', 'uses' => 'App\Http\Controllers\VeiculosController@form']);
		Route::get('edit/{id}', ['as' => 'veiculos.edit', 'uses' => 'App\Http\Controllers\VeiculosController@form']);
		Route::post('store', ['as' => 'veiculos.store', 'uses' => 'App\Http\Controllers\VeiculosController@store']);
		Route::post('delete', ['as' => 'veiculos.delete', 'uses' => 'App\Http\Controllers\VeiculosController@delete']);
	});
});

