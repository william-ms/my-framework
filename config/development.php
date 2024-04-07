<?php

if($_ENV['ENVIRONMENT'] == 'development')
{

// paths
define('ROOT', dirname(path:__FILE__, levels:2));
define('VIEW_PATH', ROOT.'/app/views/');
define('CONTROLLER_PATH', ROOT.'/app/controllers/');

define('CSS_PATH', '/assets/css/');
define('JS_PATH', '/assets/js/');
define('IMAGE_PATH', '/assets/images/');
define('ICON_PATH', '/assets/icons/');
define('VIDEO_PATH', '/assets/videos/');

// defaults
define('PARTIALS_FOLDER_DEFAULT', 'partials');
define('COMPONENTS_FOLDER_DEFAULT', 'components');

}