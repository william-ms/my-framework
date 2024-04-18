<?php

namespace app\database\connection;

use PDO;
use PDOException;

class Connection
{
  private static $pdo = null;

  public static function connect()
  {
    try
    {
      if(!static::$pdo)
      {
        $host = DB['HOST'];
        $port = DB['PORT'] ? ':'.DB['PORT'] : '';
        $name = DB['NAME'];
        $username = DB['USERNAME'];
        $password = DB['PASSWORD'];
        $options = DB['OPTIONS'];

        static::$pdo = new PDO("mysql:host={$host}{$port};dbname={$name}", $username, $password, $options);
      }

      return static::$pdo;
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}