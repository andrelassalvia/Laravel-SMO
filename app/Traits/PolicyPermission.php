<?php

namespace App\Traits;

use App\Models\Permissao;
use Illuminate\Auth\Access\Response;

trait PolicyPermission
{
  public function permission(
    Object $user, // model $user
    string $formulario_id, // formulario we are looking for ($id)
    string $act // 'exclui' or 'altera' or 'inclui'
  )
  {
    $userType = $user['tipousuario_id'];
    
    $permissao = Permissao::where('tipousuario_id', $userType)
        ->where('formulario_id', $formulario_id)
        ->get()
        ->first();
    if($permissao && $permissao[$act] == '1'){
        return Response::allow();
    } else {
        return Response::deny('Usuário não pode '.$act.'r registros');
    } 
  }
}