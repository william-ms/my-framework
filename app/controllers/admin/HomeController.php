<?php

namespace app\controllers\admin;

use app\library\controllers\Controller;

class HomeController extends Controller
{
  public function index(array $args)
  {
    return view('admin.home', [
      'title' => 'Home'
    ]);
  }
}