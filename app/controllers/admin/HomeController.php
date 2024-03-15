<?php

namespace app\controllers\admin;

use app\library\controllers\Controller;

class HomeController extends Controller
{
  public function index(array $args)
  {
    echo "<h2>admin home</h2>";
  }
}