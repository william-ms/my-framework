<?php

namespace app\library\validate;

use app\interfaces\validate\ValidateInterface;
use app\library\helpers\Flash;
use app\library\helpers\Old;

class ValidateImage implements ValidateInterface
{
  /**
   * @param string $field File input field name
   * @param array $params Options to validate the file
   */
  public function handle(string $field, array $params): bool
  {
    $size = (isset($params['size']))
    ? $params['size']
    : null;

    $extensions = (isset($params['extensions']))
    ? explode(',', strtolower($params['extensions']))
    : [];

    $image = $_FILES[$field];
    $imageSize = (int)number_format($image['size'] / 1048576 );
    $imageExtension = pathInfo($image['name'], PATHINFO_EXTENSION);

    if($image['error'] === 4)
    {
      Flash::set($field, 'Please, select an image');
      return false;
    }

    if(isset($size) && $imageSize > $size)
    {
      Flash::set($field, "Image size must be less than {$size}mb");
      return false;
    }

    if(!empty($extensions) && !in_array($imageExtension, $extensions))
    {
      Flash::set($field, "Only ".implode(', ', $extensions)." extensions are accepted");
      return false;
    }

    Old::set($field, $image);
    return true;
  }
}
