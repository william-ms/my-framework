<?php

namespace app\interfaces\database;

interface ModelInterface
{
  public function __construct();
  public function getEntity();
  public function getTable();
  public function execute(ActionInterface $action);
  public function execute_with_relationship(ActionInterface $action, array $relations);
}
