<?php

namespace app\core;

class ControllerExtract
{
  public static function extract(string $controller): string
  {
    if(class_exists($controller))
    {
      return $controller;
    }
    
    return throw new \Exception("Controller {$controller} not found");
  }
}
