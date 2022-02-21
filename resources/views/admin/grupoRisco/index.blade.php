@extends('layouts.base')

@section('content')
    <div class="conteudo">

      <x-admin.title-component :title="'Administração de Grupos Homogêneos - Riscos'"></x-admin.title-component>

      <x-admin.form-name-component :data="$data" :blade="'index'" :group="'gruporisco'">
        
        <x-slot name='tabs'>
          <div class="tab">
            <ul class="nav nav-tabs">
              <x-admin.tabs-component 
              :active="''"
              :route="'grupo.edit'"
              :id="$data->id"
              :tab-name="'Grupo'">
            </x-admin.tabs-component>
            <x-admin.tabs-component 
              :active="''"
              :route="'grupofuncao.index'"
              :id="$data->id"
              :tab-name="'Funções e Setores'">
            </x-admin.tabs-component>
            <x-admin.tabs-component 
              :active="'active'"
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
          <x-admin.form-component :label="'Risco'" :option-column="'risco_id'" :data="$riscos"></x-admin.form-component>
        </x-slot>

        <x-slot name="form3"></x-slot>

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
              <th scope="col">Risco</th>
              <th scope="col">Tipo de Risco</th>
              <th scope="col" style="width: 100px">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($grupoRiscos as $grupoRisco)
            <tr>
              <td>{{$grupoRisco->risco['nome']}}</td>
              <td>{{$grupoRisco->risco->tiporisco['nome']}}</td>
              
              {{-- Botao Deletar --}}
              <td style="width: 100px">
                <a href="{{route('gruporisco.destroy', $grupoRisco->id)}}" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash" aria-hidden="true"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <x-admin.back-button-component :model="$data"></x-admin.back-button-component>
    </div>

@endsection