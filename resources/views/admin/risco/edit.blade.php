@extends('layouts.base')

@section('content')

<div class="conteudo">

  @include('admin.risco.title')

  <form action="{{route('riscos.update',[$risco->id])}}" class="form-control form--create" method="post">
    <div class="form1">

      <input type="hidden" name="_token" value="{{csrf_token()}}">

      <div class="d-flex align-items-center">

        {{-- Input do nome --}}
        <div class="form-group d-flex col-sm-11">
          <label for="nome" class="control-label col-sm-2 control-label--create">Risco:</label>
          <div class=" col-sm-10 ">
            <input placeholder="Cadastrar risco" type="text" name="nome" class="form-control" value="{{$risco->nome}}">
          </div>
        </div>
        
        
      </div>
      <div class="form1">

        <div class="d-flex align-items-center">
  
          <div class="form-group d-flex col-sm-11">
    
            <label for="nome" class="control-labe col-sm-2 control-label--create">Tipo de Risco:</label>
            <select class="form-select" name="tiporisco_id">
              <option value="">Selecione</option>
              @foreach ($tipoRiscos as $tipoRisco)
                @if ($tipoRisco->id == $risco->tiporisco_id )
                    <option value="{{$tipoRisco->id}}" selected>{{$tipoRisco->nome}}</option>
                @endif
                  <option value="{{$tipoRisco->id}}" >{{$tipoRisco->nome}}</option>
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

    </div>

  </form>

  {{-- botao voltar pagina --}}
  <div class="ms-3">
    <a class="btn btn-link" href="{{route('riscos.index')}}">Voltar</a>
  </div>
  
  {{-- Mensagem de erro de update na propria tela de edicao --}}
  @if (isset($errors) && count($errors)>0)
  <div class="alert alert-warning" style="margin: auto; width:400px">
    @foreach ($errors->all() as $error)
      <p>{{$error}}</p>
    @endforeach
  </div>
  @endif
  
</div>

    
@endsection