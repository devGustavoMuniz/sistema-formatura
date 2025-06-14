<?php

namespace App\Interfaces;

/**
 * Interface para os objetos Observados (Subjects).
 * Define os métodos para gerenciar os Observers.
 *
 * @property-read int $id
 */
interface iSubject
{
    /**
     * Anexa um Observer ao Subject.
     *
     * @param iObserver $observer O Observer a ser anexado.
     * @return void
     */
    public function addObserver(iObserver $observer): void;

    /**
     * Desanexa um Observer do Subject.
     *
     * @param iObserver $observer O Observer a ser desanexado.
     * @return void
     */
    public function removeObserver(iObserver $observer): void;

    /**
     * Notifica todos os Observers anexados sobre uma mudança.
     *
     * @return void
     */
    public function notify(): void;
}
