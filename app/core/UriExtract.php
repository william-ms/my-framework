<?php

namespace app\core;

class UriExtract
{
  public static function extract(): string
  {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    return $uri;
  }
}
