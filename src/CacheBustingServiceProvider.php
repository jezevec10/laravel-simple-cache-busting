<?php namespace Ruyter\CacheBusting;

use Illuminate\Support\ServiceProvider;

class CacheBustingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
             __DIR__.'/../config/cachebusting.php' => config_path('cachebusting.php'),
        ], 'config');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \Ruyter\CacheBusting\Console\GenerateHash::class
        ]);

        $this->app->bind('CacheBusting', \Ruyter\CacheBusting\CacheBusting::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('CacheBusting', \Ruyter\CacheBusting\Facades\CacheBustingFacade::class);
    }
}
