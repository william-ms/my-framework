<?php

namespace app\database\models;

use app\library\database\Model;

class PostModel extends Model
{
  protected string $table = 'posts';
  protected string $entity = 'post';
}
