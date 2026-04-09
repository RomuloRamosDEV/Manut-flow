<?php

use Illuminate\Support\Facades\Route;

// Rota home — usada pelos layouts de auth (login, register, etc.)
Route::redirect('/', '/atendimento')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Timer / Atendimento
    Route::get('/atendimento', fn () => view('pages.timer'))
        ->name('timer');

    // Relatório pós-atendimento
    Route::get('/atendimento/{sessionId}/relatorio', fn (int $sessionId) => view('pages.report-create', compact('sessionId')))
        ->name('report.create');

    // Histórico
    Route::get('/historico', fn () => view('pages.history'))
        ->name('history');

    // Detalhe de um atendimento
    Route::get('/historico/{sessionId}', fn (int $sessionId) => view('pages.history-detail', compact('sessionId')))
        ->name('session.detail');

    // Dashboard padrão (mantido do starter kit)
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
