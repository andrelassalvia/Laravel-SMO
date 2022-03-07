@extends('layouts.base')

@section('content')

<div class="conteudo">
  <x-admin.title-component :title="'Administração de Usuários'" ></x-admin.title-component>
  <div class="form-search-add">
    <form 
      class="input-group" 
      style="width: 20%"  
      method="get" 
      action="{{ route('users.search') }}"
    >   
      <input class="form-control" type="text" name="name" placeholder="Nome do Usuário"> 
      <button class="btn btn-primary">
        <i class="bi bi-search" aria-hidden="true"></i>
      </button>
    </form>
    <div class="btn btn-primary" style="margin-left: 20px;">
      <a href="{{ route('users.create') }}" style="color: #FFF;">   
        <i class="bi bi-plus-lg" style="color: #fff"> Cadastrar Usuário</i>
      </a>
    </div> 
  </div>
 
  <table class="table table-striped table-hover mb-3" style="width: 80%; margin:auto">
    <tr>
      <th>Nome</th>
      <th>Email</th>
      <th>Status</th>
      <th width="100">Ação</th>
    </tr>
    @foreach ($data as $item)
      <tr>
        <td>{{$item->name}}</td>
        <td>{{$item->email}}</td>
        @if ($item->status == 1)
          <td>
              Ativo
          </td>
        @else
          <td>
            Inativo
          </td>
        @endif
        <td>
          <a href="{{route('users.edit',$item->id)}}" class="btn btn-primary btn-sm">
            <i class="bi bi-pen" aria-hidden="true"></i>
        </a>
        </td>
      </tr>
    @endforeach
  </table>
  @include('admin._components.pagination')
</div>
@include('admin._components.alertSuccess')
@endsection