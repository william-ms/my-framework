<?php

namespace app\library\database\actions;

use app\interfaces\database\ActionInterface;
use app\interfaces\database\ModelInterface;

class Action implements ActionInterface
{
  public function execute(ModelInterface $model){}
}
