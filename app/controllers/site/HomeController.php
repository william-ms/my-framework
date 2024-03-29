<?php

namespace app\controllers\site;

use app\library\controllers\Controller;

class HomeController extends Controller
{
  public function index(array $args)
  {
    return view('site.home', [
      'title' => 'Home',
    ]);
  }
}