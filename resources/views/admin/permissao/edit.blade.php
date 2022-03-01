@extends('layouts.base')

@section('content')
    <div class="conteudo">
      
      
      <x-admin.title-component :title="'Administração de Permissões'"></x-admin.title-component>

      <x-forms.basic-form :data="$permissao" :blade="'edit'" :group="''">
        <x-slot name="tabs"></x-slot>
        <x-slot name="delete"></x-slot>
        <x-slot name="form">
          

          <div style="display:grid; row-gap:5%">

            <x-forms.disabled-input :blade="'edit'" :data="$data"></x-forms.disabled-input>
            <x-forms.disabled-input :blade="'edit'" :data="$formularios"></x-forms.disabled-input>
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
          </div>

          
        </x-slot>

        <x-slot name="button">
          <x-buttons.save-button></x-buttons.save-button>
        </x-slot>
      </x-forms.basic-form>


      
      

      
      
      @include('admin._components.alertErrors')
     
      @include('admin._components.alertSuccess')

     
      <div class="container">
        <table class="table table-hover table-sm mt-3" style="width: 70%; margin:auto">
          <thead>
            <tr>
              <th scope="col">Formulario</th>
              <th scope="col">Inclui</th>
              <th scope="col">Altera</th>
              <th scope="col">Exclui</th>
            </tr>
          </thead>
          <tbody>
            
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
            </tr>
          </tbody>
        </table>
        
          <x-admin.back-button-component :model="$data"></x-admin.back-button-component>
        
      </div>
    </div>

@endsection