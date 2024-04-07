<?php

if($_ENV['ENVIRONMENT'] == 'production')
{

// paths
define('ROOT', dirname(path:__FILE__, levels:2));
define('VIEW_PATH', ROOT.'/app/views/');
define('CONTROLLER_PATH', ROOT.'/app/controllers/');

define('CSS_PATH', 'http://'.$_SERVER['SERVER_NAME'].'/public/assets/css/');
define('JS_PATH', 'http://'.$_SERVER['SERVER_NAME'].'/public/assets/js/');
define('IMAGE_PATH', 'http://'.$_SERVER['SERVER_NAME'].'/public/assets/images/');
define('ICON_PATH', 'http://'.$_SERVER['SERVER_NAME'].'/public/assets/icons/');
define('VIDEO_PATH', 'http://'.$_SERVER['SERVER_NAME'].'/public/assets/videos/');

// defaults
define('PARTIALS_FOLDER_DEFAULT', 'partials');
define('COMPONENTS_FOLDER_DEFAULT', 'components');

}