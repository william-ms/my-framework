<?php

namespace app\library\database;

use app\interfaces\database\EntityInterface;

abstract class Entity implements EntityInterface
{
  protected array $attributes = [];

  public function __set(string $property, mixed $value)
  {
    $this->attributes[$property] = $value;
  }

  public function __get(string $property)
  {
    return $this->attributes[$property];
  }

  public function getAttributes()
  {
    return $this->attributes;
  }
}
