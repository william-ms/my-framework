<?php

namespace app\library\database;

class Query
{
  protected array $data;

  public function select(string|array $fields = '*')
  {
    $this->data['select'] = $fields;
    return $this;
  }

  public function where(string $field, string $operator, mixed $value, ?string $logic = null)
  {
    $this->data['where'][] = [$field, $operator, $value, $logic];
    $this->data['binds'][$field] = $value;

    return $this;
  }

  public function order(string $order)
  {
    $this->data['order'] = $order;
    return $this;
  }

  public function limit(int $limit)
  {
    $this->data['limit'] = $limit;
    return $this;
  }

  public function offset(int $offset)
  {
    $this->data['offset'] = $offset;
    return $this;
  }

  public function get(string $field)
  {
    return $this->data[$field];
  }

  public function queryParts(?array $parts = null)
  {
    $queryParts = [];

    if($parts)
    {
      foreach ($parts as $queryPart)
      {
        $queryParts[] = $this->transform($queryPart);
      }
    }
    else
    {
      $queryParts = [
        $this->transform('select'),
        $this->transform('where'),
        $this->transform('binds'),
        $this->transform('order'),
        $this->transform('limit'),
        $this->transform('offset'),
      ];
    }

    return $queryParts;
  }

  private function transform(string $field)
  {
    if(!isset($this->data[$field]))
    {
      return null;
    }

    $data = [];

    switch($field)
    {
      case 'select':
        if(is_array($this->data[$field]))
        {
          $data[$field] = implode(',', $this->data[$field]);
        }

        break;
      case 'where':
        $data[$field] = " where ";

        foreach($this->data[$field] as $where)
        {
          if(is_array($where[2]))
          {
            $data[$field] .= "{$where[0]} {$where[1]} (".implode(',', $where[2]).") {$where[3]}";
            $this->data['binds'] = null;
          }
          else
          {
            $data[$field] .= "{$where[0]} {$where[1]} :{$where[0]} {$where[3]} ";
          }
        }

        $data[$field] = rtrim($data[$field]);
        break;

      case 'order':
        $data[$field] = " order by ". $this->data[$field];
        break;

      case 'limit':
        $data[$field] = " limit ". $this->data[$field];
        break;

      case 'offset':
        $data[$field] = " offset ". $this->data[$field];
        break;

      case 'binds':
        foreach($this->data[$field] as $bind => $value)
        {
          if(is_array($value))
          {
            $data[$field][$bind] = implode(',', $value);
          }
          else{
            $data[$field][$bind] = $value;
          }
        }
        break;
    }

    return $data[$field] ?? null;
  }
}
