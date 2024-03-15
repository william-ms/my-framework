<?php

namespace app\library\database\actions;

use app\database\connection\Connection;
use app\library\database\Query;
use PDO;
use PDOException;

class FindAll extends Action
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
        [$select, $where, $binds, $order, $limit, $offset] = $this->query->queryParts();
       
        $select = $select ?? '*';

        $query = "select {$select} from {$model->getTable()}{$where}{$order}{$limit}{$offset}";
      }

      $prepare = $connection->prepare($query);
      $prepare->execute($binds);

      return $prepare->fetchAll(PDO::FETCH_CLASS, $model->getEntity());
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}
