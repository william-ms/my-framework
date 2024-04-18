<?php

//================================= PATHS ==================================//
define('PATH', [
  'ROOT'        => dirname(path:__FILE__, levels:2),
  'VIEW'        => dirname(path:__FILE__, levels:2) . '/app/views/',
  'CONTROLLER'  => dirname(path:__FILE__, levels:2) . '/app/controllers/',

  'CSS'   => 'http://'. $_SERVER['SERVER_NAME'] .'/public/assets/css/',
  'JS'    => 'http://'. $_SERVER['SERVER_NAME'] .'/public/assets/js/',
  'IMAGE' => 'http://'. $_SERVER['SERVER_NAME'] .'/public/assets/images/',
  'ICON'  => 'http://'. $_SERVER['SERVER_NAME'] .'/public/assets/icons/',
  'VIDEO' => 'http://'. $_SERVER['SERVER_NAME'] .'/public/assets/videos/',
]);

//================================ DEFAULTS ================================//
define('DEFAULTS', [
  'PARTIALS_FOLDER'   => 'partials',
  'COMPONENTS_FOLDER' => 'components'
]);

//================================ DATABASE ================================//
define('DB', [
  'HOST'      => $_ENV['DB_HOST'],
  'PORT'      => $_ENV['DB_PORT'],
  'NAME'      => $_ENV['DB_NAME'],
  'USERNAME'  => $_ENV['DB_USERNAME'],
  'PASSWORD'  => $_ENV['DB_PASSWORD'],
  'OPTIONS'   => [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
  ]
]);
