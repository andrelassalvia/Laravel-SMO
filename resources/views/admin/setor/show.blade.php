@extends('layouts.base') 

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Setores'" ></x-admin.title-component>

  <x-admin.form-name-component :group="''" :data="$data" :blade="'show'">

    <x-slot name="tabs"></x-slot>
    <x-slot name="delete">
      <input type="hidden" name="_method" value="DELETE">
    </x-slot>

    <x-slot name="form2"></x-slot>
    <x-slot name="form3"></x-slot>

    <x-slot name="button">
      <x-admin.delete-button-component></x-admin.delete-button-component>
    </x-slot>
    
  </x-admin.form-name-component>

  <x-admin.back-button-component :model="$data"></x-admin.back-button-component>

  @include('admin._components.alertErrors')
      
</div>

    
@endsection