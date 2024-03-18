<?php

use app\library\helpers\Session;

function session_set(string $index, mixed $value)
{
  return Session::set($index, $value);
}

function session_get(string $index)
{
  return Session::get($index);
}

function session_has(string $index)
{
  return Session::has($index);
}

function session_remove(string $index)
{
  return Session::remove($index);
}

function session_remove_all()
{
  return Session::remove_all();
}

function session_dump(string $index = "")
{
  return Session::dump($index);
}
