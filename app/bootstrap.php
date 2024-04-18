<?php

require_once('../vendor/autoload.php');

session_start();

use app\core\App;

try
{
  $app = new App();
  $app->route();
  $app->controller();
}
catch(Throwable $throw)
{
  echo formatException($throw);
}