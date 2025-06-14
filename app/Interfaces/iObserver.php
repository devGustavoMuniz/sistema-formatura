<?php

namespace App\Interfaces;

/**
 * Interface para os objetos Observadores (Observers).
 * Define o método que o Subject chamará para notificar sobre uma mudança.
 */
interface iObserver
{
    /**
     * Recebe a atualização do Subject.
     *
     * @param iSubject $subject O objeto Subject que notificou a atualização.
     * @return void
     */
    public function update(iSubject $subject): void;
}
