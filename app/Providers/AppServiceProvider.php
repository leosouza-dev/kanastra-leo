<?php

namespace App\Providers;

use App\src\Application\Services\DebtImporterInterface;
use App\src\Infrastructure\Services\CsvDebtImporter;
use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Infrastructure\Repositories\DebtRepository;
use App\src\Application\Services\EmailServiceInterface;
use App\src\Infrastructure\Services\EmailService;
use App\src\Application\Services\InvoiceGeneratorInterface;
use App\src\Infrastructure\Services\InvoiceGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            DebtRepositoryInterface::class,
            DebtRepository::class
        );

        $this->app->bind(
            DebtImporterInterface::class,
            CsvDebtImporter::class
        );

        $this->app->bind(
            EmailServiceInterface::class,
            EmailService::class
        );

        $this->app->bind(
            InvoiceGeneratorInterface::class,
            InvoiceGenerator::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
