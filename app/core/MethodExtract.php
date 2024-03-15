<?php

namespace app\core;

class MethodExtract
{
  public static function extract(string $controller, string $method): string
  {
    if(method_exists($controller, $method))
    {
      return $method;
    }

    return throw new \Exception("Method {$method} not defined in {$controller}");
  }
}
