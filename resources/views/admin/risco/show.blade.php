@extends('layouts.base') 

@section('content')

<div class="conteudo">
  @include('admin.risco.title')

  <form action="{{route('riscos.destroy',[$risco->id])}}" class="form-control form--create" method="get">
    <div class="form1">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="_method" value="DELETE">
      <div class="d-flex align-items-center">

        {{-- Risco --}}
        <div class="form-group d-flex col-sm-11">
          <label for="nome" class="control-label col-sm-2 control-label--create">Risco:</label>
          <div class=" col-sm-10 ">
            <input placeholder="" type="text" name="nome" class="form-control" value="{{$risco->nome}}">
          </div>
        </div>
        
        {{-- Botao Delete --}}
          <div class="form-group ms-3">
            <button type="submit" class="btn btn-danger btn-sm">
              <i class="bi bi-trash" aria-hidden="true"></i>
            </button>
          </div>
        
      </div>
    </div>
  </form>
  <div class= ms-3">
    <a class="btn btn-link" href="{{route('riscos.index')}}">Voltar</a>
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