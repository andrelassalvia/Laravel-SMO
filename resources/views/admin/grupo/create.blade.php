@extends('layouts.base')


@section('content')

  <div class="conteudo">
    @include('admin.grupo.title')

    <form action="{{route('grupos.store')}}" class="form-control form--create" method="post">
      
      <div class="form1">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="d-flex align-items-center">

          <div class="form-group d-flex col-sm-11">
            <label for="nome" class="control-label col-sm-2 control-label--create">Grupo:</label>
            <div class=" col-sm-10 ">
              <input placeholder="Cadastrar grupo" type="text" name="nome" class="form-control" value="{{old('nome')}}">
            </div>
          </div>
          
            <div class="form-group ms-3">
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-save2" aria-hidden="true">Salvar</i>
              </button>
            </div>
          
        </div>
      </div>
    </form>
    <div class="ms-3">
        <a class="btn btn-link " href="{{route('grupos.index')}}">Voltar</a>
    </div>
    
    @if (isset($errors) && count($errors)>0)
    <div class="alert alert-warning" style="margin: auto; width:400px">
      @foreach ($errors->all() as $error)
        <p>{{$error}}</p>
      @endforeach
    </div>
    @endif
        
  </div>

@endsection