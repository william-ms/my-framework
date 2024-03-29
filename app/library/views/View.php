<?php

namespace app\library\views;

class View
{
  private array $partials;
  private string $view;
  private array $data;
  private string $extends;
  private bool $definedPartial = false;

  public function __construct(string $view, array $data)
  {
    $this->view = extract_file($view, 'view', true);
    $this->data = $data;

    ob_start();
      extract($this->data);

      require(VIEW_PATH. $this->view .'.php');

      $content = ob_get_contents();
    ob_end_clean();

    Section::set('content', $content);
  }

  public function render()
  {
    extract($this->data);

    if(isset($this->extends))
    {
      ob_start();
        require(VIEW_PATH. $this->extends .'.php');

        if($this->definedPartial)
        {
          ob_clean();
          require(VIEW_PATH. $this->extends .'.php');
        }

        $content = ob_get_contents();
      ob_end_clean();

      return $content;
    }

    return Section::get('content');
  }

  private function extends(string $view, array $data = [])
  {
    $this->extends = extract_file($view, 'view', true);
    $this->data = array_merge($this->data, $data);
  }

   private function section_start(string $section)
  {
    Section::start($section);
  }

  private function section_end()
  {
    Section::end();
  }

  private function section(string $section)
  {
    echo Section::get($section);
  }

  private function partial(string $partial)
  {
    $this->definedPartial = true;

    if(!isset($this->partials[$partial]))
    {
      return $this->partials[$partial] = (new Partial($partial, $this->data))->render();
    }

    echo $this->partials[$partial];
  }
}