@extends('layouts.base')

@section('content')
    <div class="conteudo">

      <x-admin.title-component :title="'Administração de Grupos Homogêneos - Exames'"></x-admin.title-component>

      <x-admin.form-name-component :data="$data" :blade="'index'" :group="'grupoexame'">
        <x-slot name="delete"></x-slot>
        {{-- Tabs de Navegacao --}}
        <x-slot name="tabs">
          <div class="tab">
            <ul class="nav nav-tabs">
              <x-admin.tabs-component 
                :active="''" 
                :route="'grupo.edit'"
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
                :active="'active'" {{-- shine active tab or no--}}
                :route="'grupoexame.index'" {{-- route tab goes --}}
                :id="$data->id" 
                :tab-name="'Exames'">
              </x-admin.tabs-component>
            </ul>
          </div>
        </x-slot>
        <x-slot name='form2'>
          <x-admin.form-component :label="'Exame'" :option-column="'exame_id'" :data="$exames"></x-admin.form-component>
        </x-slot>
        <x-slot name='form3'>
          <x-admin.form-component :label="'Atendimento'" :option-column="'tipoatendimento_id'" :data="$tipoAtendimentos"></x-admin.form-component>
        </x-slot>
        <x-slot name='button'>
          <x-admin.save-button-component></x-admin.save-button-component>
        </x-slot>
      </x-admin.form-name-component>



      {{-- Mensagem de erro no cadastro --}}
      @include('admin._components.alertErrors')
       {{-- Mensagem de cadastro com sucesso --}}
      @include('admin._components.alertSuccess')

      {{-- Table --}}
      <div class="container">
        <table class="table table-hover table-sm mt-3" style="width: 70%; margin:auto">
          <thead>
            <tr>
              <th scope="col">Exame</th>
              <th scope="col">Tipo de Atendimento</th>
              <th scope="col" style="width: 100px">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($grupoExames as $grupoExame)
            {{-- {{dd($grupoExame)}} --}}
            <tr>
              <td>{{$grupoExame->exame['nome']}}</td>
              <td>{{$grupoExame->tipoatendimento['nome']}}</td>
              
              {{-- Botao Deletar --}}
              <td style="width: 100px">
                <a href="{{route('grupoexame.destroy', $grupoExame->id)}}" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash" aria-hidden="true"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
          <x-admin.back-button-component :model="$data"></x-admin.back-button-component>
        
      </div>
    </div>

@endsection