@extends('layouts.base')

@section('content')
<div class="conteudo">

  @include('admin.risco.title')

  <div class="d-flex">
   
    {{-- Pesquisa --}}
    <div class="form-search">
      <form method="get" class="search" action="{{route('riscos.search')}}">
        <input type="text" class="form-control me-2" name="nome" placeholder="Nome do risco">
        <button class="btn btn-primary">
          <i class="bi bi-search" aria-hidden="true"></i>
        </button>
      </form>
    </div>

    {{-- Adicao de Registro --}}
    <div class="form-central">
      <div class="btn btn-primary">
        <a href="{{route('riscos.create')}}" style="color: #fff; text-decoration:none">Cadastrar Risco
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

  {{-- TABELA COM LISTA DE RISCOS --}}
  <table class="table table-striped table-hover mb-3" style="width: 80%; margin:auto">

    <tr>
      <th>Risco</th>
      <th width='100'>Ações</th>
    </tr>

    @foreach ($riscos as $risco )

    <tr>
      <td>{{$risco->nome}}</td>
      <td width='100'>

        {{-- Botao de UpDate --}}
        <a href="{{route('riscos.edit',$risco->id)}}" class="btn btn-primary btn-sm">
          <i class="bi bi-pen" aria-hidden="true"></i>
        </a>

        {{-- Botao de Delete --}}
        <a href="{{route('riscos.show', $risco->id)}}" class="btn btn-danger btn-sm">
          <i class="bi bi-trash" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
        
    @endforeach
  </table>

  {{-- Voltar para Riscos - Botao voltar nao pode aparecer na pogina index --}}
  <div class="ms-3">
    @if(Route::is('riscos.search') && request()->filled('nome'))
      <a class="btn btn-link" href="{{route('riscos.index')}}">Voltar</a>
    @endif
  </div>

  {{-- Paginacao --}}
  <div class="pagination">
    @if(isset($dataForm))
      {{$riscos->appends($dataForm)->links()}}
    @else
      {{$riscos->links()}}
    @endif
  </div>

</div>
    
@endsection