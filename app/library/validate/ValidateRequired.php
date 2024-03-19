<?php

namespace app\library\validate;

use app\library\helpers\Flash;
use app\library\helpers\Old;
use app\interfaces\validate\ValidateInterface;

class ValidateRequired implements ValidateInterface
{
  public function handle($field, $param)
  {
    $string = filter_input(INPUT_POST, $field, FILTER_UNSAFE_RAW);

    if ($string === '')
    {
      Flash::set($field, "The {$field} field is required");
      return false;
    }

    Old::set($field, $string);

    return $string;
  }
}