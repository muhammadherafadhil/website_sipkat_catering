<?php

namespace App\Enums;

enum OrderStatus: string
{
    case MENUNGGU_KONFIRMASI = 'Menunggu Konfirmasi';
    case DIKONFIRMASI        = 'Dikonfirmasi';
    case DIPROSES            = 'Diproses';
    case SIAP_DIKIRIM        = 'Siap Dikirim';
    case SELESAI             = 'Selesai';
    case DITOLAK             = 'Ditolak';
    case DIBATALKAN          = 'Dibatalkan';

    public static function transitions(): array
    {
        return [
            self::MENUNGGU_KONFIRMASI->value => [
                self::DIKONFIRMASI->value, self::DITOLAK->value, self::DIBATALKAN->value,
            ],
            self::DIKONFIRMASI->value => [self::DIPROSES->value],
            self::DIPROSES->value     => [self::SIAP_DIKIRIM->value],
            self::SIAP_DIKIRIM->value => [self::SELESAI->value],
            self::SELESAI->value      => [],
            self::DITOLAK->value      => [],
            self::DIBATALKAN->value   => [],
        ];
    }

    public static function canTransition(string $from, string $to): bool
    {
        return in_array($to, self::transitions()[$from] ?? [], true);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string { return $this->value; }
}