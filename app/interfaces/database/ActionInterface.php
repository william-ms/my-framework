<?php

namespace app\interfaces\database;

interface ActionInterface
{
  public function execute(ModelInterface $model);
}
