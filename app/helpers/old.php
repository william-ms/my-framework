<?php

use app\library\helpers\Old;

function old($field)
{
  return Old::get($field);
}