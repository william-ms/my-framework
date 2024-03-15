<?php

namespace app\library\database;

use app\interfaces\database\ModelInterface;
use app\interfaces\database\ActionInterface;
use app\interfaces\database\RelationshipInterface;
use ReflectionClass;
use Exception;

abstract class Model implements ModelInterface
{
  protected string $table;
  protected string $entity = '';

  public function __construct()
  {
    $this->entity = $this->setEntity();
  }

  private function setEntity()
  {
    if($this->entity == '')
    {
      $reflect = new ReflectionClass(static::class);
      $this->entity = str_replace('Model', "", $reflect->getShortName());
    }

    $entity = "app\\database\\entities\\". ucfirst($this->entity) ."Entity";
    
    if(!class_exists($entity))
    {
      throw new \Exception("Entity {$entity} does not exist!");
    }

    return $entity;
  }

  public function getEntity()
  {
    return $this->entity;
  }

  public function getTable()
  {
    return $this->table;
  }

  public function execute(ActionInterface $action)
  {
    return $action->execute($this);
  }

  public function executeWithRelationship(ActionInterface $action, array $relations)
  {
    $relationsCreated = [];
    $entities = $action->execute($this);

    foreach($relations as $relationArray)
    {
      if(count($relationArray) !== 3)
      {
        throw new Exception("To make relations, you need to give exactly 3 parameters to relations methods");
      }

      [$class, $relation, $property] = $relationArray;

      $relationsCreated[] = $this->relation($class, $relation, $property, $entities);
    }

    return $this->makeManyRelationsWith(...$relationsCreated);
  }

  private function relation(string $model, string $relation, string $property, object|array $entities)
  {
    if(!class_exists($model))
    {
      throw new Exception("Model {$model} does not exist");
    }

    if(!class_exists($relation))
    {
      throw new Exception("Relation {$relation} does not exist");
    }

    $classRelation = new $relation;

    if(!$classRelation instanceof RelationshipInterface)
    {
      throw new Exception("Class {$relation} is not type RelationshipInterface");
    }

    return $classRelation->createWith(static::class, $model, $property, $entities);
  }

  private function makeManyRelationsWith(...$relations)
  {
    $firstRelation = $relations[0];

    unset($relations[0]);

    foreach($relations as $relation)
    {
      $property = $relation->property;

      foreach($relation->entities as $key => $entity)
      {
        if(!property_exists($firstRelation->entities[$key], $property))
        {
          $firstRelation->entities[$key]->$property = $entity->$property;
        }
      }
    }

    return $firstRelation->entities;
  }
}
