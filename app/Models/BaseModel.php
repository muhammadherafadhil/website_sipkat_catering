<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * OOP: ABSTRACT CLASS + INHERITANCE
 * Tidak bisa diinstansiasi langsung. Semua model turunan
 * mewarisi method formatCurrency() & konstanta.
 */
abstract class BaseModel extends Model
{
    // CONSTANT: format & mata uang aplikasi
    public const CURRENCY    = 'IDR';
    public const DATE_FORMAT = 'd/m/Y H:i';

    // STATIC: utilitas format uang untuk seluruh aplikasi
    public static function formatCurrency(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    // STATIC: format tanggal konsisten
    public static function formatDate($date): string
    {
        return $date ? \Carbon\Carbon::parse($date)->format(self::DATE_FORMAT) : '-';
    }

    // OBJECT METHOD: helper umum
    public function isCreatedToday(): bool
    {
        return $this->created_at?->isToday() ?? false;
    }
}