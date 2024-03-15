<?php

namespace app\library\router;

class Route
{
  public $type;
  public $uri;
  public $controller;
  public $method;
  public $name;

  public function __construct($type, $uri, $controller)
  {
    $this->type = $type;
    $this->uri = $uri;
    $this->controller = $controller[0];
    $this->method = $controller[1];

    Routes::routes($this->uri, $this);
  }

  public static function get($uri, $controller)
  {
    return new Route('get', $uri, $controller);
  }

  public static function post($uri, $controller)
  {
    return new Route('post', $uri, $controller);
  }

  public static function put($uri, $controller)
  {
    return new Route('put', $uri, $controller);
  }

  public static function delete($uri, $controller)
  {
    return new Route('delete', $uri, $controller);
  }

  public function name($name)
  {
    $this->name = $name;
    return $this;
  }
}