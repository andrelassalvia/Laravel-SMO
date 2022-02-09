@extends('layouts.base')


@section('content')

<div class="conteudo">
  @include('admin.grupo.title')

  <div class="d-flex">

    {{-- Pesquisa --}}
    <div class="form-search" style="margin-bottom: 20px; margin-left:10%; 100px;width:20%">
      <form method="get" class="search" action="{{route('grupos.search')}}">
        <input type="text" class="form-control me-2" name="nome" placeholder="Nome do grupo">
        <button class="btn btn-primary">
          <i class="bi bi-search" aria-hidden="true"></i>
        </button>
      </form>
    </div>
    
    {{-- Adicao de Registro --}}
    <div class="form-central" style="margin-bottom: 20px; margin-left:2%; 100px;width:20%">
      <div class="btn btn-primary">
        <a href="{{route('grupos.create')}}" style="color: #fff; text-decoration:none">Cadastrar grupo
          <i class="bi bi-plus-lg" style="color: #fff"></i>
        </a>
      </div>
    </div>
  </div>

  {{-- Mensagem de cadastro com sucesso --}}
  @if(Session::has('success'))
    <div class="alert alert-success" style="margin: auto; margin-bottom:1%;width:80%;">
      {{Session::get('success')}}
    </div>

  @endif
  {{-- TABELA COM LISTA DE grupos --}}
  <table class="table table-striped table-hover mb-3" style="width: 80%; margin:auto">
    <tr>
      <th>grupo</th>
      <th width='100'>Ações</th>
    </tr>
    @foreach ($grupos as $grupo )
    <tr>
      <td>{{$grupo->nome}}</td>
      <td width='100'>
        {{-- editar registro --}}
        <a href="{{route('grupos.edit',$grupo->id)}}" class="btn btn-primary btn-sm">
          <i class="bi bi-pen" aria-hidden="true"></i>
        </a>
        {{-- deletar registro --}}
        <a href="{{route('grupos.show', $grupo->id)}}" class="btn btn-danger btn-sm">
          <i class="bi bi-trash" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
        
    @endforeach
  </table>

  {{-- Voltar para grupos --}}
  <div class="ms-3">
    @if(Route::is('grupos.search') && request()->filled('nome'))

    <a class="btn btn-link" href="{{route('grupos.index')}}">Voltar</a>
      

    @endif
  </div>
  {{-- Paginacao --}}
  <div class="pagination">
    @if(isset($dataForm))

      {{$grupos->appends($dataForm)->links()}}
    
    @else

      {{$grupos->links()}}
    
    @endif
        
    

  </div>
  

</div>

    
@endsection