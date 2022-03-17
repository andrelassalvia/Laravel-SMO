@extends('layouts.base')

@section('content')
  <div class="conteudo">

    <x-admin.title-component 
      :title="'Cadastramento de Empregados'">
    </x-admin.title-component>
    <div class="ms-3">
      <a class="btn btn-link" href="{{route('empregados.index')}}">Voltar</a>
    </div>
    <form 
      name="personForm"
      id="personForm"
      action="{{route('empregados.store')}}"
      method="POST" 
    >
      @csrf
      <div class="form2" style="margin-bottom:0">
        <div class="row mb-2 ms-2 justify-content-start">
          <label for="nome" class="col-sm-1 col-form-label">
            Nome:
          </label>
          <div class="col-sm-10">
            <input type="text" name="nome" class="form-control" value="{{old('nome')}}">
          </div>
        </div>
        <div class="row mb-2 ms-2 justify-content-start">
          <label for="cpf" class="col-sm-1 col-form-label">
            CPF:
          </label>
          <div class="col-sm-10">
            <input type="text" name="cpf" id="cpf" class="form-control" value="{{old('cpf')}}">
          </div>
        </div>
      </div>
      <div class="form1 d-flex justify-content-center" style="margin:0 auto; padding-top:0">
        <div class="row ms-2">
          <label for="ctps" class="col-sm-1 col-form-label">CTPS:</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="ctps" value="{{old('ctps')}}">
          </div>
          <label for="serie" class="col-sm-1 col-form-label">Serie:</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="serie" value="{{old('serie')}}">
          </div>
        </div>
      </div>
      <div class="form6" style="margin: 0 auto; padding-top:0">
        <div class="row mb-2 justify-content-start">
          <label for="data_nascimento" class="col-sm-3 col-form-label">
            Data de Nascimento:
          </label>
          <div class="col-sm-6">
            <input 
              type="date" 
              name="data_nascimento" 
              class="form-control" 
              value="{{old('data_nascimento')}}">
          </div>
        </div>
        <div class="row mb-2 justify-content-start">
          <label for="data_admissao" class="col-sm-3 col-form-label">
            Data de Admissão:
          </label>
          <div class="col-sm-6">
            <input 
              type="date" 
              name="data_admissao" 
              class="form-control" 
              value="{{old('data_admissao')}}">
          </div>
        </div>
        <div class="row mb-2 justify-content-start">
          <label for="data_demissao" class="col-sm-3 col-form-label">
            Data de Demissão:
          </label>
          <div class="col-sm-6">
            <input 
              type="date" 
              name="data_demissao" 
              class="form-control" 
              value="{{old('data_demissao')}}">
          </div>
        </div>
        <div class="row ms-2 mb-2">
          <label for="setor_id" class="col-sm-1 col-form-label">Setor:</label>
          <div class="col-sm-8">
            <select name="setor_id" id="setor_id" class="form-select">
              <option value="0">Selecione</option>
              @foreach ($setor as $item)
                  <option 
                  value="{{$item->id}}" {{old('setor_id') == $item->id ? 'selected': ''}}
                  >
                  {{$item->nome}}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row ms-2 mb-2">
          <label for="funcao_id" class="col-sm-1 col-form-label">Função:</label>
          <div class="col-sm-8">
            <select name="funcao_id" id="funcao_id" class="form-select">
              <option value="">Selecione</option>
            </select>
          </div>
        </div>
        <div class="row ms-2 mb-2">
          <label for="grupo_id"  class="col-sm-1 col-form-label">Grupo:</label>
          <div class="col-sm-8">
            <select name="grupo_id" id="grupo_id" class="form-select">
              <option value="">Selecione</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row mt-2 text-center">
        <div class="container justify-content-center">
          <x-admin.save-button-component></x-admin.save-button-component>
        </div>
      </div>
    </form>
    @include('admin._components.alertErrors')
  </div>

  <script type="text/javascript">
     $(document).ready(function(){
      
      $('#setor_id').change(function(){
        var setorId = $(this).val(); 
        
        // empty the dropdown
        $('#funcao_id').find("option").not(":first").remove();

        // AJAX 
        $.ajax({
           url: "http://localhost:8000/empregados/load_funcoes/"+setorId,
           type: "get",
           dataType: "json",
           success: function(response){

             var len = 0;
             if(response !=null){
               len = response.length;
             }
             if(len>0){
               for (let i = 0; i < len; i++) {
                 var id = response[i].id;
                 var name = response[i].nome;
                 var option = "<option value='"+id+"'>"+name+"</option>";

                 $('#funcao_id').append(option);
               }
             }
           }
        });

        $('#funcao_id').change(function(){
          var funcaoId = $(this).val();
          var setorId = $('#setor_id').val();
          
          // empty dropdown
          $('#grupo_id').find('option').not(':first').remove();

          // AJAX
          $.ajax({
            url: "http://localhost:8000/empregados/load_grupos/"+setorId+'/'+funcaoId,
            type:'GET',
            dataType:'json',
            success: function(response){
              if(response !=null){
                if(response.length > 0){
                  for (let i = 0; i < response.length; i++) {
                    const element = response[i];
                    var id = element.id;
                    var name = element.nome;
                    var option = "<option value='"+id+"'>"+name+"</option>"
                    $('#grupo_id').append(option);
                  }
                }
              }
            }
          });
        });
      });
    });
  </script>
    
@endsection