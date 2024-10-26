<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlunos = Aluno::count();

        $alunosAtivos = Aluno::where('status', 'Ativo')->count();

        return view('dashboard', compact('totalAlunos', 'alunosAtivos'));
    }
}
