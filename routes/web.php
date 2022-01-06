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

Route::get('/home', 'App\Http\Controllers\Admin\HomeController@index')->middleware(['auth'])->name('home');

Route::get('/funcoes', 'App\Http\Controllers\Admin\FuncaoController@index')->middleware(['auth'])->name('funcoes.index');
Route::get('/funcoes/{id}/edit', 'App\Http\Controllers\Admin\FuncaoController@edit')->middleware(['auth'])->name('funcoes.edit');
Route::any('/funcoes/{id}/update', 'App\Http\Controllers\Admin\FuncaoController@update')->middleware(['auth'])->name('funcoes.update');
Route::get('/funcoes/{id}/show', 'App\Http\Controllers\Admin\FuncaoController@show')->middleware(['auth'])->name('funcoes.show');
Route::any('/funcoes/{id}/destroy', 'App\Http\Controllers\Admin\FuncaoController@destroy')->middleware(['auth'])->name('funcoes.destroy');
Route::get('/funcoes/search', 'App\Http\Controllers\Admin\FuncaoController@search')->middleware(['auth'])->name('funcoes.search');
Route::get('/funcoes/create', 'App\Http\Controllers\Admin\FuncaoController@create')->middleware(['auth'])->name('funcoes.create');
Route::any('/funcoes/store', 'App\Http\Controllers\Admin\FuncaoController@store')->middleware(['auth'])->name('funcoes.store');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
