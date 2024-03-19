<?php

namespace app\interfaces\validate;

interface ValidateInterface
{
  public function handle($field, $param);
}