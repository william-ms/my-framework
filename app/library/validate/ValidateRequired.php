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
  public function handle(string $field, array $params)
  {
    if(!isset($_POST[$field]))
    {
      Flash::set($field, "Select at least one {$field}");
      return false;
    }

    $value = $_POST[$field];
    $message = '';
    
    [ $value, $message ] = match(gettype($value))
    {
      'string' => $this->filter_string($field, $value),
      'array' => $this->filter_array($field, $value),
    };

    if ($value === '')
    {
      Flash::set($field, $message);
      return false;
    }

    Old::set($field, $value);
    return $value;
  }
  
  private function filter_string(string $field, string $value)
  {
    $value = filter_input(INPUT_POST, $field, FILTER_UNSAFE_RAW);

    return [ $value, "The {$field} field is required" ];
  }

  private function filter_array(string $field, array $arrayValues, )
  {
    foreach($arrayValues as $value)
    {
      $values[] = filter_var($value, FILTER_UNSAFE_RAW);
    }

    return [ $values, "Select at least one {$field}" ];
  }
}