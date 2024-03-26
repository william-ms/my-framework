<?php

namespace app\library\validate;

use app\library\helpers\Flash;
use app\library\helpers\Old;
use app\interfaces\validate\ValidateInterface;

class ValidateRequired implements ValidateInterface
{
  /**
   * @param string $field Input field name
   * @param array $params Options to validate input value
   */
  public function handle(string $field, array $params): bool
  {
    if(!isset($_POST[$field]))
    {
      Flash::set($field, "Select at least one {$field}");
      return false;
    }

    $value = $_POST[$field];

    if($value === '')
    {
      Flash::set($field, "The {$field} field is required");
      return false;
    }

    Old::set($field, $value);
    return true;
  }
}