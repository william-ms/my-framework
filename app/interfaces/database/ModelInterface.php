<?php

namespace app\interfaces\database;

interface ModelInterface
{
  public function __construct();
  public function getEntity();
  public function getTable();
  public function execute(ActionInterface $action);
  public function executeWithRelationship(ActionInterface $action, array $relations);
}
