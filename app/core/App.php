<?php

namespace app\core;

class App
{
  private string $uri;
  private object $route;

  public function __construct()
  {
    require_once('../config/'. $_ENV['ENVIRONMENT'] .'.php');
  }

  public function route()
  {
    $this->uri = UriExtract::extract();
    $this->route = RouteExtract::extract($this->uri);
  }

  public function controller()
  {
    $controller = ControllerExtract::extract($this->route->controller);
    $method = MethodExtract::extract($controller, $this->route->method);
    $params = ParamsExtract::extract($this->uri, $this->route->uri);

    return (new $controller)->$method($params);
  }
}
