<?php

namespace app\library\database\actions;

use app\database\connection\Connection;
use PDOException;
use PDO;

class FindBy extends Action
{
  private string $field;
  private mixed $value;
  private string|array $fields;

  public function __construct(string $field, mixed $value, string|array $fields = '*')
  {
    $this->field = $field;
    $this->value = $value;
    $this->fields = $fields;
  }

  public function execute($model)
  {
    try
    {
      $connection = Connection::connect();

      $query = "select {$this->fields} from {$model->getTable()}";
      $query .= " where {$this->field} = :{$this->field}";

      $prepare = $connection->prepare($query);
      $prepare->execute([$this->field => $this->value]);
      $prepare->setFetchMode(PDO::FETCH_CLASS, $model->getEntity());

      return $prepare->fetch();
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}
