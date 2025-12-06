<?php

namespace App\Providers;

use App\Models\SiteVisit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Vite\Facades\Vite;

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
        if (
            class_exists(\Laravel\Vite\Facades\Vite::class)
            && is_file(public_path('build/.vite/manifest.json'))
        ) {
            // Vite 5+ places the manifest inside /.vite; tell Laravel where to look.
            Vite::useManifestFilename('.vite/manifest.json');
        }

        View::composer('layouts.app', function ($view): void {
            $totalVisitors = Cache::remember(
                'site_visits_total',
                now()->addMinutes(10),
                static fn () => SiteVisit::count()
            );

            $view->with('totalVisitorCount', $totalVisitors);
        });
    }
}
