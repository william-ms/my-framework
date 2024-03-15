<?php

namespace app\library\controllers;

use app\interfaces\controllers\ControllerInterface;

abstract class Controller implements ControllerInterface
{
  public function index(array $args){}
  public function show(array $args){}
  public function create(){}
  public function store(){}
  public function edit(array $args){}
  public function update(array $args){}
  public function destroy(array $args){}
}