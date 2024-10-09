<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Quantidade total de alunos cadastrados
        $totalAlunos = Aluno::count();

        // Quantidade de alunos com status "Ativo"
        $alunosAtivos = Aluno::where('status', 'Ativo')->count();

        // Passa os dados para a view do dashboard
        return view('dashboard', compact('totalAlunos', 'alunosAtivos'));
    }
}
