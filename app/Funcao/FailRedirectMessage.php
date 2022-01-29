<?php

namespace App\Funcao;


class FailRedirectMessage
{
  public static function failRedirect(string $route, array $msg)
  {
    return redirect()->route($route)->withErrors($msg)->withInput();
  }
}