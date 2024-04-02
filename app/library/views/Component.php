<?php

namespace app\library\views;

use Exception;

class Component
{
  private string $content;

  public function __construct(string $component, array $data)
  {
    $component = $this->validate($component);

    ob_start();
      extract($data);

      require(VIEW_PATH . $component . '.php');

      $this->content = ob_get_contents();
    ob_end_clean();
  }

  public function render(): string
  {
    return $this->content;
  }

  private function validate(string $component)
  {
    [$path, $component] = extract_folder($component, 'view');

    if(is_dir(VIEW_PATH . $path . COMPONENTS_FOLDER_DEFAULT))
    {
      $path .= COMPONENTS_FOLDER_DEFAULT . '/';
    }

    if(!file_exists(VIEW_PATH. $path . $component .'.php'))
    {
      throw new Exception("{$component} component  not found in app/views/{$path}");
    }
    
    return $path . $component;
  }

  private function section_start(string $section)
  {
    Section::start($section);
  }

  private function section_end()
  {
    Section::end();
  }
}
