<?php

namespace app\core;

use Exception;

class MethodExtract
{
  public static function extract(string $controller, string $method): string
  {
    if(!method_exists($controller, $method))
    {
      throw new Exception("Method {$method} not defined in {$controller}");
    }

    return $method;
  }
}
