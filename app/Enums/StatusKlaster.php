<?php

namespace App\Enums;

enum StatusKlaster: string
{
    case MenungguVerifikasi = 'menunggu_verifikasi';
    case Terverifikasi = 'terverifikasi';
    case Disposisi = 'disposisi';
    case Ditugaskan = 'ditugaskan';
    case DalamProses = 'dalam_proses';
    case Selesai = 'selesai';
    case Ditolak = 'ditolak';
}