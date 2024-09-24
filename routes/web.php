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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('alunos', AlunoController::class);
    Route::get('/alunos/search', [AlunoController::class, 'search'])->name('alunos.search');
    Route::delete('/alunos/{id}', [AlunoController::class, 'remove'])->name('alunos.remove');
    Route::patch('/alunos/{id}/reativar', [AlunoController::class, 'reativar'])->name('alunos.reativar');
    Route::patch('/alunos/{id}', [AlunoController::class, 'update'])->name('alunos.update');

    Route::post('/alunos/{aluno}/add-treino', [AlunoController::class, 'addTreino'])->name('alunos.addTreino');
    Route::delete('/alunos/{aluno}/remove-treino/{treino}', [AlunoController::class, 'removeTreino'])->name('alunos.removeTreino');

    Route::resource('exercicios', ExercicioController::class);

    Route::resource('avaliacoes', AvaliacaoController::class);
    Route::get('/alunos/{aluno}/avaliacoes/create', [AvaliacaoController::class, 'create'])->name('avaliacao.create');
    Route::post('/alunos/{aluno}/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
    Route::get('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'show'])->name('avaliacao.show');
    Route::get('/avaliacoes/{avaliacao}/edit', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');
    Route::put('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'update'])->name('avaliacao.update');
    Route::delete('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');
    Route::get('/alunos/{id}/vendas', [AlunoController::class, 'vendas'])->name('aluno.vendas');
    Route::get('/alunos/{id}/contratos', [AlunoController::class, 'contratos'])->name('aluno.contratos');
    Route::get('/alunos/{id}/financeiro', [AlunoController::class, 'financeiro'])->name('aluno.financeiro');

    // Adicionando as rotas para TreinoController e TreinoCreationController
    Route::get('treinos/create', [TreinoController::class, 'create'])->name('treinos.create');
    Route::post('treinos', [TreinoController::class, 'store'])->name('treinos.store');
    Route::get('treinos/{treino}', [TreinoController::class, 'show'])->name('treinos.show');
    Route::put('treinos/{treino}', [TreinoController::class, 'update'])->name('treinos.update');
    Route::delete('treinos/{treino}', [TreinoController::class, 'destroy'])->name('treinos.destroy');
    Route::get('treinos', [TreinoController::class, 'index'])->name('treinos.index');
    Route::get('/treinos/search', [TreinoController::class, 'search'])->name('treinos.search');

    // Rotas para gerenciamento de caixas
    Route::resource('caixas', CaixaController::class)->only(['index', 'create', 'show', 'store']); // Adiciona o método 'create'
    Route::get('caixas/create', [CaixaController::class, 'create'])->name('caixas.create');
    Route::post('/caixas/{caixa}/fechar', [CaixaController::class, 'fechar'])->name('caixas.fechar'); // Rota para fechar um caixa existente

    Route::middleware([CheckRole::class . ':Administrador'])->group(function () {
        Route::get('/funcionarios', [ProfileController::class, 'index'])->name('funcionarios.index');
        Route::get('/funcionarios/create', function () {
            return view('funcionarios.create');
        })->name('funcionarios.create');
        Route::get('/funcionarios/{user}', [ProfileController::class, 'show'])->name('funcionarios.show');
        Route::post('/funcionarios', [RegisteredUserController::class, 'store'])->name('funcionarios.store');
        Route::put('/funcionarios/{user}', [ProfileController::class, 'update'])->name('funcionarios.update');
        Route::delete('/funcionarios/{user}', [ProfileController::class, 'remove'])->name('funcionarios.remove');
        Route::post('/funcionarios/{user}/reativar', [ProfileController::class, 'reativar'])->name('funcionarios.reativar');

        Route::resource('planos', PlanoController::class);
    });

    Route::get('/vendas/create', [VendaController::class, 'create'])->name('vendas.create');
    Route::post('/vendas', [VendaController::class, 'store'])->name('vendas.store');
    Route::post('/vendas/{id}/finalizar', [VendaController::class, 'finalizar'])->name('vendas.finalizar');
    Route::delete('/vendas/{id}/cancelar', [VendaController::class, 'cancelar'])->name('vendas.cancelar');
});

Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access.denied');

require __DIR__ . '/auth.php';
