<?php

namespace app\library\validate;

use app\interfaces\validate\ValidateInterface;
use Exception;

class Validate
{
  public array $data = [];
  protected bool $errors = false;

  public function handle(array $validationsList)
  {
    foreach($validationsList as $field => $validations)
    {
      if(is_string($validations))
      {
        $validations = explode('|', $validations);
      }

      $this->validation_instance($field, $validations);
    }

    if(in_array(false, $this->data))
    {
      $this->errors = true;
    }
  }

  public function validation_instance(string $field, array $validations)
  {
    foreach($validations as $validation)
    {
      $className = $validation;
      $params = [];

      if(str_contains($validation, ':'))
      {
        [ $className, $params ] = $this->extract_params($validation);
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

      $this->data[$field] = $this->execute_validation(new $class, $field, $params);
    }
  }

  private function extract_params(string $class): array
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

  private function execute_validation(ValidateInterface $validateInterface, string $field, array $params): mixed
  {
    return $validateInterface->handle($field, $params);
  }

  public function has_errors(): bool
  {
    return $this->errors;
  }
}
