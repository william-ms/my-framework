<?php

namespace app\library\validate;

use app\database\connection\Connection;
use app\interfaces\validate\ValidateInterface;
use app\library\helpers\Flash;
use app\library\helpers\Old;

class ValidateUnique implements ValidateInterface
{
  /**
   * @param string $field Input field name
   * @param array $params Options to validate input value
   */
  public function handle(string $field, array $params): bool
  {
    $value = $_POST[$field];

    if(!isset($parmas['field']))
    {
      $params['field'] = $field;
    }

    $connection = Connection::connect();
    $query = "select {$params['field']} from {$params['table']} where {$params['field']} = :{$params['field']}";
    $prepare = $connection->prepare($query);
    $prepare->execute([$params['field'] => $value]);

    if($prepare->rowCount() > 0)
    {
      Flash::set($field, "This {$field} is already registered");
      // Old::set($field, $value);
      return false;
    }

    Old::set($field, $value);
    return true;
  }
}
