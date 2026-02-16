<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Создаёт админа из переменных окружения (ADMIN_EMAIL, ADMIN_PASSWORD, ADMIN_NAME).
 * Данные не хранятся в коде — только в .env или в настройках хостинга.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');
        $name = env('ADMIN_NAME', 'Admin');

        if (empty($email) || empty($password)) {
            return;
        }

        \App\Models\User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt($password),
            ]
        );
    }
}
