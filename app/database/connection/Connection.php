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
        static::$pdo = new PDO("mysql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME']."",$_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
      }

      return static::$pdo;
    }
    catch(PDOException $e)
    {
      var_dump($e->getMessage());
    }
  }
}