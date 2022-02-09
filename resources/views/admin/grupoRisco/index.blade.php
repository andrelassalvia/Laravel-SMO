@extends('layouts.base')

@section('content')
    <div class="conteudo">

      @include('admin.grupoRisco.title')

      <form action="{{route('gruporisco.store', $grupo->id)}}" method="post" class="form-control form--create">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        {{-- Tabs de Navegacao --}}
        <div class="aba">
          <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <a class="nav-link aba--nav" aria-current="page" href="{{route('grupos.edit', [$grupo->id])}}">Grupo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link aba--nav" href="#">Funcoes x Setores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link aba--nav active" href="{{route('gruporisco.index', $grupo->id)}}">Riscos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link aba--nav" href="#">Exames</a>
            </li>
          </ul>
        </div>

        {{-- Grupo - Input 1 Disabled --}}
        <div class="form1 mb-2">
          
          <div class="form-group d-flex col-sm-11 justify-content-center">
            <label for="nome" class="control-label col-sm-2 control-label--create">Grupo:</label>
            <div class=" col-sm-8 ">
              <input placeholder="Cadastrar grupo" type="text" name="nome" class="form-control" value="{{$grupo->nome}}" disabled >
            </div>
          </div>
        </div>

        {{-- Risco - Input 2 - Select a risk --}}
        <div class="form1">
          <div class="form-group d-flex col-sm-11 justify-content-center">
            <label class="control-label col-sm-2 control-label--create" for="risco_id">Risco</label>
            <div class="col-sm-8">
              <select class="form-select" name="risco_id">
                <option value="">Selecione</option>
                @foreach ($riscos as $risco)
                    <option value="{{$risco->id}}">{{$risco->nome}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        {{-- Button Save --}}
        <button type="submit" class="btn btn-primary btn-sm">
          <i class="bi bi-save2" aria-hidden="true">Salvar</i>
        </button>
      </form>

      {{-- Mensagem de erro no cadastro --}}
      @if (isset($errors) && count($errors)>0)
      <div class="alert alert-warning" style="margin: auto; width:50%">
        @foreach ($errors->all() as $error)
          <p>{{$error}}</p>
        @endforeach
      </div>
      @endif
       {{-- Mensagem de cadastro com sucesso --}}
      @if(Session::has('success'))
        <div class="alert alert-success" style="margin: auto; margin-bottom:1%;width:50%;">
          {{Session::get('success')}}
        </div>
      @endif

      {{-- Table --}}
      <div class="container">
        <table class="table table-hover table-sm mt-3" style="width: 70%; margin:auto">
          <thead>
            <tr>
              <th scope="col">Risco</th>
              <th scope="col">Tipo de Risco</th>
              <th scope="col" style="width: 100px">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($grupoRiscos as $grupoRisco)
            <tr>
              <td>{{$grupoRisco->risco['nome']}}</td>
              <td>{{$grupoRisco->risco->tiporisco['nome']}}</td>
              
              {{-- Botao Deletar --}}
              <td style="width: 100px">
                <a href="{{route('gruporisco.destroy', $grupoRisco->id)}}" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash" aria-hidden="true"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="ms-3">
        <a class="btn btn-link" href="{{route('grupos.index')}}">Voltar</a>
      </div>
    </div>

@endsection