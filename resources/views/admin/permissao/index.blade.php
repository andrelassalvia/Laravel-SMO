@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Tipos de Usuários - Permissões</h2>
    </div>
    
    <form class=" method="POST" action="{{ route('permissao.store', $data->id) }}">
        <div class="aba">
            <ul class="nav nav-tabs" style="margin-bottom: 10px; margin-top: -10px;">
                <li><a href="{{route('tipousuario.edit', $data->id)}}">Tipo Usuário</a></li>
                <li class="active"><a href="{{route('permissao.index', $data->id)}}" style="cursor: pointer;">Permissões</a></li>
            </ul>
        </div>
        <div class="form1">   
        
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row mb-2">
                <label class="control-label col-sm-2" for="nome">Tipo Usuário:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ $data->nome }}">
              </div>
            </div>  
        
        </div> 

        <div class="form3">
            <div class="row mb-2">
                <label class="control-label col-sm-2" for="formulario_id">Formulário:</label>
              <div class="col-sm-8">
                    <select class="form-select" name="formulario_id">
                        <option value="">Selecione</option>
                        @foreach($formularios as $formulario)
                            <option value="{{$formulario->id}}">{{$formulario->nome}}</option>
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="row mb-2">
                <label class="control-label col-sm-2" for="inclui">Permissoes:</label>
                <div class="col-sm-2 mt-2">
                    <input type="checkbox" name="inclui"> Inclui                     
                </div>
            </div>

            <div class="row mb-2">
                <label class="control-label col-sm-2" for="altera"></label>
                <div class="col-sm-2">
                    <input type="checkbox" name="altera"> Altera                    
                </div>
            </div>

            <div class="row mb-2">
                <label class="control-label col-sm-2" for="exclui"></label>
                <div class="col-sm-2">
                    <input type="checkbox" name="exclui"> Exclui                    
                </div>
            </div>

            <div class="form-central" style="margin-top: 35px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
                  </button>
                </div>
            </div>  
        </div>
         
    </form>
    @if ( isset($errors) && count($errors) > 0) 
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
    @endif
    <br><br><br>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Formulário</th>
            <th>INCLUI</th>
            <th>ALTERA</th>
            <th>EXCLUI</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($permissoes as $permissao) 
        <tr>
            <td>{{ $permissao->formulario['nome'] }}</td>  
            @if($permissao->inclui==1)
                <td>
                    <input type="checkbox" checked id="inc">
                </td>
            @else
                <td>
                    <input type="checkbox" id="inc">
                </td>                
            @endif 
            @if($permissao->altera==1)
                <td>
                    <input type="checkbox" checked id="alt">
                </td>
            @else
                <td>
                    <input type="checkbox" id="alt">
                </td>                
            @endif 
            @if($permissao->exclui==1)
                <td>
                    <input type="checkbox" checked id="exc">
                </td>
            @else
                <td>
                    <input type="checkbox" id="exc">
                </td>                
            @endif 
            <td width="100">  
                <a href="{{route('permissao.edit', $permissao->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                  <i class="bi bi-pen" aria-hidden="true"></i>
                </a>                 
            </td>

        </tr>

        @endforeach

    </table>
    
</div> 
@endsection