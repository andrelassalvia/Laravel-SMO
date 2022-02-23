@extends('layouts.base')

@section('content')
    <x-admin.title-component :title="'Administração de Tipos de Usuários'"></x-admin.title-component>

    <x-admin.form-name-component :data="$table" :blade="'create'" :group="''">
      <x-slot name="tabs"></x-slot>
      <x-slot name="delete"></x-slot>
      <x-slot name="form2"></x-slot>
      <x-slot name="form3"></x-slot>

      <x-slot name="button">
        <x-admin.save-button-component></x-admin.save-button-component>
      </x-slot>

    </x-admin.form-name-component>

    @include('admin._components.alertErrors')

    <x-admin.back-button-component :model="$table"></x-admin.back-button-component>


@endsection