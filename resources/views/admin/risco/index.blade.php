@extends('layouts.base')

@section('content')
<div class="conteudo">
  <x-admin.title-component :title="'Administração de Riscos'"></x-admin.title-component>
  <div class="d-flex">
    {{-- Pesquisa --}}
    <x-admin.search-component :table="'risco'" :placeholder="'Procura risco'"></x-admin.search-component>
    {{-- Adicao de Registro --}}
    <x-admin.add-register :table="'risco'" :title="'Cadastrar risco'"></x-admin.add-register>
  </div>
  {{-- Mensagem de cadastro com sucesso --}}
  @include('admin._components.alertSuccess')
  {{-- TABELA COM LISTA DE RISCOS --}}
  <x-admin.list-component :data="$data" :column="'Risco'"></x-admin.list-component>
  {{-- Voltar para Riscos - Botao voltar nao pode aparecer na pogina index --}}
  <div class="ms-3">
    @if(Route::is('risco.search') && request()->filled('nome'))
      <a class="btn btn-link" href="{{route('risco.index')}}">Voltar</a>
    @endif
  </div>
  {{-- Paginacao --}}
  @include('admin._components.pagination')
</div>
@endsection