@extends('layouts.base')


@section('content')

<div class="conteudo">
  @include('admin.tipoAtendimento.title')

  <div class="d-flex">

    {{-- Pesquisa --}}
    <div class="form-search">
      <form method="get" class="search" action="{{route('tipoAtendimentos.search')}}">
        <input type="text" class="form-control me-2" name="nome" placeholder="Nome do tipo de atendimento">
        <button class="btn btn-primary">
          <i class="bi bi-search" aria-hidden="true"></i>
        </button>
      </form>
    </div>
    
    {{-- Adicao de Registro --}}
    <div class="form-central">
      <div class="btn btn-primary">
        <a 
          href="{{route('tipoAtendimentos.create')}}" 
          class="btn--style--cadastrar">Cadastrar tipo de atendimento
            <i class="bi bi-plus-lg" style="color: #fff"></i>
        </a>
      </div>
    </div>
  </div>

  {{-- Mensagem de cadastro com sucesso --}}
  @if(Session::has('success'))
    <div class="alert alert-success alert--success">
      {{Session::get('success')}}
    </div>
  @endif

  {{-- TABELA COM LISTA DE FUNCOES --}}
  <table class="table table-striped table-hover mb-3 table--style">
    <tr>
      <th>Tipo de Atendimento</th>
      <th width='100'>Ações</th>
    </tr>
    @foreach ($tipoAtendimentos as $tipoAtendimento )
    <tr>
      <td>{{$tipoAtendimento->nome}}</td>
      <td width='100'>
        <a href="{{route('tipoAtendimentos.edit',$tipoAtendimento->id)}}" class="btn btn-primary btn-sm">
          <i class="bi bi-pen" aria-hidden="true"></i>
        </a>
        <a href="{{route('tipoAtendimentos.show', $tipoAtendimento->id)}}" class="btn btn-danger btn-sm">
          <i class="bi bi-trash" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
    @endforeach
  </table>

  {{-- Voltar para Tipo Atendimento Botao voltar nao pode aparecer na pogina index --}}
  <div class="ms-3">
    @if(Route::is('tipoAtendimentos.search') && request()->filled('nome'))
      <a class="btn btn-link" href="{{route('tipoAtendimentos.index')}}">Voltar</a>
    @endif
  </div>

  {{-- Paginacao --}}
  <div class="pagination">
    @if(isset($dataForm))
      {{$tipoAtendimentos->appends($dataForm)->links()}}
    @else
      {{$tipoAtendimentos->links()}}
    @endif
  </div>
</div>

@endsection