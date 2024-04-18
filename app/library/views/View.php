<?php

namespace app\library\views;

class View
{
  private string $view;
  private string $extends;
  private array $data;
  private array $partials;
  private bool $defined_partial = false;

  public function __construct(string $view, array $data)
  {
    $this->view = extract_file($view, 'view', true);
    $this->data = $data;
  }

  private function extends(string $extends, array $data = [])
  {
    $this->extends = extract_file($extends, 'view', true);
    $this->data = array_merge($this->data, $data);
  }

  private function partial(string $partial, array $data = [])
  {
    if($this->defined_partial === false)
    {
      $this->defined_partial = true;
    }

    if(!isset($this->partials[$partial]))
    {
      $data = array_merge($this->data, $data);
      $this->partials[$partial] = (new Partial($partial, $data))->render();
    }
    
    echo $this->partials[$partial];
  }

  private function section_start(string $section)
  {
    return Section::start($section);
  }

  private function section_end()
  {
    return Section::end();
  }

  private function section(string $section)
  {
    echo Section::get($section);
  }

  private function component(string $component, array $data = [])
  {
    echo (new Component($component, $data))->render();
  }

  public function render()
  {
    ob_start();
      extract($this->data);
      require_once(PATH['VIEW']. $this->view .'.php');

      if(isset($this->extends))
      {
        Section::set('content', ob_get_contents());
        ob_clean();

        extract($this->data);
        require(PATH['VIEW']. $this->extends .'.php');

        if($this->defined_partial === true)
        {
          ob_clean();
          require(PATH['VIEW']. $this->extends .'.php');
        }
      }

      $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }
}