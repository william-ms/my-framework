<?php

namespace app\library\database\actions;

use app\database\connection\Connection;
use app\library\database\Query;
use PDOException;

class Count extends Action
{
  protected ?Query $query;

  public function __construct(?Query $query = null)
  {
    $this->query = $query;
  }

  public function execute($model)
  {
    try
    {
      $connection = Connection::connect();
      
      $query = "select * from {$model->getTable()}";
      $binds = null;

      if(isset($this->query))
      {
        [$where, $binds] = $this->query->queryParts(['where', 'binds']);
        $query = "select count(*) as total from {$model->getTable()}{$where}";
      }

      $prepare = $connection->prepare($query);
      $prepare->execute($binds);

      return $prepare->fetchObject($model->getEntity());
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}
