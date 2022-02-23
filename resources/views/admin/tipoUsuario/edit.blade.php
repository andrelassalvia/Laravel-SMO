@extends('layouts.base')

@section('content')
    <x-admin.title-component :title="'Administração de Tipos de Usuários'"></x-admin.title-component>

    <x-admin.form-name-component :data="$data" :blade="'edit'" :group="''">
      <x-slot name="tabs">
        <div class="tab">
          <ul class="nav nav-tabs">
            <x-admin.tabs-component
              :active="'active'"
              :route="'tipousuario.index'"
              :id="$data->id"
              :tab-name="'Tipo Usuário'"
              >
            </x-admin.tabs-component>
            <x-admin.tabs-component
              :active="''"
              :route="'permissao.index'"
              :id="$data->id"
              :tab-name="'Permissões'"
              >
            </x-admin.tabs-component>
          </ul>
        </div>
      </x-slot>
      <x-slot name="delete"></x-slot>
      <x-slot name="form2"></x-slot>
      <x-slot name="form3"></x-slot>

      <x-slot name="button">
        <x-admin.save-button-component></x-admin.save-button-component>
      </x-slot>

    </x-admin.form-name-component>

    @include('admin._components.alertErrors')

    <x-admin.back-button-component :model="$data"></x-admin.back-button-component>


@endsection