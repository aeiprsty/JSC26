<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\MaxWidth;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Beranda';

    protected static ?int $navigationSort = 1;

    public function getTitle(): string
    {
        return 'Beranda';
    }

    public function getMaxContentWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }
}