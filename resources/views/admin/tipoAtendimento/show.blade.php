@extends('layouts.base') 

@section('content')

<div class="conteudo">
  @include('admin.tipoAtendimento.title')

  <form 
    action="{{route('tipoAtendimentos.destroy',[$tipoAtendimentos->id])}}" 
    class="form-control form--create" method="get">
    <div class="form1">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="_method" value="DELETE">

      <div class="d-flex align-items-center">

        <div class="form-group d-flex col-sm-11">
          <label for="nome" class="control-label col-sm-2 control-label--create">Tipo de Atendimento:</label>
          <div class=" col-sm-10 ">
            <input placeholder="" type="text" name="nome" class="form-control" value="{{$tipoAtendimentos->nome}}">
          </div>
        </div>
        
          <div class="form-group ms-3">
            <button type="submit" class="btn btn-danger btn-sm">
              <i class="bi bi-trash" aria-hidden="true"></i>
            </button>
          </div>
      </div>
    </div>
  </form>

  <div class= ms-3">
    <a class="btn btn-link" href="{{route('tipoAtendimentos.index')}}">Voltar</a>
  </div>
  
  @if (isset($errors) && count($errors)>0)
  <div class="alert alert-warning alert--errors">
    @foreach ($errors->all() as $error)
      <p>{{$error}}</p>
    @endforeach
  </div>
  @endif
      
</div>
    
@endsection