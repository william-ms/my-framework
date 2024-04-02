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

    [$partialPath, $partialName] = extract_folder($partial, 'view');

    if(is_dir(VIEW_PATH. $partialPath . PARTIALS_FOLDER_DEFAULT))
    {
      $partialPath = $partialPath . PARTIALS_FOLDER_DEFAULT .'/';
    }

    if(!file_exists(VIEW_PATH. $partialPath . $partialName .'.php'))
    {
      throw new Exception("Partial {$partialName} is not fould in views/{$partialPath}");
    }

    ob_start();
      extract($data);
      require(VIEW_PATH. $partialPath . $partialName .'.php');
      
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
}
