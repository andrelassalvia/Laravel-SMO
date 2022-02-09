@extends('layouts.base')


@section('content')

<div class="conteudo">
  @include('admin.exame.title')

  <div class="d-flex">

    {{-- Pesquisa --}}
    <div class="form-search" style="margin-bottom: 20px; margin-left:10%; 100px;width:20%">
      <form method="get" class="search" action="{{route('exames.search')}}">
        <input type="text" class="form-control me-2" name="nome" placeholder="Nome do exame">
        <button class="btn btn-primary">
          <i class="bi bi-search" aria-hidden="true"></i>
        </button>
      </form>
    </div>
    
    {{-- Adicao de Registro --}}
    <div class="form-central" style="margin-bottom: 20px; margin-left:2%; 100px;width:20%">
      <div class="btn btn-primary">
        <a href="{{route('exames.create')}}" style="color: #fff; text-decoration:none">Cadastrar exame
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
  {{-- TABELA COM LISTA DE exames --}}
  <table class="table table-striped table-hover mb-3" style="width: 80%; margin:auto">
    <tr>
      <th>Exame</th>
      <th width='100'>Ações</th>
    </tr>
    @foreach ($exames as $exame )
    <tr>
      <td>{{$exame->nome}}</td>
      <td width='100'>
        <a href="{{route('exames.edit',$exame->id)}}" class="btn btn-primary btn-sm">
          <i class="bi bi-pen" aria-hidden="true"></i>
        </a>
        <a href="{{route('exames.show', $exame->id)}}" class="btn btn-danger btn-sm">
          <i class="bi bi-trash" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
        
    @endforeach
  </table>

  {{-- Voltar para exames --}}
  <div class="ms-3">
    @if(Route::is('exames.search') && request()->filled('nome'))

    <a class="btn btn-link" href="{{route('exames.index')}}">Voltar</a>
      

    @endif
  </div>
  {{-- Paginacao --}}
  <div class="pagination">
    @if(isset($dataForm))

      {{$exames->appends($dataForm)->links()}}
    
    @else

      {{$exames->links()}}
    
    @endif
        
    

  </div>
  

</div>

    
@endsection