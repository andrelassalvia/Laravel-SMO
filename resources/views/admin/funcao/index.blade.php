@extends('layouts.base')

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Funções'" ></x-admin.title-component>
  <div class="d-flex">
    {{-- Pesquisa --}}
    <x-admin.search-component :table="'funcao'" :placeholder="'Procura função'"></x-admin.search-component>
    {{-- Adicao de Registro --}}
    <x-admin.add-register :table="'funcao'" :title="'Cadastrar função'"></x-admin.add-register>
  </div>
  {{-- Mensagem de cadastro com sucesso --}}
  @include('admin._components.alertSuccess')
  {{-- TABELA COM LISTA DE FUNCOES --}}
  <x-admin.list-component :data="$data" :column="'Função'"></x-admin.list-component>
  {{-- Voltar para Funcoes Botao voltar nao pode aparecer na pogina index --}}
  <div class="ms-3">
    @if(Route::is('funcao.search') && request()->filled('nome'))
      <a class="btn btn-link" href="{{route('funcao.index')}}">Voltar</a>
    @endif
  </div>
  {{-- Paginacao --}}
  @include('admin._components.pagination')
</div>

@endsection