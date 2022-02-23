@extends('layouts.base')

@section('content')
    <x-admin.title-component :title="'Administração de Tipos de Usuários'"></x-admin.title-component>

    <x-admin.add-register 
      :table="$table" 
      :title="'Cadastrar tipo de usuário'">
    </x-admin.add-register>
    <x-admin.list-component :data="$data" :column="'Tipo de Usuário'"></x-admin.list-component>

    @include('admin._components.alertSuccess')

@endsection