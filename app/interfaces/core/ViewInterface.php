<?php

namespace app\interfaces\core;

interface ViewInterface
{
  public function __construct(string $view, array $data);
  public function view();
  public function extends(string $extends);
  public function css(string|array $cssList);
  public function scripts(string|array $scripts);
}
