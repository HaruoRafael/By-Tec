<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\AvaliacaoController;
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

    Route::resource('exercicios', ExercicioController::class);

    Route::resource('avaliacoes', AvaliacaoController::class);
    Route::get('/alunos/{aluno}/avaliacoes/create', [AvaliacaoController::class, 'create'])->name('avaliacao.create');
    Route::post('/alunos/{aluno}/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
    Route::get('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'show'])->name('avaliacao.show');
    Route::get('/avaliacoes/{avaliacao}/edit', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');
    Route::put('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'update'])->name('avaliacao.update');
    Route::delete('/avaliacoes/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');

    Route::middleware(['auth', CheckRole::class.':Administrador'])->group(function () {
        Route::get('/funcionarios', [ProfileController::class, 'index'])->name('funcionarios.index');
        Route::get('/funcionarios/create', function () {
            return view('funcionarios.create');
        })->name('funcionarios.create');
        Route::get('/funcionarios/{user}', [ProfileController::class, 'show'])->name('funcionarios.show');
        Route::post('/funcionarios', [RegisteredUserController::class, 'store'])->name('funcionarios.store');
        Route::put('/funcionarios/{user}', [ProfileController::class, 'update'])->name('funcionarios.update');
    });
});

Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access.denied');

require __DIR__.'/auth.php';
