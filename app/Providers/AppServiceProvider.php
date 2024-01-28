<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use MeiliSearch\Client as MeiliSearch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        JsonResource::withoutWrapping();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootMeilisearch();
    }

    protected function bootMeilisearch()
    {
        $this->app->singleton(
            'meilisearch',
            function () {
                $config = config('scout.meilisearch');

                return (
                new MeiliSearch($config['host'], $config['key'])
                )->index('products');
            }
        );
    }
}
