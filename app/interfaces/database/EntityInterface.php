<?php

namespace app\interfaces\database;

interface EntityInterface
{
  public function __set(string $property, mixed $value);
  public function __get(string $property);
  public function getAttributes();
}
