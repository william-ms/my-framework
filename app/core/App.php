<?php

namespace app\core;

class App
{
  public function controller()
  {
    $uri = UriExtract::extract();
    $route = RouteExtract::extract($uri);

    $controller = ControllerExtract::extract($route->controller);
    $method = MethodExtract::extract($controller, $route->method);
    $params = ParamsExtract::extract($uri, $route->uri);

    return (new $controller)->$method($params);
  }
}
