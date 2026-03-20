<?php

namespace Bibrkacity\SanctumSession;

class SanctumSessionServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ]);
    }

    public function register(): void
    {

    }
}