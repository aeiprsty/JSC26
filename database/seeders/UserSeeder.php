<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Operator Admin',   'operator@tps.test', 'operator'],
            ['Kabid',            'kabid@tps.test',    'kabid'],
            ['Subkoordinator',   'subkoor@tps.test',  'subkoordinator'],
            ['Komando Lapangan', 'lapangan@tps.test', 'komando_lapangan'],
        ];

        foreach ($users as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'role' => $role, 'password' => 'password']
            );
        }
    }
}