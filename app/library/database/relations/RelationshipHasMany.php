<?php

namespace app\library\database\relations;

use app\library\database\actions\FindAll;
use app\library\database\Query;

class RelationshipHasMany extends Relationship
{
  public function create(string $model, string $related_model, string $property, object|array $entities): object
  {
    $related_shortname = strtolower(self::getModelShortName($related_model)) . 's';
    $model_shortname = strtolower(self::getModelShortName($model)) . '_id';

    $related_key = $related_shortname . '.' . $model_shortname;

    (is_array($entities))
    ? $entities = $this->relationship_with_array($related_model, $property, $entities, $related_key, $model_shortname)
    : $entities = $this->relationship_with_single_entity($related_model, $property, $entities, $related_key);

    return (object)[
      'entities' => $entities,
      'property' => $property
    ];
  }

  private function relationship_with_array($related_model, $property, $entities, $related_key, $model_shortname)
  {
    $ids = array_map(function($entity){
      return $entity->id;
    }, $entities);

    $query = (new Query)->select()->where($related_key, 'in', array_unique($ids));
    $entities_from_related = (new $related_model)->execute(new FindAll($query));

    foreach($entities as $entity)
    {
      $array_entities = [];

      foreach($entities_from_related as $entity_from_related)
      {
        if($entity->id === $entity_from_related->$model_shortname)
        {
          $array_entities[] = $entity_from_related;
        }
      }

      $entity->$property = $array_entities;
    }

    return $entities;
  }

  private function relationship_with_single_entity($related_model, $property, $entity, $related_key)
  {
    $id[] = $entity->id;

    $query = (new Query)->select()->where($related_key, 'in', $id);
    $entities_from_related = (new $related_model)->execute(new FindAll($query));

    $entity->$property = $entities_from_related;

    return $entity;
  }
}