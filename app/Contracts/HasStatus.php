<?php

namespace App\Contracts;

/**
 * OOP: INTERFACE — kontrak untuk model yang punya status.
 */
interface HasStatus
{
    public function getStatus(): string;
    public function getStatusLabel(): string;
}