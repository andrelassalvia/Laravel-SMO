@extends('layouts.base')


@section('content')

  <div class="conteudo">
    <x-admin.title-component :title="'Administração de Grupos Homogêneos'"></x-admin.title-component>

    <x-admin.form-name-component :group="''" :data="$data" :blade="'create'">
      <x-slot name="tabs"></x-slot>
      <x-slot name="delete"></x-slot>
      <x-slot name="button">
         <x-admin.save-button-component></x-admin.save-button-component>
      </x-slot>
      <x-slot name="form2"></x-slot>
      <x-slot name="form3"></x-slot>
    </x-admin.form-name-component>

    <x-admin.back-button-component :model="$data"></x-admin.back-button-component> 
  
    @include('admin._components.alertErrors')
        
  </div>

@endsection