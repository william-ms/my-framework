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
        $host = DB_HOST;
        $port = (DB_PORT) ? ':'.DB_PORT : '';
        $name = DB_NAME;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $options = DB_OPTIONS;

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