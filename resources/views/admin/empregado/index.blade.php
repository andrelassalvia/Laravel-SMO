@extends('layouts.base')

@section('content')
  <div class="conteudo">
    <x-admin.title-component :title="'Administração de Empregados'"></x-admin.title-component>
      <div class="form-search-add">
        <div>
          <form 
            method="get" 
            class="input-group" 
            action="{{url('http://localhost:8000/empregados/search')}}"
            >
            
            <input 
            type="text" 
            class="form-control" 
            name="nome" 
            placeholder="Procurar empregado" 
            >
            <button class="btn btn-primary">
              <i class="bi bi-search" aria-hidden="true"></i>
            </button>
          </form>
        </div>
      </div>
        <x-admin.add-register
          :table="'empregados'"
          :title="'Cadastrar empregado'">
        </x-admin.add-register>
      </div>
      @include('admin._components.alertSuccess')
      <div>
        <table class="table table-hover" style="width: 80%; margin:auto">
          <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Função</th>
            <th>Grupo</th>
            <th width="100">Ações</th>
          </tr>
          @foreach ($data as $item)
          <tr>
            <td>{{$item->nome}}</td>
            <td>{{$item->cpf}}</td>
            <td>{{$item->funcao->nome}}</td>
            <td>{{$item->grupo->nome}}</td>
            <td> 
              <a href="{{route('empregados.edit', $item)}}" class="btn btn-primary btn-sm">
                <i class="bi bi-pen" aria-hidden="true"></i>
              </a>
            </td>
          </tr>
              
          @endforeach
        </table>
      </div>
      @include('admin._components.pagination')
  </div>
@endsection