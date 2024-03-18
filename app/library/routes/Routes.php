<?php

namespace app\library\routes;

class Routes
{
  protected static array $routes = [];

  public static function routes($uri, $route)
  {
    self::$routes[$route->type][$uri] = $route;
  }

  public static function getRoutes()
  {
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    return self::$routes[strtolower($requestMethod)];
  }
}
