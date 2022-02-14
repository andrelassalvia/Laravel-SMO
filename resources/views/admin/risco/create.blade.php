@extends('layouts.base')

@section('content')

<div class="conteudo">

  @include('admin.risco.title')

  <form method="post" action="{{route('riscos.store')}}" class="form-control form--create">

    {{-- INPUT RISCO --}}
    <div class="form1 mt-2">

      <input type="hidden" name="_token" value="{{csrf_token()}}">

      <div class="d-flex align-items-center">

        <div class="form-group d-flex col-sm-11">
  
          <label for="nome" class="control-labe col-sm-2 control-label--create">Risco:</label>
          <input type="text" name="nome" value="{{old('nome')}}" placeholder="Insira o nome de um risco" class="form-control">
  
        </div>

      </div>
      
    </div>

    {{-- INPUT TIPO DE RISCO --}}
    <div class="form1">

      <div class="d-flex align-items-center">

        <div class="form-group d-flex col-sm-11">
  
          <label for="nome" class="control-labe col-sm-2 control-label--create">Tipo de Risco:</label>
          <select class="form-select" name="tiporisco_id">
            <option value="">Selecione</option>
            @foreach ($tipoRiscos as $tipoRisco )
                <option value="{{$tipoRisco->id}}">{{$tipoRisco->nome}}</option>
            @endforeach
          </select>
  
        </div>

      </div>
      
    </div>

    <br>
    {{-- Botao Salvar --}}
    <div class="form-group ms-3">
     <button type="submit" class="btn btn-primary btn-sm">
       <i class="bi bi-save2" aria-hidden="true">Salvar</i>
     </button>
   </div>
  
  </form>

  <div class="ms-3">
    <a class="btn btn-link " href="{{route('riscos.index')}}">Voltar</a>
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