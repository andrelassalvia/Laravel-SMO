<?php

namespace App\Funcao;

class SuccessRedirectMessage
{
  public static function successRedirect(string $route, array $msg)
  {
    return redirect()->route($route)->with($msg)->withInput();
  }
}
