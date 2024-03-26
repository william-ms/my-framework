<?php

namespace app\core;

use app\interfaces\core\ViewInterface;

class View implements ViewInterface
{
  public static string $view;
  public static array $data;
  public static array $css;
  public static array $scripts;
  protected string $extends;

  public function __construct(string $view, ?array $data = null)
  {
    self::$view = $view;
    ($data) ? self::$data = $data : self::$data = [];
  }

  public function view()
  {
    self::$view = extract_file(self::$view, 'view', true);
    extract(self::$data);

    return (isset($this->extends))
    ? require_once(VIEW_PATH. $this->extends .'.php')
    : require_once(VIEW_PATH. self::$view .'.php');
  }

  public function extends(string $extends)
  {
    $this->extends = extract_file($extends, 'view', true);
    return $this;
  }

  public function css(string|array $cssList)
  {
    if(is_array($cssList))
    {
      foreach($cssList as $css)
      {
        $css = extract_file($css, 'css', true);
        self::$css[] = '/assets/css/' . $css . '.css';
      }
    }
    else
    {
      self::$css[] = '/assets/css/'. extract_file($cssList, 'css', true) . '.css';
    }

    return $this;
  }

  public function scripts(string|array $scripts)
  {
    if(is_array($scripts))
    {
      foreach($scripts as $script)
      {
        self::$scripts[] = '/assets/js/' . extract_file($script, 'js', true) . '.js';
      }
    }
    else
    {
      self::$scripts[] = '/assets/js/' . extract_file($scripts, 'js', true) . '.js';
    }

    return $this;
  }
}