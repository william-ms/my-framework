<?php

namespace app\library\sanitize;

class Sanitize
{
  protected static array $data = [];

  /**
   * @param array $fields Fields to be sanitized
   * @return object
   */
  public static function handle(array $fields = []): object
  {
    if(empty($fields))
    {
      $values = $_POST;

      foreach( $values as $field => $value)
      {
        static::$data[$field] = trim(strip_tags($value));
      }
    }
    else
    {
      foreach($fields as $field)
      {
        static::$data[$field] = trim(strip_tags($_POST[$field]));
      }
    }

    return new static;
  }

  public function all(): array
  {
    return static::$data;
  }

  public function get(string $field): mixed
  {
    return static::$data[$field];
  }
}