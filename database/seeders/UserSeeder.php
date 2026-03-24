<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@lottopredictor.com',
            'password' => Hash::make('admin123'),
        ]);
        
        User::create([
            'name' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => Hash::make('12345678'),
        ]);
        
        $this->command->info('✅ Usuarios de prueba creados');
    }
}