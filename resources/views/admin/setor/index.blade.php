@extends('layouts.base')


@section('content')

<div class="conteudo">
  @include('admin.setor.title')

  <div class="d-flex">

    {{-- Pesquisa --}}
    <div class="form-search" style="margin-bottom: 20px; margin-left:10%; 100px;width:20%">
      <form method="get" class="search" action="{{route('setores.search')}}">
        <input type="text" class="form-control me-2" name="nome" placeholder="Nome do setor">
        <button class="btn btn-primary">
          <i class="bi bi-search" aria-hidden="true"></i>
        </button>
      </form>
    </div>
    
    {{-- Adicao de Registro --}}
    <div class="form-central" style="margin-bottom: 20px; margin-left:2%; 100px;width:20%">
      <div class="btn btn-primary">
        <a href="{{route('setores.create')}}" style="color: #fff; text-decoration:none">Cadastrar setor
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
  {{-- TABELA COM LISTA DE setores --}}
  <table class="table table-striped table-hover mb-3" style="width: 80%; margin:auto">
    <tr>
      <th>Setor</th>
      <th width='100'>Ações</th>
    </tr>
    @foreach ($setores as $setor )
    <tr>
      <td>{{$setor->nome}}</td>
      <td width='100'>
        <a href="{{route('setores.edit',$setor->id)}}" class="btn btn-primary btn-sm">
          <i class="bi bi-pen" aria-hidden="true"></i>
        </a>
        <a href="{{route('setores.show', $setor->id)}}" class="btn btn-danger btn-sm">
          <i class="bi bi-trash" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
        
    @endforeach
  </table>

  {{-- Voltar para setores --}}
  <div class="ms-3">
    @if(Route::is('setores.search') && request()->filled('nome'))

    <a class="btn btn-link" href="{{route('setores.index')}}">Voltar</a>
      

    @endif
  </div>

  {{-- Paginacao --}}
  <div class="pagination">
    @if(isset($dataForm))

      {{$setores->appends($dataForm)->links()}}
    
    @else

      {{$setores->links()}}
    
    @endif
        
    

  </div>
  

</div>

    
@endsection