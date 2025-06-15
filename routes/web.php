<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rota da Página Inicial (estava faltando)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('institutes', InstituteController::class);
        Route::resource('students', StudentController::class);

        Route::post('students/{student}/photos', [PhotoController::class, 'store'])->name('students.photos.store');
        Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });

require __DIR__.'/auth.php';
