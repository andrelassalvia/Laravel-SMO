<?php

namespace App\Traits;

trait SuccessRedirectMessage
{
  public function successRedirect(
    string $route,
    array $msg,
    string $id
  )
  {
    return redirect()
    ->route($route, $id)
    ->with($msg)
    ->withInput();
  }
}