<?php

namespace app\library\database\relations;

use app\interfaces\database\RelationshipInterface;

abstract class Relationship implements RelationshipInterface
{
  protected function getModelShortName(string|object $model)
  {
    if(gettype($model) === 'string' && !class_exists($model))
    {
      throw new \Exception("Model {$model} does not exist");
    }

    $reflect = new \ReflectionClass($model);
    return str_replace('Model', "", $reflect->getShortName());
  }
}
