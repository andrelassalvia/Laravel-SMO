<?php

namespace App\Traits;

trait FailRedirectMessage
{
  public function failRedirect(
    string $route, // route em fail case
    array $msg, // error message in fail case
    $id
  )
  {
    return redirect()->route($route, $id)->withErrors($msg)->withInput();
  }
}