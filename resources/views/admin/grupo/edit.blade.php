@extends('layouts.base') 

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Grupos Homogêneos'"></x-admin.title-component>

  <x-admin.form-name-component :data="$data" :blade="'edit'" :group="''">
    {{-- TABS de navegacao --}}
    <x-slot name="tabs">
      <div class="">
        <ul class="nav nav-tabs tabs" style="margin-bottom: 10px; margin-top: -10px">
          <x-admin.tabs-component 
            :active="'active'" {{-- shine active tab or no--}}
            :route="'grupo.edit'" {{-- route tab goes --}}
            :id="$data->id" 
            :tab-name="'Grupo'">
          </x-admin.tabs-component>
          <x-admin.tabs-component 
            :active="''" {{-- shine active tab or no--}}
            :route="'grupofuncao.index'" {{-- route tab goes --}}
            :id="$data->id" 
            :tab-name="'Funções x Setores'">
          </x-admin.tabs-component>
          <x-admin.tabs-component 
            :active="''" {{-- shine active tab or no--}}
            :route="'gruporisco.index'" {{-- route tab goes --}}
            :id="$data->id" 
            :tab-name="'Riscos'">
          </x-admin.tabs-component>
          <x-admin.tabs-component 
            :active="''" {{-- shine active tab or no--}}
            :route="'grupoexame.index'" {{-- route tab goes --}}
            :id="$data->id" 
            :tab-name="'Exames'">
          </x-admin.tabs-component>
        </ul>
      </div>
    </x-slot>

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

