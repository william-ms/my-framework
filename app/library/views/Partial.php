<?php

namespace app\library\views;

use Exception;

class Partial
{
  private string $content;
  private array $data;

  public function __construct(string $partial, array $data)
  {
    $this->data = $data;

    [$path, $partial] = $this->check_partial($partial);

    $controller = $this->check_controller($path, $partial);

    if($controller)
    {
      $controller_instance = new $controller;
      $this->data = array_merge($this->data, $controller_instance->getData());
    }

    ob_start();
      extract($this->data);
      require(PATH['VIEW']. $path . $partial .'.php');
      
      $this->content = ob_get_contents();
    ob_end_clean();
  }

  public function render()
  {
    return $this->content;
  }

  private function partial(string $partial, array $data = [])
  {
    $data = array_merge($this->data, $data);
    echo (new Partial($partial, $data))->render();
  }

  private function section_start(string $section)
  {
    return Section::start($section);
  }

  private function section_end()
  {
    return Section::end();
  }

  private function component(string $component, array $data = [])
  {
    echo (new Component($component, $data))->render();
  }

  private function check_partial($partial)
  {
    [$path, $partial] = extract_folder($partial, 'view');

    if(is_dir(PATH['VIEW']. $path . DEFAULTS['PARTIALS_FOLDER']))
    {
      $path = $path . DEFAULTS['PARTIALS_FOLDER'] .'/';
    }

    if(!file_exists(PATH['VIEW']. $path . $partial .'.php'))
    {
      throw new Exception("Partial {$partial} is not fould in views/{$path}");
    }

    return [$path, $partial];
  }

  private function check_controller($path, $partial)
  {
    $namespace = "app\\controllers\\" . str_replace('/', '\\', $path);
    $controller = ucfirst($partial) . 'Partial';

    if(!class_exists($namespace . $controller))
    {
      return null;
    }

    return $namespace . $controller;
  }
}
