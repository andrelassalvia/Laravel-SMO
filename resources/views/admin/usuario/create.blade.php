@extends('layouts.base')

@section('content')
  <x-admin.title-component :title="'Cadastramento de Usuários'" ></x-admin.title-component>
  <div class="conteudo">
    <form action="{{route('users.store')}}" method="post">
      <div class="form5">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row mb-2">
              <label class="col-sm-2 col-form-label" for="name">Nome:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="name" value="{{old('name')}}">
              </div>
            </div>  
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="email">E-Mail:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="email" name="email" value="{{old('email')}}">
              </div>
            </div>
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="password">Senha:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password">
              </div>
            </div>
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="password_confirmation">Confirme:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password_confirmation">
              </div>
            </div>
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="tipousuario_id">Tipo Usuário:</label>
              <div class="col-sm-8">
                    <select class="form-select" name="tipousuario_id">
                        <option value="">Selecione</option>
                        @foreach($tipoUsuarios as $item)
                            <option 
                              value="{{$item->id}}" 
                              {{old('tipousuario_id') == $item->id ? 'selected' : ''}}
                              >{{$item->nome}}
                            </option>
                        @endforeach
                    </select>
              </div>
            </div>
            <div class="row align-items-center">
                <label class="col-sm-2 col-form-label" for="status">Status:</label>
                <div class="col-sm-2">
                    <input type="radio" name="status" checked value="1"> Ativo                     
                </div>
                <div class="col-sm-2">
                    <input type="radio" name="status" value="0"> Inativo                     
                </div>
            </div>
            @include('admin._components.alertErrors')
            
      </div>
      <div style="margin-top: 35px;">
        <div class="form-group">
          <button type="submit" class="btn btn-primary" style="margin-left:42vw">
            <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
          </button>
        </div>
      </div>
    </form>
  </div>

  @endsection
    
        
