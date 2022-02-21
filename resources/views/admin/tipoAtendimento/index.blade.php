@extends('layouts.base')

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Tipos de Atendimentos'" ></x-admin.title-component>
  <div class="d-flex">
    {{-- Pesquisa --}}
    <x-admin.search-component :table="'tipoatendimento'" :placeholder="'Procura por tipo de atendimento'"></x-admin.search-component>
    {{-- Adicao de Registro --}}
    <x-admin.add-register :table="'tipoatendimento'" :title="'Cadastrar tipo de atendimento'"></x-admin.add-register>
  </div>
  {{-- Mensagem de cadastro com sucesso --}}
  @include('admin._components.alertSuccess')
  {{-- TABELA COM LISTA DE FUNCOES --}}
  <x-admin.list-component :data="$data" :column="'Tipo de Atendimento'"></x-admin.list-component>
  {{-- Voltar para Tipo Atendimento Botao voltar nao pode aparecer na pogina index --}}
  <div class="ms-3">
    @if(Route::is('tipoatendimento.search') && request()->filled('nome'))
      <a class="btn btn-link" href="{{route('tipoatendimento.index')}}">Voltar</a>
    @endif
  </div>
  {{-- Paginacao --}}
  @include('admin._components.pagination')
</div>

@endsection