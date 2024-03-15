<?php

namespace app\interfaces\database;

interface RelationshipInterface
{
  public function createWith(string $class, string $model, string $property, array $entities): object;
}
