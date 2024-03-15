<?php

namespace app\library\database\relations;

use app\library\database\actions\FindAll;
use app\library\database\actions\FindBy;
use app\library\database\Query;

class RelationshipBelongsTo extends Relationship
{
  public function createWith(string $class, string $relatedClass, string $property, object|array $entities): object
  {    
    $relatedShortName = $this->getModelShortName($relatedClass);

    $relatedKey = strtolower($relatedShortName) . '_id';

    (is_array($entities))
    ? $entities = $this->relationshipWithArray($relatedClass, $property, $entities, $relatedKey)
    : $entities = $this->relationshipWithSingleEntity($relatedClass, $property, $entities, $relatedKey);

    return (object)[
      'entities' => $entities,
      'property' => $property
    ];
  }

  private function relationshipWithArray($relatedClass, $property, $entities, $relatedKey)
  {
    $ids = array_map(function($entity) use ($relatedKey)
    {
      return $entity->$relatedKey;
    }, $entities);

    $query = (new Query)->select()->where('id', 'in', array_unique($ids));
    $entitiesFromRelated = (new $relatedClass)->execute(new FindAll($query));
    
    foreach($entities as $entity)
    {
      foreach($entitiesFromRelated as $entityFromRelated)
      {
        if($entity->$relatedKey === $entityFromRelated->id)
        {
          $entity->$property = $entityFromRelated;
        }
      }
    }

    return $entities;
  }

  private function relationshipWithSingleEntity($relatedClass, $property, $entity, $relatedKey)
  {
    $id = $entity->$relatedKey;

    $entityFromRelated = (new $relatedClass)->execute(new FindBy('id', $id));
    
    $entity->$property = $entityFromRelated;

    return $entity;
  }
}
