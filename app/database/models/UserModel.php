<?php

namespace app\database\models;

use app\library\database\Model;

class UserModel extends Model
{
  protected string $entity = 'user';
  protected string $table = 'users';
}
