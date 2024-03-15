<?php

namespace app\library\database\actions;

use app\database\connection\Connection;
use PDOException;

class Delete extends Action
{
  protected string $field;
  protected string $operator;
  protected mixed $value;

  public function __construct(string $field, string $operator, mixed $value)
  {
    $this->field = $field;
    $this->operator = $operator;
    $this->value = $value;
  }

  public function execute($model)
  {
    try
    {
      $connection = Connection::connect();

      $query = "delete from {$model->getTable()} ";
      $query .= " where {$this->field} {$this->operator} :{$this->field}";

      $prepare = $connection->prepare($query);
      $prepare->execute([$this->field => $this->value]);

      return $prepare->rowCount();
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}
