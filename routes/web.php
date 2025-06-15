<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Redireciona a rota raiz para o dashboard principal
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Inclui as rotas de autenticação (login, registro, etc.) do Breeze
require __DIR__.'/auth.php';

// Rota principal do Dashboard, que redireciona o usuário
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Rotas Comuns para Usuários Autenticados
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Rotas da Área do Aluno
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/meu-album', [AlbumController::class, 'index'])->name('album.index');
});

// Rotas da Área do Administrador
Route::middleware(['auth', 'verified', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/reports', ReportController::class)->name('reports.index');

        Route::resource('institutes', InstituteController::class);
        Route::resource('students', StudentController::class);
        Route::resource('admins', AdminController::class)->except(['edit', 'update', 'show']);

        Route::post('students/{student}/photos', [PhotoController::class, 'store'])->name('students.photos.store');
        Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    });
