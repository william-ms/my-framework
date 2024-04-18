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

      require(PATH['VIEW'] . $component . '.php');

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

    if(is_dir(PATH['VIEW'] . $path . DEFAULTS['COMPONENTS_FOLDER']))
    {
      $path .= DEFAULTS['COMPONENTS_FOLDER'] . '/';
    }

    if(!file_exists(PATH['VIEW']. $path . $component .'.php'))
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
