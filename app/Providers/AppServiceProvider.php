<?php

namespace App\Providers;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        TextColumn::macro('jalaliDateTime', function (string $format = 'Y/m/d H:i') {
            return $this->formatStateUsing(fn ($state) => $state ? \Hekmatinasser\Verta\Facades\Verta::instance($state)->format($format) : '-');
        });
    }
}
