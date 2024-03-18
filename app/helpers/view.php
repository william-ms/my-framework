<?php

use app\core\View;

function view(string $view, ?array $data = null): View
{
  return new View($view, $data);
}

function extract_view(string $view)
{
  $folder = '';

  if(preg_match('/[.\/]/', $view))
  {
    [$folder, $view] = extract_folder($view);
  }

  return (file_exists(VIEW_PATH. $folder . $view .'.php'))
  ? $folder . $view
  : throw new Exception("View '{$view}' not found in 'app/views/{$folder}'");
}

function extract_folder($path)
{
  $array = preg_split('/[.\/]/', $path);
  $arrayCount = count($array);
  
  $file = $array[$arrayCount-1];
  $folder = '';

  for($i = 0; $i < $arrayCount-1; $i++)
  {
    $folder = $folder . $array[$i] . '/';

    if(!is_dir(VIEW_PATH.$folder))
    {
      throw new Exception ("Folder {$array[$i]} not found in app/views/");
    }
  }

  return [$folder, $file];
}

function include_view()
{
  extract(View::getData());
  return require_once(VIEW_PATH. View::getView() .'.php');
}

function include_partial(string $partial)
{
  [$folder, $partial] = extract_folder($partial);

  if(!is_dir(VIEW_PATH. $folder .'/partials'))
  {
    throw new Exception("Partials folder not fount in app/views/{$folder}");
  }

  if(!file_exists(VIEW_PATH. $folder .'partials/'. $partial .'.php'))
  {
    throw new Exception("Partial '{$partial}' not fount in app/views/{$folder}partials");
  }

  extract(View::getData());
  return require_once(VIEW_PATH. $folder .'partials/'. $partial .'.php');
}