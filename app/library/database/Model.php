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
    $this->entity = $this->set_entity();
  }

  private function set_entity()
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

  public function execute_with_relationship(ActionInterface $action, array $relations)
  {
    $relations_created = [];
    $entities = $action->execute($this);

    if(!$entities)
    {
      return [];
    }

    foreach($relations as $relation_array)
    {
      if(count($relation_array) !== 3)
      {
        throw new Exception("To make relations, you need to give exactly 3 parameters to relations methods");
      }

      [$class, $relation, $property] = $relation_array;

      $relations_created[] = $this->relation($class, $relation, $property, $entities);
    }

    return $this->make_many_relations_with(...$relations_created);
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

    $relation_instance = new $relation;

    if(!$relation_instance instanceof RelationshipInterface)
    {
      throw new Exception("Class {$relation} is not type RelationshipInterface");
    }

    return $relation_instance->create(static::class, $model, $property, $entities);
  }

  private function make_many_relations_with(...$relations)
  {
    $first_relation = $relations[0];

    unset($relations[0]);

    foreach($relations as $relation)
    {
      $property = $relation->property;

      foreach($relation->entities as $key => $entity)
      {
        if(!property_exists($first_relation->entities[$key], $property))
        {
          $first_relation->entities[$key]->$property = $entity->$property;
        }
      }
    }

    return $first_relation->entities;
  }
}
