<?php

namespace App\Traits;

trait SuccessRedirectMessage
{
  public function successRedirect
  (
    string $route,
    array $msg
  )
  {
    return redirect()->route($route)->with($msg)->withInput();
  }
}