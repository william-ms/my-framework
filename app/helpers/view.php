<?php

use app\library\views\View;

function view(string $view, ?array $data = [])
{
  echo (new View($view, $data))->render();
}