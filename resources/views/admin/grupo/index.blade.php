@extends('layouts.base')

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Grupos Homogêneos'"></x-admin.title-component>
  <div class="d-flex">
    {{-- Pesquisa --}}
    <x-admin.search-component :table="'grupo'" :placeholder="'Procura grupo'"></x-admin.search-component>
    {{-- Adicao de Registro --}}
    <x-admin.add-register :table="'grupo'" :title="'Cadastrar grupo'"></x-admin.add-register>
  </div>
  {{-- Mensagem de cadastro com sucesso --}}
  @include('admin._components.alertSuccess')
  {{-- TABELA COM LISTA DE grupos --}}
  <x-admin.list-component :data="$data" :column="'Grupo'"></x-admin.list-component>
  {{-- Voltar para grupos --}}
  <div class="ms-3">
    @if(Route::is('grupo.search') && request()->filled('nome'))
    <a class="btn btn-link" href="{{route('grupo.index')}}">Voltar</a>
    @endif
  </div>
  {{-- Paginacao --}}
  @include('admin._components.pagination')
</div>
 
@endsection