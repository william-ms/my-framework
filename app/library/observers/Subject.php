<?php

namespace app\library\observers;

use SplObjectStorage;
use SplObserver;
use SplSubject;

abstract class Subject implements SplSubject
{
  private SplObjectStorage $observers;

  public function __construct()
  {
    $this->observers = new SplObjectStorage();
  }

  public function attach(SplObserver $observer): void
  {
    $this->observers->attach($observer);
  }

  public function attach_many(array $observers): void
  {
    foreach($observers as $observer)
    {
      $this->observers->attach($observer);
    }
  }

  public function detach(SplObserver $observer): void
  {
    $this->observers->detach($observer);
  }

  public function notify(): void
  {
    foreach($this->observers as $observer)
    {
      $observer->update($this);
    }
  }
}
