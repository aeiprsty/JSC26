<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Klaster;

class DashboardKlaster extends Component
{
    public function render()
    {
        return view('livewire.dashboard-klaster', [
            // Mengambil semua data klaster beserta relasi laporannya, diurutkan dari yang terbaru
            'klasters' => Klaster::with('laporans')->latest()->get()
        ]);
    }
}