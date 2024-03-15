<?php

namespace app\library\database\relations;

use app\library\database\actions\FindAll;
use app\library\database\Query;

class RelationshipHasMany extends Relationship
{
  public function createWith(string $class, string $relatedClass, string $property, object|array $entities): object
  {
    $relatedShortName = strtolower(self::getModelShortName($relatedClass));
    $classShortName = strtolower(self::getModelShortName($class)) . '_id';

    $relatedKey = $relatedShortName . '.' . $classShortName;

    (is_array($entities))
    ? $entities = $this->relationshipWithArray($relatedClass, $property, $entities, $relatedKey, $classShortName)
    : $entities = $this->relationshipWithSingleEntity($relatedClass, $property, $entities, $relatedKey);

    return (object)[
      'entities' => $entities,
      'property' => $property
    ];
  }

  public function relationshipWithArray($relatedClass, $property, $entities, $relatedKey, $classShortName)
  {
    $ids = array_map(function($entity){
      return $entity->id;
    }, $entities);

    $query = (new Query)->select()->where($relatedKey, 'in', array_unique($ids));
    $entitiesFromRelated = (new $relatedClass)->execute(new FindAll($query));

    foreach($entities as $entity)
    {
      $arrayEntities = [];

      foreach($entitiesFromRelated as $entityFromRelated)
      {
        if($entity->id === $entityFromRelated->$classShortName)
        {
          $arrayEntities[] = $entityFromRelated;
        }
      }

      $entity->$property = $arrayEntities;
    }

    return $entities;
  }

  public function relationshipWithSingleEntity($relatedClass, $property, $entity, $relatedKey)
  {
    $id[] = $entity->id;

    $query = (new Query)->select()->where($relatedKey, 'in', $id);
    $entitiesFromRelated = (new $relatedClass)->execute(new FindAll($query));

    $entity->$property = $entitiesFromRelated;

    return $entity;
  }
}