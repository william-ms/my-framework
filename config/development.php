<?php

if($_ENV['ENVIRONMENT'] == 'development')
{
  //================================= PATHS ==================================//
  define('ROOT', dirname(path:__FILE__, levels:2));
  define('VIEW_PATH', ROOT.'/app/views/');
  define('CONTROLLER_PATH', ROOT.'/app/controllers/');

  define('CSS_PATH', '/assets/css/');
  define('JS_PATH', '/assets/js/');
  define('IMAGE_PATH', '/assets/images/');
  define('ICON_PATH', '/assets/icons/');
  define('VIDEO_PATH', '/assets/videos/');

  //================================ DEFAULTS ================================//
  define('PARTIALS_FOLDER_DEFAULT', 'partials');
  define('COMPONENTS_FOLDER_DEFAULT', 'components');

  //================================ DATABASE ================================//
  define('DB_HOST', $_ENV['DB_HOST']);
  define('DB_PORT', $_ENV['DB_PORT']);
  define('DB_NAME', $_ENV['DB_NAME']);
  define('DB_USERNAME', $_ENV['DB_USERNAME']);
  define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
  define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
  ]);
}