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

// Rotas para FUNCAO
Route::prefix('funcoes')->controller('App\Http\Controllers\Admin\FuncaoController')->middleware(['auth'])->group(function(){

    Route::get('/', 'index')->name('funcoes.index');
    Route::get('/{id}/edit', 'edit')->name('funcoes.edit');
    Route::any('/{id}/update', 'update')->name('funcoes.update');
    Route::get('/{id}/show', 'show')->name('funcoes.show');
    Route::any('/{id}/destroy', 'destroy')->name('funcoes.destroy');
    Route::get('/search', 'search')->name('funcoes.search');
    Route::get('/create', 'create')->name('funcoes.create');
    Route::any('/store', 'store')->name('funcoes.store');
});

// Rotas para SETOR
Route::prefix('setores')->controller('App\Http\Controllers\Admin\SetorController')->middleware(['auth'])->group(function(){

    Route::get('/', 'index')->name('setores.index');
    Route::get('/{id}/edit', 'edit')->name('setores.edit');
    Route::any('/{id}/update', 'update')->name('setores.update');
    Route::get('/{id}/show', 'show')->name('setores.show');
    Route::any('/{id}/destroy', 'destroy')->name('setores.destroy');
    Route::get('/search', 'search')->name('setores.search');
    Route::get('/create', 'create')->name('setores.create');
    Route::any('/store', 'store')->name('setores.store');
});

// Rotas para EXAME
Route::prefix('exames')->controller('App\Http\Controllers\Admin\ExameController')->middleware(['auth'])->group(function(){

    Route::get('/', 'index')->name('exames.index');
    Route::get('/{id}/edit', 'edit')->name('exames.edit');
    Route::any('/{id}/update', 'update')->name('exames.update');
    Route::get('/{id}/show', 'show')->name('exames.show');
    Route::any('/{id}/destroy', 'destroy')->name('exames.destroy');
    Route::get('/search', 'search')->name('exames.search');
    Route::get('/create', 'create')->name('exames.create');
    Route::any('/store', 'store')->name('exames.store');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
