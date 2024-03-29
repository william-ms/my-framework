<?php

namespace app\core;

use app\library\routes\Routes;
use Exception;

class RouteExtract
{
  public static function extract(string $uri): object
  {
    $routes = Routes::get_routes();

    $route = self::static_route($uri, $routes);

    if(empty($route))
    {
      $route = self::dynamic_route($uri, $routes);
    }

    return ($route)
    ? $route
    : throw new Exception("Route {$uri} not defined");
  }

  private static function static_route(string $uri, array $routes)
  {
    if(array_key_exists($uri, $routes))
    {
      return $routes[$uri];
    }
  }

  private static function dynamic_route(string $uri, array $routes)
  {
    foreach($routes as $key => $route)
    {
      $regex = str_replace('/', '\/', ltrim($key, '/'));

      if(preg_match("/^$regex$/", ltrim($uri, '/')))
      {
        return $route;
      }
    }
  }
}
