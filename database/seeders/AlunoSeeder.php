<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AlunoSeeder extends Seeder
{
    public function run()
    {
        DB::table('alunos')->insert([
            [
                'nome' => 'Pedro',
                'cpf' => '60244577668',
                'rg' => '1234567',
                'telefone' => '1234567890',
                'sexo' => 'Masculino',
                'data_nascimento' => Carbon::createFromFormat('Y-m-d', '1990-01-01'),
                'endereco' => 'Rua Exemplo, 123',
                'status' => 'Inativo', 
            ],
            [
                'nome' => 'Amanda ',
                'cpf' => '68562424846',
                'rg' => '2345678',
                'telefone' => '0987654321',
                'sexo' => 'Feminino',
                'data_nascimento' => Carbon::createFromFormat('Y-m-d', '1985-05-15'),
                'endereco' => 'Avenida Exemplo, 456',
                'status' => 'Inativo',
            ],
            [
                'nome' => 'Andre',
                'cpf' => '77345824519',
                'rg' => '3456789',
                'telefone' => '1122334455',
                'sexo' => 'Masculino',
                'data_nascimento' => Carbon::createFromFormat('Y-m-d', '1992-09-20'),
                'endereco' => 'Rua Outro Exemplo, 789',
                'status' => 'Inativo', 
            ],
            [
                'nome' => 'Alex',
                'cpf' => '52449805567',
                'rg' => '4567890',
                'telefone' => '2233445566',
                'sexo' => 'Feminino',
                'data_nascimento' => Carbon::createFromFormat('Y-m-d', '1995-12-10'),
                'endereco' => 'Avenida Outro Exemplo, 101',
                'status' => 'Inativo', 
            ],
            [
                'nome' => 'Roberto',
                'cpf' => '31036591646',
                'rg' => '5678901',
                'telefone' => '3344556677',
                'sexo' => 'Masculino',
                'data_nascimento' => Carbon::createFromFormat('Y-m-d', '1997-03-25'),
                'endereco' => 'Rua Outra Exemplo, 102',
                'status' => 'Inativo', 
            ],
            [
                'nome' => 'Carlos Silva',
                'cpf' => '84381764293',
                'rg' => '45231698',
                'telefone' => '11987654321',
                'sexo' => 'Masculino',
                'data_nascimento' => '1991-02-15',
                'endereco' => 'Rua dos Limoeiros, 100',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Mariana Souza',
                'cpf' => '26890328809',
                'rg' => '51234678',
                'telefone' => '21987654321',
                'sexo' => 'Feminino',
                'data_nascimento' => '1993-05-22',
                'endereco' => 'Avenida das Flores, 200',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Bruno Lima',
                'cpf' => '22876591294',
                'rg' => '32165487',
                'telefone' => '31987654321',
                'sexo' => 'Masculino',
                'data_nascimento' => '1989-11-09',
                'endereco' => 'Rua das Palmeiras, 300',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Fernanda Oliveira',
                'cpf' => '81354032322',
                'rg' => '65498712',
                'telefone' => '21965432187',
                'sexo' => 'Feminino',
                'data_nascimento' => '1994-08-30',
                'endereco' => 'Rua do Sol, 400',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Rodrigo Fernandes',
                'cpf' => '68847611806',
                'rg' => '98732154',
                'telefone' => '31987654322',
                'sexo' => 'Masculino',
                'data_nascimento' => '1988-04-18',
                'endereco' => 'Avenida Central, 500',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Paulo Mendes',
                'cpf' => '29523376241',
                'rg' => '45231678',
                'telefone' => '11987543210',
                'sexo' => 'Masculino',
                'data_nascimento' => '1990-03-10',
                'endereco' => 'Rua das Acácias, 123',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Ana Beatriz',
                'cpf' => '84365568442',
                'rg' => '51234987',
                'telefone' => '21987456321',
                'sexo' => 'Feminino',
                'data_nascimento' => '1992-07-25',
                'endereco' => 'Avenida Primavera, 321',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Lucas Pereira',
                'cpf' => '31133277845',
                'rg' => '32169874',
                'telefone' => '31987456213',
                'sexo' => 'Masculino',
                'data_nascimento' => '1987-12-05',
                'endereco' => 'Rua das Rosas, 567',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Juliana Costa',
                'cpf' => '18612353564',
                'rg' => '65438912',
                'telefone' => '21987654332',
                'sexo' => 'Feminino',
                'data_nascimento' => '1995-06-18',
                'endereco' => 'Rua do Bosque, 432',
                'status' => 'Inativo'
            ],
            [
                'nome' => 'Felipe Almeida',
                'cpf' => '97332937417',
                'rg' => '98731245',
                'telefone' => '31987654399',
                'sexo' => 'Masculino',
                'data_nascimento' => '1986-10-12',
                'endereco' => 'Avenida Rio Branco, 789',
                'status' => 'Inativo'
            ]
        ]);
    }
}
