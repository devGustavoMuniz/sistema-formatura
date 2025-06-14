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

        // Em uma aplicação real, aqui você poderia:
        // 1. Enviar um email para um administrador.
        // 2. Criar uma notificação no banco de dados para o usuário.
        // 3. Disparar um evento para um sistema externo.

        // Para este exemplo, vamos apenas registrar um log diferente.
        Log::channel('slack')->info(
            "ALERTA: A entidade {$className} com ID #{$subject->id} sofreu uma alteração importante."
        );
    }
}
