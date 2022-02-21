@extends('layouts.base') 

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Grupos Homogêneos'"></x-admin.title-component>

<x-admin.form-name-component :group="''" :data="$data" :blade="'show'">
  <x-slot name="tabs">
    <div class="tab">
      <ul class="nav nav-tabs">
        <x-admin.tabs-component 
          :active="'active'" 
          :route="'grupo.index'" 
          :id="$data->id" 
          :tab-name="'Grupo'">
        </x-admin.tabs-component>
        <x-admin.tabs-component
          :active="''" 
          :route="'grupofuncao.index'" 
          :id="$data->id" 
          :tab-name="'Funções x Setores'">
        </x-admin.tabs-component>
        <x-admin.tabs-component
          :active="''" 
          :route="'gruporisco.index'" 
          :id="$data->id" 
          :tab-name="'Riscos'">
        </x-admin.tabs-component>
        <x-admin.tabs-component
          :active="''" 
          :route="'grupoexame.index'" 
          :id="$data->id" 
          :tab-name="'Exames'">
        </x-admin.tabs-component>
      </ul>
    </div>
  </x-slot>
  <x-slot name="delete">
    <input type="hidden" name="_method" value="DELETE">
  </x-slot>
  <x-slot name="button">
     <x-admin.delete-button-component></x-admin.delete-button-component>
  </x-slot>

  <x-slot name="form2"></x-slot>
  <x-slot name="form3"></x-slot>

</x-admin.form-name-component>

<x-admin.back-button-component :model="$data"></x-admin.back-button-component> 

@include('admin._components.alertErrors')
      
</div>

    
@endsection