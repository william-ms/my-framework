<?php

use app\library\helpers\FormatException;

function formatException(Throwable $throw)
{
  return FormatException::throw($throw);
}