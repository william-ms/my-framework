<?php

namespace app\interfaces\database;

interface RelationshipInterface
{
  public function create(string $model, string $related_model, string $property, array $entities): object;
}
