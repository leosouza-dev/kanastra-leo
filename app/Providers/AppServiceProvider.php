<?php

namespace App\Providers;

use App\Domain\Debt\Services\DebtImporterInterface;
use App\Domain\Debt\Services\CsvDebtImporter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(
        //     DebtRepositoryInterface::class,
        //     EloquentDebtRepository::class
        // );

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
