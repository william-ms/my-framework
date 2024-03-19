<?php

namespace app\library\validate;

use app\core\UriExtract;
use app\interfaces\validate\ValidateInterface;
use Exception;

class Validate
{
  public array $data = [];
  private bool $errors = false;

  public function handle(array $validations)
  {
    foreach($validations as $field => $validation)
    {
      if(is_string($validation))
      {
        $validation = explode('|', $validation);
      }

      $this->validationInstance($field, $validation);
    }

    if(in_array(false, $this->data))
    {
      $this->errors = true;
    }
  }

  public function validationInstance(string $field, array $validations)
  {
    foreach($validations as $validation)
    {
      $namespace = "app\\library\\validate\\";
      $validation = "Validate" . ucfirst(strtolower($validation));

      $class = $namespace . $validation;

      if(!class_exists($class))
      {
        throw new Exception("Class {$validation} not found in {$namespace}");
      }

      [ $class, $param ] = $this->classWithColon($class);

      $this->data[$field] = $this->executeValidation(new $class, $field, $param);
    }
  }

  private function classWithColon($class)
  {
    $param = null;

    if(str_contains($class, ':'))
    {
      [ $class, $param ] = explode(':', $class);
    }

    return [ $class, $param ];
  }

  private function executeValidation(ValidateInterface $validateInterface, $field, $param)
  {
    return $validateInterface->handle($field, $param);
  }

  public function if_errors(string $to)
  {
    if($this->errors)
    {
      return header("Location: {$to}");
    }
  }

}
