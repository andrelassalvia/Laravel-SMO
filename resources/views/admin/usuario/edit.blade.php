@extends('layouts.base')

@section('content')
    <x-admin.title-component :title="'Alteração de usuários'"></x-admin.title-component>
    <div class="conteudo">
      <form action="{{route('users.update', $data->id)}}" method="post">
        <div class="form5">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <div class="row mb-2">
            <label for="name" class="col-sm-2 col-form-label">Nome:</label>
            <div class="col-sm-8">
              <input class="form-control" type="text" name="name" value="{{$data->name}}"></input>
            </div>
          </div>
          <div class="row mb-2">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-8">
              <input class="form-control" type="email" name="email" value="{{$data->email}}"></input>
            </div>
          </div>
          <div class="row mb-2">
            <label for="password" class="col-sm-2 col-form-label">Senha:</label>
            <div class="col-sm-8">
              <input class="form-control" type="password" name="password"></input>
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
                    <option>Selecione</option>
                    @foreach($tipoUsuarios as $item)
                        <option 
                          value="{{$item->id}}" 
                          {{$data['tipousuario_id'] == $item->id ? 'selected' : ''}}
                          >{{$item->nome}}
                        </option>
                    @endforeach
                </select>
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
          <div style="margin-top: 35px;">
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                <i 
                  style="font-size: 20px;" 
                  class="glyphicon glyphicon-floppy-disk" 
                  aria-hidden="true">
                </i> 
                Salvar
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
@endsection