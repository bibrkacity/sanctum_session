<?php

namespace Bibrkacity\SanctumSession;

use Illuminate\Support\ServiceProvider;

class SanctumSessionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'sanctum-migrations');
    }

    public function register(): void
    {

    }
}