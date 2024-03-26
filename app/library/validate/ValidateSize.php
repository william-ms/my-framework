<?php

namespace app\library\validate;

use app\interfaces\validate\ValidateInterface;
use app\library\helpers\Flash;
use app\library\helpers\Old;

class ValidateSize implements ValidateInterface
{
  /**
   * @param string $field Input field name
   * @param array $params Options to validate input value
   */
  public function handle(string $field, array $params): bool
  {
    $value = $_POST[$field];

    if($params['min'] && strlen($value) < $params['min'])
    {
      Flash::set($field, "Field can not have less {$params['min']} characters");
      return false;
    }

    if($params['max'] && strlen($value) > $params['max'])
    {
      Flash::set($field, "Field can not have more than {$params['max']}");
      return false;
    }

    Old::set($field, $value);
    return true;
  }
}
