<?php

namespace App\Providers;

// Interfaces de Serviço
use App\Interfaces\Services\iInstituteService;
use App\Interfaces\Services\iReportService;
use App\Interfaces\Services\iStudentService;
use App\Interfaces\Services\iPhotoService;
use App\Interfaces\Services\iUserService;
// Implementações (Serviços)
use App\Services\InstituteService;
use App\Services\ReportService;
use App\Services\StudentService;
use App\Services\PhotoService;

// Interfaces de DAO
use App\Interfaces\DAOs\iInstituteDAO;
use App\Interfaces\DAOs\iStudentDAO;
use App\Interfaces\DAOs\iPhotoDAO;
use App\Interfaces\DAOs\iUserDAO;

// Implementações (DAOs)
use App\DAOs\InstituteDAO;
use App\DAOs\StudentDAO;
use App\DAOs\PhotoDAO;
use App\DAOs\UserDAO;

use App\Services\UserService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind de Serviços
        $this->app->bind(iInstituteService::class, InstituteService::class);
        $this->app->bind(iStudentService::class, StudentService::class);
        $this->app->bind(iPhotoService::class, PhotoService::class);
        $this->app->bind(iReportService::class, ReportService::class);
        $this->app->bind(iUserService::class, UserService::class);

        // Bind de DAOs
        $this->app->bind(iInstituteDAO::class, InstituteDAO::class);
        $this->app->bind(iStudentDAO::class, StudentDAO::class);
        $this->app->bind(iPhotoDAO::class, PhotoDAO::class);
        $this->app->bind(iUserDAO::class, UserDAO::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
