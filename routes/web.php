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

Route::get('/home', 'App\Http\Controllers\Admin\HomeController@index')
        ->middleware(['auth'])
        ->name('home');

// FUNCAO
Route::prefix('funcoes')
        ->controller('App\Http\Controllers\Admin\FuncaoController')
        ->middleware(['auth'])
        ->group(function()
        {
            Route::get('/', 'index')->name('funcao.index');
            Route::get('/create', 'create')->name('funcao.create');
            Route::post('/', 'store')->name('funcao.store');
            Route::get('/search', 'search')->name('funcao.search');
            Route::get('/{id}/show', 'show')->name('funcao.show');
            Route::get('/{id}/edit', 'edit')->name('funcao.edit');
            Route::post('/{id}/update', 'update')->name('funcao.update');
            Route::delete('/{id}/destroy', 'destroy')->name('funcao.destroy');
        });

// SETOR
Route::prefix('setores')
        ->controller('App\Http\Controllers\Admin\SetorController')
        ->middleware(['auth'])
        ->group(function()
        {
            Route::get('/', 'index')->name('setor.index');
            Route::get('/{id}/edit', 'edit')->name('setor.edit');
            Route::any('/{id}/update', 'update')->name('setor.update');
            Route::get('/{id}/show', 'show')->name('setor.show');
            Route::any('/{id}/destroy', 'destroy')->name('setor.destroy');
            Route::get('/search', 'search')->name('setor.search');
            Route::get('/create', 'create')->name('setor.create');
            Route::any('/store', 'store')->name('setor.store');
        });

// EXAME
Route::prefix('exames')
        ->controller('App\Http\Controllers\Admin\ExameController')
        ->middleware(['auth'])
        ->group(function()
        {
            Route::get('/', 'index')->name('exame.index');
            Route::get('/{id}/edit', 'edit')->name('exame.edit');
            Route::any('/{id}/update', 'update')->name('exame.update');
            Route::get('/{id}/show', 'show')->name('exame.show');
            Route::any('/{id}/destroy', 'destroy')->name('exame.destroy');
            Route::get('/search', 'search')->name('exame.search');
            Route::get('/create', 'create')->name('exame.create');
            Route::any('/store', 'store')->name('exame.store');
        });

// GRUPO
Route::prefix('grupos')
        ->controller('App\Http\Controllers\Admin\GrupoController')
        ->middleware(['auth'])
        ->group(function()
        {
            Route::get('/', 'index')->name('grupo.index');
            Route::get('/{id}/edit', 'edit')->name('grupo.edit');
            Route::any('/{id}/update', 'update')->name('grupo.update');
            Route::get('/{id}/show', 'show')->name('grupo.show');
            Route::any('/{id}/destroy', 'destroy')->name('grupo.destroy');
            Route::get('/search', 'search')->name('grupo.search');
            Route::get('/create', 'create')->name('grupo.create');
            Route::any('/store', 'store')->name('grupo.store');    
        });

//  GRUPO FUNCAO
Route::prefix('grupofuncao')
        ->controller('App\Http\Controllers\Admin\GrupoFuncaoController')
        ->middleware(['auth'])
        ->group(function()
        {
            Route::get('/{id}', 'index')->name('grupofuncao.index');
            Route::any('/{id}/destroy', 'destroy')->name('grupofuncao.destroy');
            Route::any('/{id}/store', 'store')->name('grupofuncao.store');    
        });

//  GRUPO RISCO
Route::prefix('gruporisco')
        ->controller('App\Http\Controllers\Admin\GrupoRiscoController')
        ->middleware(['auth'])
        ->group(function()
        {
            Route::get('/{id}', 'index')->name('gruporisco.index');
            Route::any('/{id}/destroy', 'destroy')->name('gruporisco.destroy');
            Route::any('/{id}/store', 'store')->name('gruporisco.store');    
        });

// GRUPO EXAME
Route::prefix('grupoexame')
        ->controller('App\Http\Controllers\Admin\GrupoExameController')
        ->middleware(['auth'])
        ->group(function()
        {
            route::get('/{id}', 'index')->name('grupoexame.index');
            route::any('/{id}/destroy', 'destroy')->name('grupoexame.destroy');
            route::any('/{id}/store', 'store')->name('grupoexame.store');
        }); 

// RISCOS
Route::prefix('riscos')
        ->controller('App\Http\Controllers\Admin\RiscoController')
        ->middleware(['auth'])
        ->group(function()
        {
            route::get('/', 'index')->name('risco.index');
            route::get('/create', 'create')->name('risco.create');
            route::get('/edit/{id}', 'edit')->name('risco.edit');
            route::any('/update/{id}', 'update')->name('risco.update');
            route::get('/show/{id}', 'show')->name('risco.show');
            route::any('/store', 'store')->name('risco.store');
            route::get('/search', 'search')->name('risco.search');
            route::any('/destroy/{id}', 'destroy')->name('risco.destroy');
        });

// TIPOS DE ATENDIMENTPO
Route::prefix('tipoAtendimentos')
        ->controller('App\Http\Controllers\Admin\TipoAtendimentoController')
        ->middleware(['auth'])
        ->group(function()
        {
            route::get('/', 'index')->name('tipoatendimento.index');
            route::get('/create', 'create')->name('tipoatendimento.create');
            route::get('/edit/{id}', 'edit')->name('tipoatendimento.edit');
            route::any('/update/{id}', 'update')->name('tipoatendimento.update');
            route::get('/show/{id}', 'show')->name('tipoatendimento.show');
            route::any('/store', 'store')->name('tipoatendimento.store');
            route::get('/search', 'search')->name('tipoatendimento.search');
            route::any('/destroy/{id}', 'destroy')->name('tipoatendimento.destroy');
        });

// TIPO USUARIO
Route::prefix('tipousuarios')
        ->controller('App\Http\Controllers\Admin\TipoUsuarioController')
        ->middleware(['auth'])
        ->group(function()
        {
            route::get('/', 'index')->name('tipousuario.index');
            route::get('create', 'create')->name('tipousuario.create');
            route::get('edit/{id}', 'edit')->name('tipousuario.edit');
            route::any('/update/{id}', 'update')->name('tipousuario.update');
            route::get('show/{id}', 'show')->name('tipousuario.show');
            route::any('store', 'store')->name('tipousuario.store');
            route::any('destroy/{id}','destroy')->name('tipousuario.destroy');
        });

// PERMISSAO
Route::prefix('permissoes')
        ->controller('App\Http\Controllers\Admin\PermissaoController')
        ->middleware(['auth'])
        ->group(function()
        {
            route::get('/{id}', 'index')->name('permissao.index');
            route::any('/{id}/destroy', 'destroy')->name('permissao.destroy');
            route::any('/{id}/store', 'store')->name('permissao.store');
            route::any('/{id}/edit', 'edit')->name('permissao.edit');
            route::post('/{id}/update', 'update')->name('permissao.update');
        }); 

// USERS
Route::prefix('users')
        ->middleware(['auth'])
        ->group(function()
        {
            route::resource('users', 'App\Http\Controllers\Admin\UsersController');
            route::get('/search', 'App\Http\Controllers\Admin\UsersController@search')
                ->name('users.search');
            route::get('/password/edit', 'App\Http\Controllers\Admin\UsersController@passwordEdit')
                ->name('password.edit');
            route::any('/password/update/{id}', 'App\Http\Controllers\Admin\UsersController@passwordUpdate')
                ->name('senha.update');
        });

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
