<?php

namespace app\library\views;

use Exception;

class Partial
{ 
  private string $partial;
  private array $data;

  public function __construct(string $partial, array $data)
  {
    $this->partial = $this->validate_partial($partial);
    $this->data = $data;
  }

  public function render()
  {
    ob_start();
      extract($this->data);

      require_once(VIEW_PATH. $this->partial .'.php');

      $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }

  private function section_start(string $section)
  {
    Section::start($section);
  }

  private function section_end()
  {
    Section::end();
  }

  private function validate_partial(string $partial)
  {
    [$partialPath, $partial] = extract_folder($partial, 'view');

    if(is_dir(VIEW_PATH. $partialPath . PARTIALS_FOLDER_DEFAULT))
    {
      $partialPath = $partialPath . PARTIALS_FOLDER_DEFAULT .'/';
    }

    if(!file_exists(VIEW_PATH. $partialPath . $partial .'.php'))
    {
      throw new Exception("Partial {$partial} is not fould in {$partialPath}");
    }

    return $partialPath . $partial;
  }
}
