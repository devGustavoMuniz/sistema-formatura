<?php

namespace App\Observers;

use App\Interfaces\iObserver;
use App\Interfaces\iSubject;
use Illuminate\Support\Facades\Log;

class NotificationObserver implements iObserver
{
    /**
     * Recebe a atualização do Subject e dispara uma notificação.
     *
     * @param iSubject $subject O objeto Subject que notificou a atualização.
     * @return void
     */
    public function update(iSubject $subject): void
    {
        $className = class_basename($subject);




        Log::channel('slack')->info(
            "ALERTA: A entidade {$className} com ID #{$subject->id} sofreu uma alteração importante."
        );
    }
}
