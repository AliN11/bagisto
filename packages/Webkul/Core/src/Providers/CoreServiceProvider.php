<?php

namespace Webkul\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Webkul\Core\Http\Middleware\Locale;
use Webkul\Core\Core;
use Webkul\Core\Facades\CoreFacade;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        include __DIR__ . '/../Http/helpers.php';

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'core');

        $router->aliasMiddleware('locale', Locale::class);

        $this->publishes([
            __DIR__ . '/../../publishable/lang' => public_path('vendor/webkul/core/lang'),
        ], 'public');

        Validator::extend('slug', 'Webkul\Core\Contracts\Validations\Slug@passes');

        Validator::extend('code', 'Webkul\Core\Contracts\Validations\Code@passes');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCoreFacade();
    }
    
    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerCoreFacade()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('core', CoreFacade::class);

        $this->app->singleton('core', function () {
            return new Core();
        });
    }
}