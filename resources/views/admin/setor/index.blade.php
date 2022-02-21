@extends('layouts.base')

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Setores'" ></x-admin.title-component>
  <div class="d-flex">
    {{-- Pesquisa --}}
    <x-admin.search-component :table="'setor'" :placeholder="'Procura setor'"></x-admin.search-component>
    {{-- Adicao de Registro --}}
    <x-admin.add-register :table="'setor'" :title="'Cadastrar setor'"></x-admin.add-register>
  </div>
  {{-- Mensagem de cadastro com sucesso --}}
  @include('admin._components.alertSuccess')
  {{-- TABELA COM LISTA DE setores --}}
  <x-admin.list-component :data="$data" :column="'Setor'"></x-admin.list-component>
  {{-- Voltar para setores --}}
  <div class="ms-3">
    @if(Route::is('setor.search') && request()->filled('nome'))

    <a class="btn btn-link" href="{{route('setor.index')}}">Voltar</a>
    @endif
  </div>
  {{-- Paginacao --}}
  @include('admin._components.pagination')
</div>
@endsection