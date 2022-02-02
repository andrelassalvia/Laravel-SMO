<?php

namespace App\Traits;

trait FailRedirectMessage
{
  public function failRedirect(string $route, array $msg, $id)
  {
    return redirect()->route($route, $id)->withErrors($msg)->withInput();
  }
}