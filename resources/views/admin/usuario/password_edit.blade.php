@extends('layouts.base')

@section('content')
    <div class="conteudo">
      <x-admin.title-component :title="'Alteração de Senha'"></x-admin.title-component>
{{-- {{dd($user->id)}} --}}
      <form action="{{route('senha.update', $user->id)}}" method="post">
        @csrf
        {{-- <input type="hidden" name="_method" value="PATCH"> --}}
        <div class="form4">
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="name">Nome:</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="name" value="{{$user->name}}" disabled>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="last_password">Senha Anterior:</label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="last_password">
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="password">Senha Nova:</label>
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
        </div>

        <div style="margin-top: 35px;">
          <div class="form-group">
            <button type="submit" class="btn btn-primary" style="margin-left:42vw">
              <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
            </button>
          </div>
        </div>
      </form>
      @include('admin._components.alertErrors')
      @include('admin._components.alertSuccess')
    </div>
@endsection