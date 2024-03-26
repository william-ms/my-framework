<?php

namespace app\library\validate;

use app\interfaces\validate\ValidateInterface;
use app\library\helpers\Flash;
use app\library\helpers\Old;

class ValidateEmail implements ValidateInterface
{
  /**
   * @param string $field Email input field name
   * @param array $params Options to validate the email
   */
  public function handle(string $field, array $params): bool
  {
    $value = $_POST[$field];

    if(!filter_var($value, FILTER_VALIDATE_EMAIL))
    {
      Flash::set($field, "Email invalid");
      Old::set($field, $value);
      return false;
    }

    Old::set($field, $value);
    return true;
  }
}
