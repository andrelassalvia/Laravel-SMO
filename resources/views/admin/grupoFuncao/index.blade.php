@extends('layouts.base')

@section('content')
    <div class="conteudo">

      @include('admin.grupoFuncao.title')

      <form action="{{route('grupofuncao.store', $grupo->id)}}" method="post" class="form-control form--create">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        {{-- Tabs de Navegacao --}}
        <div class="aba">
          <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <a class="nav-link aba--nav" aria-current="page" href="{{route('grupos.edit', [$grupo->id])}}">Grupo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link aba--nav active" href="{{route('grupofuncao.index', [$grupo->id])}}">Funcoes x Setores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link aba--nav " href="{{route('gruporisco.index', $grupo->id)}}">Riscos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link aba--nav" href="{{route('grupoexame.index', $grupo->id)}}">Exames</a>
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

        {{-- Funcao - Input 2 - Select a function --}}
        <div class="form1">
          <div class="form-group d-flex col-sm-11 justify-content-center">
            <label class="control-label col-sm-2 control-label--create" for="funcao_id">Função</label>
            <div class="col-sm-8">
              <select class="form-select" name="funcao_id">
                <option value="">Selecione</option>
                @foreach ($funcoes as $funcao)
                    <option value="{{$funcao->id}}" {{old('funcao_id') == $funcao->id ? 'selected' : '' }}>{{$funcao->nome}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        {{-- Setor - Input 3 - Select a sector --}}
        <div class="form1">
          <div class="form-group d-flex col-sm-11 justify-content-center">
            <label class="control-label col-sm-2 control-label--create" for="setor_id">Setor</label>
            <div class="col-sm-8">
              <select class="form-select" name="setor_id">
                <option value="">Selecione</option>
                @foreach ($setores as $setor)
                    <option value="{{$setor->id}}" {{old('setor_id') == $setor->id ? 'selected' : ''}}>{{$setor->nome}}</option>
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
              <th scope="col">Função</th>
              <th scope="col">Setor</th>
              <th scope="col" style="width: 100px">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($grupoFuncoes as $grupoFuncao)
            <tr>
              <td>{{$grupoFuncao->funcao['nome']}}</td>
              <td>{{$grupoFuncao->setor['nome']}}</td>
              
              {{-- Botao Deletar --}}
              <td style="width: 100px">
                <a href="{{route('grupofuncao.destroy', $grupoFuncao->id)}}" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash" aria-hidden="true"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
          <a class="btn btn-link" href="{{route('grupos.index', [$grupo->id])}}">Voltar</a>
        
      </div>
    </div>

@endsection