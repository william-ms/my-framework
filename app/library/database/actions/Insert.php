<?php

namespace app\library\database\actions;

use app\interfaces\database\EntityInterface;
use app\database\connection\Connection;
use PDOException;

class Insert extends Action
{
  protected EntityInterface $entity;

  public function __construct($entity)
  {
    $this->entity = $entity;
  }

  public function execute($model)
  {
    try
    {
      $connection = Connection::connect();

      $query = "insert into {$model->getTable()} ";
      $query .= "(". implode(',', array_keys($this->entity->getAttributes())) .")";
      $query .= " values (:". implode(',:', array_keys($this->entity->getAttributes())) .")";

      $prepare = $connection->prepare($query);

      return $prepare->execute($this->entity->getAttributes());
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}
