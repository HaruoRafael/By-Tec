<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'cpf' => '12345678901',
                'rg' => '1234567',
                'telefone' => '1234567890',
                'sexo' => 'M',
                'data_nascimento' => '1990-01-01',
                'endereco' => 'Rua Exemplo, 123',
                'cargo' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'status' => 'Ativo', // Adicionando o campo status
            ],
            [
                'name' => 'Professor Example',
                'cpf' => '23456789012',
                'rg' => '2345678',
                'telefone' => '0987654321',
                'sexo' => 'F',
                'data_nascimento' => '1985-05-15',
                'endereco' => 'Rua Outro Exemplo, 456',
                'cargo' => 'Professor',
                'email' => 'professor@example.com',
                'password' => Hash::make('password'),
                'status' => 'Ativo', // Adicionando o campo status
            ],
            [
                'name' => 'Recepcionista Example',
                'cpf' => '34567890123',
                'rg' => '3456789',
                'telefone' => '1122334455',
                'sexo' => 'F',
                'data_nascimento' => '1992-09-20',
                'endereco' => 'Rua Outro Exemplo, 789',
                'cargo' => 'Recepcionista',
                'email' => 'recepcionista@example.com',
                'password' => Hash::make('password'),
                'status' => 'Ativo', // Adicionando o campo status
            ],
        ]);
    }
}
