<?php

use app\library\helpers\Flash;

function flash(string $field, ?string $alert = 'danger')
{
  $flash = Flash::get($field);

  if(isset($flash))
  {
    $flash['alert'] = $alert;
    return Flash::make_component($flash);
  }
}