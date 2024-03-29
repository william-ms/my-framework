<?php

namespace app\library\views;

use Exception;

class Section
{
  private static string $section;
  private static array $sections;

  public static function start(string $section)
  {
    if($section === 'content')
    {
      throw new Exception("Unable to create a new content section");
    }

    self::$section = $section;

    ob_start();
  }

  public static function end()
  {
    (isset(self::$sections[self::$section]))
    ? self::$sections[self::$section] .= ob_get_contents()
    : self::$sections[self::$section] = ob_get_contents();

    ob_end_clean();
  }

  public static function set(string $section, string $content)
  {
    self::$sections[$section] = $content;
  }

  public static function get(string $section)
  {
    if(!isset(self::$sections[$section]))
    {
      throw new Exception("Section {$section} not defined");
    }

    return self::$sections[$section];
  }
}
