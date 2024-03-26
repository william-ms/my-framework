<?php

namespace app\library\validate;

use app\interfaces\validate\ValidateInterface;
use Exception;

class Validate
{
  private static bool $errors = false;

  public static function handle(array $validationsList): object
  {
    foreach($validationsList as $field => $validations)
    {
      if(is_string($validations))
      {
        $validations = explode('|', $validations);
      }

      foreach($validations as $validation)
      {
        $value = self::validation_instance($field, $validation);
      
        if($value === false)
        {
          self::$errors = true;
          return new static;
        }
      }
    }

    return new static;
  }

  private static function validation_instance(string $field, string $validation): bool
  {
    $className = $validation;
    $params = [];

    if(str_contains($validation, ':'))
    {
      [ $className, $params ] = self::extract_params($validation);
    }

    $namespace = "app\\library\\validate\\";
    $className = "Validate" . ucfirst(strtolower($className));

    $class = $namespace . $className;

    if(!class_exists($class))
    {
      throw new Exception("Class {$className} not found in {$namespace}");
    }

    if(!in_array(ValidateInterface::class, class_implements($class)))
    {
      throw new Exception("Class {$className} not implements ValidateInterface");
    }

    return (new $class)->handle($field, $params);
  }

  private static function extract_params(string $class): array
  {
    $parts = explode(':', $class);
    $class = $parts[0];

    foreach($parts as $key => $param)
    {
      if($key !== 0)
      {
        $param = explode('=', $param);
        $params[$param[0]] = $param[1];
      }
    }

    return [ $class, $params ];
  }

  public function success(): bool
  {
    return (self::$errors === false) ? true : false ;
  }
}
