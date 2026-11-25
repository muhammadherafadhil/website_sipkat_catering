<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case MENUNGGU_VERIFIKASI = 'Menunggu Verifikasi';
    case TERVERIFIKASI       = 'Terverifikasi';
    case DITOLAK             = 'Ditolak';
    case BELUM_DIBAYAR       = 'Belum Dibayar';
    case DIBAYAR_SEBAGIAN    = 'Dibayar Sebagian';
    case LUNAS               = 'Lunas';
}