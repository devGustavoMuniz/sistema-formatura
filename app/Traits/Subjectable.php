<?php

namespace App\Traits;

use App\Interfaces\iObserver;
use App\Interfaces\iSubject;
use SplObjectStorage;

trait Subjectable
{
    protected SplObjectStorage $observers;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->observers = new SplObjectStorage();
    }

    public function addObserver(iObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function removeObserver(iObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
