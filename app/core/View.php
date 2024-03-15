<?php

namespace app\core;

class View
{
  protected static string $view;
  protected static array $data;
  protected string $extends;

  public function __construct(string $view, ?array $data = null)
  {
    self::$view = $view;
    ($data) ? self::$data = $data : self::$data = [];
  }

  public function view()
  {
    self::$view = extract_view(self::$view);
    extract(self::$data);

    return (isset($this->extends))
    ? require_once(VIEW_PATH. $this->extends .'.php')
    : require_once(VIEW_PATH. self::$view .'.php');
  }

  public function extends(string $extends)
  {
    $this->extends = extract_view($extends);
    return $this;
  }

  public static function getView()
  {
    return self::$view;
  }

  public static function getData()
  {
    return self::$data;
  }
}