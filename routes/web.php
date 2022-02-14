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

// FUNCAO
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

// SETOR
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

// EXAME
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

// GRUPO
Route::prefix('grupos')->controller('App\Http\Controllers\Admin\GrupoController')->middleware(['auth'])->group(function(){

    Route::get('/', 'index')->name('grupos.index');
    Route::get('/{id}/edit', 'edit')->name('grupos.edit');
    Route::any('/{id}/update', 'update')->name('grupos.update');
    Route::get('/{id}/show', 'show')->name('grupos.show');
    Route::any('/{id}/destroy', 'destroy')->name('grupos.destroy');
    Route::get('/search', 'search')->name('grupos.search');
    Route::get('/create', 'create')->name('grupos.create');
    Route::any('/store', 'store')->name('grupos.store');    
});


//  GRUPO FUNCAO
Route::prefix('grupofuncao')->controller('App\Http\Controllers\Admin\GrupoFuncaoController')->middleware(['auth'])->group(function(){

    Route::get('/{id}', 'index')->name('grupofuncao.index');
    Route::any('/{id}/destroy', 'destroy')->name('grupofuncao.destroy');
    Route::any('/{id}/store', 'store')->name('grupofuncao.store');    
});


//  GRUPO RISCO
Route::prefix('gruporisco')->controller('App\Http\Controllers\Admin\GrupoRiscoController')->middleware(['auth'])->group(function(){

    Route::get('/{id}', 'index')->name('gruporisco.index');
    Route::any('/{id}/destroy', 'destroy')->name('gruporisco.destroy');
    Route::any('/{id}/store', 'store')->name('gruporisco.store');    
});

// GRUPO EXAME
Route::prefix('grupoexame')->controller('App\Http\Controllers\Admin\GrupoExameController')->middleware(['auth'])->group(function(){

    route::get('/{id}', 'index')->name('grupoexame.index');
    route::any('/{id}/destroy', 'destroy')->name('grupoexame.destroy');
    route::any('/{id}/store', 'store')->name('grupoexame.store');
}); 

// RISCOS
Route::prefix('riscos')->controller('App\Http\Controllers\Admin\RiscoController')->middleware(['auth'])->group(function(){

    route::get('/', 'index')->name('riscos.index');
    route::get('/create', 'create')->name('riscos.create');
    route::get('/edit/{id}', 'edit')->name('riscos.edit');
    route::any('/update/{id}', 'update')->name('riscos.update');
    route::get('/show/{id}', 'show')->name('riscos.show');
    route::any('/store', 'store')->name('riscos.store');
    route::get('/search', 'search')->name('riscos.search');
    route::any('/destroy/{id}', 'destroy')->name('riscos.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
