<?php

namespace app\library\database\relations;

use app\library\database\actions\FindAll;
use app\library\database\actions\FindBy;
use app\library\database\Query;

class RelationshipBelongsTo extends Relationship
{
  public function create(string $model, string $related_model, string $property, object|array $entities): object
  {    
    $related_shortname = $this->getModelShortName($related_model);
    
    $related_key = strtolower($related_shortname) . '_id';

    (is_array($entities))
    ? $entities = $this->relationship_with_array($related_model, $property, $entities, $related_key)
    : $entities = $this->relationship_with_single_entity($related_model, $property, $entities, $related_key);

    return (object)[
      'entities' => $entities,
      'property' => $property
    ];
  }

  private function relationship_with_array($related_model, $property, $entities, $related_key)
  {
    $ids = array_map(function($entity) use ($related_key)
    {
      return $entity->$related_key;
    }, $entities);

    $query = (new Query)->select()->where('id', 'in', array_unique($ids));
    $entities_from_related = (new $related_model)->execute(new FindAll($query));
    
    foreach($entities as $entity)
    {
      foreach($entities_from_related as $entity_from_related)
      {
        if($entity->$related_key === $entity_from_related->id)
        {
          $entity->$property = $entity_from_related;
        }
      }
    }

    return $entities;
  }

  private function relationship_with_single_entity($related_model, $property, $entity, $related_key)
  {
    $id = $entity->$related_key;

    $entity_from_related = (new $related_model)->execute(new FindBy('id', $id));
    
    $entity->$property = $entity_from_related;

    return $entity;
  }
}
