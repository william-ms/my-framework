<?php

namespace app\core;

class ParamsExtract
{
  public static function extract(string $uri, string $routeUri): array
  {
    $uri = explode('/', ltrim($uri, '/'));
    $routeUri = explode('/', ltrim($routeUri, '/'));
    $params = [];
    $paramsDiff = array_diff($uri, $routeUri);

    foreach($paramsDiff as $key => $value)
    {
      $params[$uri[$key - 1]] = $value;
    }

    return $params;
  }
}
