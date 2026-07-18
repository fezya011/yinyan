<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ===== Обычные пользователи =====
        User::factory(10)->create();

        // ===== Администратор =====
        Admin::create([
            'name' => 'Администратор',
            'email' => 'admin.yinyan@gmail.com',
            'password' => Hash::make('HqEVw4EdCs).2Yb'),
            'is_active' => true,
        ]);

        // Дополнительный админ (опционально)
        Admin::create([
            'name' => 'Менеджер',
            'email' => 'manager@example.com',
            'password' => Hash::make('HqEVw4EdCs).2Yb'),
            'is_active' => true,
        ]);

        $this->command->info('✅ База данных заполнена!');
        $this->command->info('📧 Админ: admin.yinyan@gmail.com');
        $this->command->info('🔑 Пароль: HqEVw4EdCs).2Yb');
        $this->command->info('📧 Тестовый пользователь: test@example.com');
        $this->command->info('🔑 Пароль: password123');
    }
}
