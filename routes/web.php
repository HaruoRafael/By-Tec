<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return redirect ('/login');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
// Dashboard, disponível para usuários autenticados e verificados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Agrupamento de rotas que requerem autenticação
Route::middleware('auth')->group(function () {

    // Rotas de perfil de usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

    // Rotas para alunos
    Route::resource('alunos', AlunoController::class);
    Route::get('/alunos/search', [AlunoController::class, 'search'])->name('alunos.search');
    Route::delete('/alunos/{id}', [AlunoController::class, 'remove'])->name('alunos.remove');
    Route::patch('/alunos/{id}/reativar', [AlunoController::class, 'reativar'])->name('alunos.reativar');
    Route::patch('/alunos/{id}', [AlunoController::class, 'update'])->name('alunos.update');
    Route::post('/alunos/{aluno}/add-treino', [AlunoController::class, 'addTreino'])->name('alunos.addTreino');
    Route::delete('/alunos/{aluno}/remove-treino/{treino}', [AlunoController::class, 'removeTreino'])->name('alunos.removeTreino');
    Route::get('/alunos/{id}/vendas', [AlunoController::class, 'vendas'])->name('aluno.vendas');
    Route::get('/alunos/{id}/contratos', [AlunoController::class, 'contratos'])->name('aluno.contratos');
    Route::get('/alunos/{id}/financeiro', [AlunoController::class, 'financeiro'])->name('aluno.financeiro');
    Route::post('/alunos/verificar-expiracao', [AlunoController::class, 'verificarExpiracaoAlunos'])->name('alunos.verificarExpiracao');

    // Rotas para exercícios
    Route::resource('exercicios', ExercicioController::class);

    // Rotas para avaliações
    Route::resource('avaliacoes', AvaliacaoController::class);
    Route::get('/alunos/{aluno}/avaliacoes/create', [AvaliacaoController::class, 'create'])->name('avaliacao.create');
    Route::post('/alunos/{aluno}/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
    Route::get('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'show'])->name('avaliacao.show');
    Route::get('/avaliacoes/{avaliacao}/edit', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');
    Route::get('/avaliacoes/{id}/imprimir', [AvaliacaoController::class, 'imprimir'])->name('avaliacoes.imprimir');
    Route::put('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'update'])->name('avaliacao.update');
    Route::delete('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');

    // Rotas para treinos
    Route::resource('treinos', TreinoController::class);
    Route::get('/treinos/{id}/imprimir', [TreinoController::class, 'imprimir'])->name('treinos.imprimir');
    Route::get('/treinos/search', [TreinoController::class, 'search'])->name('treinos.search');

    // Rotas para vendas (qualquer usuário autenticado pode acessar)
    Route::get('/vendas/create', [VendaController::class, 'create'])->name('vendas.create');

    // Grupo de rotas restritas a Administradores e Recepcionistas para caixas
    Route::middleware([CheckRole::class . ':Administrador,Recepcionista'])->group(function () {
        // Rotas para caixas (Apenas Administradores e Recepcionistas)
        Route::resource('caixas', CaixaController::class)->only(['index', 'create', 'show', 'store']);
        Route::post('/caixas/{caixa}/fechar', [CaixaController::class, 'fechar'])->name('caixas.fechar');
        Route::get('/caixas', [CaixaController::class, 'index'])->name('caixas.index');
        Route::get('/caixas/{id}/imprimir', [CaixaController::class, 'imprimir'])->name('caixas.imprimir');

        Route::get('/vendas/create', [VendaController::class, 'create'])->name('vendas.create');
        Route::post('/vendas', [VendaController::class, 'store'])->name('vendas.store');
        Route::post('/vendas/{id}/finalizar', [VendaController::class, 'finalizar'])->name('vendas.finalizar');
        Route::delete('/vendas/{id}/cancelar', [VendaController::class, 'cancelar'])->name('vendas.cancelar');
        Route::post('/vendas/{id}/reembolsar', [VendaController::class, 'reembolsar'])->name('vendas.reembolsar');
        Route::get('/vendas/{id}', [VendaController::class, 'showVenda'])->name('vendas.show');
        Route::post('/verificar-expiracao', [VendaController::class, 'verificarExpiracao'])->name('verificar-expiracao');
    });

    // Grupo de rotas restritas a Administradores
    Route::middleware([CheckRole::class . ':Administrador'])->group(function () {

        // Rotas para funcionários (apenas administrador pode gerenciar funcionários)
        Route::get('/funcionarios', [ProfileController::class, 'index'])->name('funcionarios.index');
        Route::get('/funcionarios/create', function () {
            return view('funcionarios.create');
        })->name('funcionarios.create');
        Route::get('/funcionarios/{user}', [ProfileController::class, 'show'])->name('funcionarios.show');
        Route::post('/funcionarios', [RegisteredUserController::class, 'store'])->name('funcionarios.store');
        Route::put('/funcionarios/{user}', [ProfileController::class, 'update'])->name('funcionarios.update');
        Route::delete('/funcionarios/{user}', [ProfileController::class, 'remove'])->name('funcionarios.remove');
        Route::post('/funcionarios/{user}/reativar', [ProfileController::class, 'reativar'])->name('funcionarios.reativar');

        // Rotas para planos (apenas administrador pode gerenciar planos)
        Route::resource('planos', PlanoController::class);
        Route::patch('/planos/{plano}/ocultar', [PlanoController::class, 'remove'])->name('planos.remove');
        Route::patch('/planos/{plano}/reativar', [PlanoController::class, 'reativar'])->name('planos.reativar');
    });
});

// Página de acesso negado
Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access.denied');

// Rotas de autenticação
require __DIR__ . '/auth.php';
