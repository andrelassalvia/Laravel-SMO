@extends('layouts.base')

@section('content')
    <div class="conteudo">

      <x-admin.title-component :title="'Administração de Permissões'"></x-admin.title-component>

      <x-admin.form-name-component :data="$data" :blade="'index'" :group="'permissao'">
        <x-slot name="delete"></x-slot>
        {{-- Tabs de Navegacao --}}
        <x-slot name="tabs">
          <div class="tab">
            <ul class="nav nav-tabs">
              <x-admin.tabs-component 
                :active="''" 
                :route="'tipousuario.edit'"
                :id="$data->id"
                :tab-name="'Tipo Usuário'">
              </x-admin.tabs-component>
              <x-admin.tabs-component 
                :active="'active'" 
                :route="'permissao.index'" {{-- route tab goes --}}
                :id="$data->id" 
                :tab-name="'Permissões'">
              </x-admin.tabs-component>
            </ul>
          </div>
        </x-slot>
        <x-slot name='form2'>
          <x-admin.form-component :label="'Formulário'" :option-column="'formulario_id'" :data="$formularios"></x-admin.form-component>
        </x-slot>
        <x-slot name='form3'>
          <div class="form-group" >
            <label for="flexCheckDefault" class="control-label col-sm-2 control-label--create">Permissão</label>
            <div class="" style="display: grid; margin-left:18%">
              <div class="form-check"> 
                <input type="hidden" name="inclui" value="0">
                <input class="form-check-input" type="checkbox" name="inclui" value="1" id="flexCheckDefault">
                <label class="form-check-label" style="display: grid; align-items: center; padding:0; text-align:left" for="flexCheckDefault">
                  Incluir
              </div>
              <div class="form-check">
                <input type="hidden" name="altera" value="0">
                <input class="form-check-input" type="checkbox" name="altera" value="1" id="flexCheckDefault">
                <label class="form-check-label" style="display: grid; align-items: center; padding:0; text-align:left" for="flexCheckDefault">
                  Alterar
              </div>
              <div class="form-check">
                <input type="hidden" name="exclui" value="0">
                <input class="form-check-input" type="checkbox" name="exclui" value="1" id="flexCheckDefault">
                <label class="form-check-label" style="display: grid; align-items: center; padding:0; text-align:left" for="flexCheckDefault">
                  Excluir
              </div>
            </div>
          </div>
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
              <th scope="col">Formulario</th>
              <th scope="col">Inclui</th>
              <th scope="col">Altera</th>
              <th scope="col">Exclui</th>
              <th scope="col" style="width: 100px">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($permissoes as $permissao)
            <tr>
              <td>
                {{$permissao->formulario->nome}}
              </td>
              <td>
                @if ($permissao->inclui == 1)
                  <input type="checkbox" id="inc" disabled checked>
                @else
                  <input type="checkbox" disabled id="inc">
                @endif
              </td>
              <td>
                @if ($permissao->altera == 1)
                  <input type="checkbox" disabled checked id="alt">
                @else
                <input type="checkbox" disabled id="alt">
                @endif
              </td>
              <td>
                @if ($permissao->exclui == 1)
                  <input type="checkbox" disabled checked id="exc">
                @else
                <input type="checkbox" disabled id="exc">
                @endif
              </td>
             
              
              {{-- Botao Deletar --}}
              <td style="width: 100px">
                <a href="{{route('permissao.destroy', $permissao->id)}}" class="btn btn-danger btn-sm">
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