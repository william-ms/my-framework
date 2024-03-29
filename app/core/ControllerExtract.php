<?php

namespace app\core;

use app\library\controllers\Controller;
use Exception;

class ControllerExtract
{
  public static function extract(string $controller): string
  {
    if(!class_exists($controller))
    {
      throw new Exception("Controller {$controller} not found");
    }

    if(!in_array(Controller::class, class_parents($controller)))
    {
      throw new Exception("Controller {$controller} does not extend the Controller class");
    }

    return $controller;
  }
}
