<?php

namespace app\library\database\actions;

use app\interfaces\database\EntityInterface;
use app\database\connection\Connection;
use PDOException;

class Update extends Action
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

      $query = "update {$model->getTable()} set ";
  
      foreach($this->entity->getAttributes() as $attribute => $value)
      {
        if($attribute !== 'id')
        {
          $query .= "{$attribute} = :{$attribute},";
        }
      }
  
      $query = rtrim($query, ',');
      $query .= " where id = :id";
      $prepare = $connection->prepare($query);
  
      return $prepare->execute($this->entity->getAttributes());
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}
