<?php

namespace app\library\helpers;

class Old
{
  public static function set($key, $value)
  {
    if($key === 'password')
    {
      return;
    }

    if(!isset($_SESSION['__old'][$key]))
    {
      $_SESSION['__old'][$key] = $value;
    }
  }

  public static function get($key)
  {
    if(isset($_SESSION['__old'][$key]))
    {
      $flash = $_SESSION['__old'][$key];
      unset($_SESSION['__old'][$key]);

      return $flash;
    }
  }
}