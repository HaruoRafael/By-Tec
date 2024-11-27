<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciciosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('exercicios')->insert([
            [
                'nome' => 'Flexão de Braço',
                'grupo_muscular' => 'Peito',
                'dificuldade' => 'easy',
                'observacoes' => 'Ideal para iniciantes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Agachamento Livre',
                'grupo_muscular' => 'Pernas',
                'dificuldade' => 'normal',
                'observacoes' => 'Manter a coluna reta.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Prancha Abdominal',
                'grupo_muscular' => 'Abdômen',
                'dificuldade' => 'hard',
                'observacoes' => 'Manter o corpo alinhado.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Supino Reto',
                'grupo_muscular' => 'Peito',
                'dificuldade' => 'normal',
                'observacoes' => 'Evitar travar os cotovelos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Remada Curvada',
                'grupo_muscular' => 'Costas',
                'dificuldade' => 'hard',
                'observacoes' => 'Manter a lombar estável.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Desenvolvimento com Halteres',
                'grupo_muscular' => 'Ombros',
                'dificuldade' => 'normal',
                'observacoes' => 'Evitar forçar o pescoço.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Rosca Direta',
                'grupo_muscular' => 'Braços',
                'dificuldade' => 'easy',
                'observacoes' => 'Controlar o movimento para evitar lesões.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Tríceps Testa',
                'grupo_muscular' => 'Braços',
                'dificuldade' => 'normal',
                'observacoes' => 'Evitar sobrecarga nos cotovelos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Elevação Lateral',
                'grupo_muscular' => 'Ombros',
                'dificuldade' => 'easy',
                'observacoes' => 'Não levantar os halteres acima dos ombros.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Afundo',
                'grupo_muscular' => 'Pernas',
                'dificuldade' => 'hard',
                'observacoes' => 'Manter o equilíbrio durante o movimento.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Stiff',
                'grupo_muscular' => 'Posterior da coxa',
                'dificuldade' => 'normal',
                'observacoes' => 'Manter a coluna reta durante a execução.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Levantamento Terra',
                'grupo_muscular' => 'Costas',
                'dificuldade' => 'hard',
                'observacoes' => 'Técnica essencial para evitar lesões na lombar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Flexão de Punho',
                'grupo_muscular' => 'Antebraço',
                'dificuldade' => 'easy',
                'observacoes' => 'Movimento curto e controlado.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
