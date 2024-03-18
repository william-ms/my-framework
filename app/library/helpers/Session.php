<?php

namespace app\library\helpers;

class Session
{
  public static function set(string $index, mixed $value)
  { 
    return $_SESSION[$index] = $value;
  }

  public static function has(string $index)
  {
    return isset($_SESSION[$index]);
  }

  public static function get(string $index)
  {
    if (self::has($index))
    {
      return $_SESSION[$index];
    }
  }

  public static function remove(string $index)
  {
    if (self::has($index))
    {
      unset($_SESSION[$index]);
    }
  }

  public static function remove_all()
  {
    return session_destroy();
  }

  public static function dump(string $index = "")
  {
    if($index)
    {
      var_dump($_SESSION[$index]);
      die();
    }

    var_dump($_SESSION);
    die();
  }
}