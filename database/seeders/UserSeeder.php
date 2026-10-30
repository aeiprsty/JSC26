<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Operator Admin', 'operator@tps.test', 'operator'],
            ['Kabid', 'kabid@tps.test', 'kabid'],
            ['Subkoordinator', 'subkoor@tps.test', 'subkoordinator'],

            ['Komando A', 'komando.a@tps.test', 'komando_lapangan'],
            ['Komando B', 'komando.b@tps.test', 'komando_lapangan'],
            ['Komando C', 'komando.c@tps.test', 'komando_lapangan'],
            ['Komando D', 'komando.d@tps.test', 'komando_lapangan'],
        ];

        foreach ($users as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'role' => $role,
                    'password' => 'password',
                ]
            );
        }
    }
}