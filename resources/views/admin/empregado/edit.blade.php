@extends('layouts.base')

@section('content')
    <div class="conteudo">
      <x-admin.title-component
        :title="'Alteração de Empregados'">
      </x-admin.title-component>
      <div class="mb-3 ms-3">
        <a href="{{route('empregados.index')}}" class="btn btn-link">Voltar</a>
      </div>
      <form action="{{route('empregados.update', $data->id)}}" method="POST">
        @csrf
        <div class="container p-3" style="background-color: #ebf3fa">
          <div class="row mb-2">
            <label for="" class="col-md-1 form-label text-start text-md-end">Nome:</label>
            <div class="col-md-11">
              <input type="text" name="nome" class="form-control" value="{{$data->nome}}">
            </div>
          </div>
          <div class="row mb-3">
            <label for="" class="col-md-1 col-form-label text-start text-md-end">CPF: </label>
            <div class="col-md-3 col-12">
              <input type="text" name="cpf" class="col-12 form-control" value="{{$data->cpf}}">
            </div>
            <label for="" class="col-md-1 col-form-label text-start text-md-end">CTPS: </label>
            <div class="col-md-3 col-12">
              <input type="text" name="ctps" class="col-12 col-12 form-control" value="{{$data->ctps}}">
            </div>
            <label for="" class="col-md-1 col-form-label text-start text-md-end">Serie: </label>
            <div class="col-md-3 col-12">
              <input type="text" name="serie" class="col-12 col-12 form-control" value="{{$data->serie}}">
            </div>
          </div>
          <div class="row mb-2">
            <label for="" class="form-label text-start col-xl-2 text-xl-end">Data de Nascimento:</label>
            <div class="col-md-7 offset-md-1 col-xl-6 offset-xl-0">
              <input type="date" name="data_nascimento" class="form-control" value="{{$data->data_nascimento}}">
            </div>
          </div>
          <div class="row mb-2">
            <label for="" class="form-label text-start col-xl-2 text-xl-end">Data de Admissão:</label>
            <div class="col-md-7 offset-md-1 col-xl-6 offset-xl-0">
              <input type="date" name="data_admissao" class="form-control" value="{{$data->data_admissao}}">
            </div>
          </div>
          <div class="row mb-3">
            <label for="" class="form-label text-start col-xl-2 text-xl-end">Data de Demissão:</label>
            <div class="col-md-7 offset-md-1 col-xl-6 offset-xl-0">
              <input type="date" name="data_demissao" class="form-control" value="{{$data->data_demissao}}">
            </div>
          </div>
          <div class="row mb-2">
            <label for="" class="form-label text-start col-md-1">Setor:</label>
            <div class="col-md-7">
              <select name="setor_id" id="setor_id" class="form-select">
                <option value="{{$data->setor->id}}">{{$data->setor->nome}}</option>
                @foreach ($setores as $item)
                    <option value="{{$item->id}}">{{$item->nome}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <label for="" class="form-label text-start col-md-1">Função:</label>
            <div class="col-md-7">
              <select name="funcao_id" id="funcao_id" class="form-select">
                <option value="{{$data->funcao->id}}">{{$data->funcao->nome}}</option>
              </select>            
            </div>
          </div>
          <div class="row mb-3">
            <label for="" class="form-label text-start col-md-1">Grupo:</label>
            <div class="col-md-7">
              <select name="grupo_id" id="grupo_id" class="form-select">
                <option value="{{$data->grupo->id}}">{{$data->grupo->nome}}</option>
              </select>
            </div>
          </div>
          <div class="row">
              <x-admin.save-button-component></x-admin.save-button-component>
          </div>
        </div>        
      </form>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#setor_id').change(function(){
          let setorId = $(this).val();
          $('#funcao_id').find('option').remove();
          
          $.ajax({
            url:"http://localhost:8000/empregados/load_funcoes/"+setorId,
            success: function(response){
              for (let i = 0; i < response.length; i++) {
                const element = response[i];
                let id = element.id;
                let name = element.nome;                
                let option = "<option value='"+id+"'>"+name+"</option>";
                $('#funcao_id').append(option);                
              }              
            }
          });
          $('#funcao_id').change(function(){
            let setorId = $('#setor_id').val();
            let funcaoId = $(this).val();
            $('#grupo_id').find('option').remove();
            $.ajax({
              url:"http://localhost:8000/empregados/load_grupos/"+setorId+"/"+funcaoId,
              success:function(response){
                for (let i = 0; i < response.length; i++) {
                  const element = response[i];
                  let id = element.id;
                  let name = element.nome;
                  let option = "<option value='"+id+"'>"+name+"</option>"
                  $('#grupo_id').append(option);
                }                
              },
            });
          });
        });
      });
    </script>
@endsection