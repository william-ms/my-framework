<?php

use app\core\View;
use app\interfaces\core\ViewInterface;

function view(string $view, ?array $data = null): ViewInterface
{
  return new View($view, $data);
}

function include_view()
{
  extract(View::$data);
  return require_once(VIEW_PATH. View::$view .'.php');
}

function include_partial(string $partial)
{
  [$folder, $partial] = extract_folder($partial, 'view');

  if(!is_dir(VIEW_PATH. $folder .'/partials'))
  {
    throw new Exception("Partials folder not fount in app/views/{$folder}");
  }

  if(!file_exists(VIEW_PATH. $folder .'partials/'. $partial .'.php'))
  {
    throw new Exception("Partial '{$partial}' not fount in app/views/{$folder}partials");
  }

  extract(View::$data);
  return require_once(VIEW_PATH. $folder .'partials/'. $partial .'.php');
}

function include_css()
{
  if(isset(View::$css))
  {
    $cssList = View::$css;

    foreach($cssList as $css)
    {
      echo "<link rel='stylesheet' href='{$css}' />";
    } 
  }
}

function include_scripts()
{
  if(isset(View::$scripts))
  {
    $scripts = View::$scripts;

    foreach($scripts as $script)
    {
      echo "<script src='{$script}'></script>";
    }
  }
}