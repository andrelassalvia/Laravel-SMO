<!DOCTYPE html >
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema de Gerenciamento Ocupacional</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
    <link rel="stylesheet" href="{{URL::asset('css/estilos.css')}}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>
<body>
     <!-- Session Status -->
     <x-auth-session-status class="mb-4" :status="session('status')" />

     <!-- Validation Errors -->
     <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="container-fluid">
        <div id="corpo">
            <div id="title">Sistema de Medicina Ocupacional</div>
            <form  method="POST" action="{{route('login')}}">
                @csrf
                <div class="form-group row">
                    <label class="control-label col-sm-3" for="email" >Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" autofocus autocomplete="email" required name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-3" for="password" >Senha</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" autofocus autocomplete="current-password" required name="password">
                    </div>
                </div>
                <input type="submit" value="Entrar" class="btn btn-primary">
            </form>
        </div>
    </div>
    
   
</body>
</html>