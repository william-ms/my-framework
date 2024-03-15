<?php

namespace app\core;

use app\router\Router;
use app\library\router\Routes;

class RouteExtract
{
  public static function extract(string $uri): object
  {
    Router::routes();

    $routes = Routes::getRoutes();

    $route = self::staticRoute($uri, $routes);

    if(empty($route))
    {
      $route = self::dynamicRoute($uri, $routes);
    }

    return ($route)
    ? $route
    : throw new \Exception("Route {$uri} not defined");
  }

  private static function staticRoute(string $uri, array $routes)
  {
    if(array_key_exists($uri, $routes))
    {
      return $routes[$uri];
    }
  }

  private static function dynamicRoute(string $uri, array $routes)
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
