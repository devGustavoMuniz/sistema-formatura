<?php

namespace App\Observers;

use App\Interfaces\iObserver;
use App\Interfaces\iSubject;
use Illuminate\Support\Facades\Log;

class LogObserver implements iObserver
{
    /**
     * Recebe a atualização do Subject e registra um log.
     *
     * @param iSubject $subject O objeto Subject que notificou a atualização.
     * @return void
     */
    public function update(iSubject $subject): void
    {

        $className = class_basename($subject);


        Log::info("A entidade {$className} com ID #{$subject->id} foi atualizada ou criada.");
    }
}
