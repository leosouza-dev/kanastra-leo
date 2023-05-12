<?php

namespace App\Providers;

use App\Domain\Debt\Services\DebtImporterInterface;
use App\Domain\Debt\Services\CsvDebtImporter;
use App\Domain\Debt\Repositories\DebtRepositoryInterface;
use App\Infrastructure\Debt\Repositories\DebtRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
