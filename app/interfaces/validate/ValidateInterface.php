<?php

namespace app\interfaces\validate;

interface ValidateInterface
{
  public function handle(string $field, array $params): bool;
}