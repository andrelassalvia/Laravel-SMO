@extends('layouts.base')

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Exames'"></x-admin.title-component>
  <div class="d-flex">
    {{-- Pesquisa --}}
    <x-admin.search-component :table="'exame'" :placeholder="'Procura exame'"></x-admin.search-component>
    {{-- Adicao de Registro --}}
    <x-admin.add-register :table="'exame'" :title="'Cadastrar exame'"></x-admin.add-register>
  </div>
  {{-- Mensagem de cadastro com sucesso --}}
  @include('admin._components.alertSuccess')
  {{-- TABELA COM LISTA DE exames --}}
  <x-admin.list-component :data="$data" :column="'Exame'"></x-admin.list-component>
  {{-- Voltar para exames --}}
  <div class="ms-3">
    @if(Route::is('exame.search') && request()->filled('nome'))
      <a class="btn btn-link" href="{{route('exame.index')}}">Voltar</a>
    @endif
  </div>
  {{-- Paginacao --}}
 @include('admin._components.pagination')
</div>

@endsection