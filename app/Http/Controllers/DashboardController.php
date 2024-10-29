<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Caixa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlunos = Aluno::count();

        $alunosAtivos = Aluno::where('status', 'Ativo')->count();

        $alunosInativos = Aluno::where('status', 'Inativo')->count();
        $caixasAberto = Caixa::where ('status', 'aberto')->count();
        if (Caixa::where('status', 'aberto')->exists()) {
            $mensagemCaixa = 'Há um caixa aberto.';
        } else {
            $mensagemCaixa = 'Não há caixa aberto.';
        }

        return view('dashboard', compact('totalAlunos', 'alunosAtivos', 'alunosInativos','caixasAberto','mensagemCaixa' ));
    }
}
