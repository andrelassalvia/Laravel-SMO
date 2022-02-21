@extends('layouts.base')

@section('content')
    <div class="conteudo">

      <x-admin.title-component :title="'Administração de Grupos Homogêneos - Funções'"></x-admin.title-component>

      <x-admin.form-name-component :group="'grupofuncao'" :blade="'index'" :data="$data">
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
                :active="'active'" 
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
        <x-slot name="form2">
          <x-admin.form-component 
            :label="'Função'" 
            :option-column="'funcao_id'" 
            :data="$funcoes">
          </x-admin.form-component>
        </x-slot>
        <x-slot name="form3">
          <x-admin.form-component 
          :label="'Setor'" 
          :option-column="'setor_id'" 
          :data="$setores">
        </x-admin.form-component>
        </x-slot>
        <x-slot name="button">
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
              <th scope="col">Função</th>
              <th scope="col">Setor</th>
              <th scope="col" style="width: 100px">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($grupoFuncoes as $grupoFuncao)
            <tr>
              <td>{{$grupoFuncao->funcao['nome']}}</td>
              <td>{{$grupoFuncao->setor['nome']}}</td>
              
              {{-- Botao Deletar --}}
              <td style="width: 100px">
                <a href="{{route('grupofuncao.destroy', $grupoFuncao->id)}}" class="btn btn-danger btn-sm">
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