<?php

namespace GrnSpc\News;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use GrnSpc\News\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/news.php', 'news');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'news');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->configureComponents();
        $this->configurePublishing();
        $this->registerRoutes();
        $this->configureCommands();
    }

    /**
     * Configure the Jetstream Blade components.
     *
     * @return void
     */
    protected function configureComponents()
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            $this->registerComponent('feature-article');
        });
    }

    /**
     * Register the given component.
     *
     * @param  string  $component
     * @return void
     */
    protected function registerComponent(string $component)
    {

        Blade::component('news::components.' . $component, 'blah-' . $component,);
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/news.php' => config_path('news.php'),
        ], 'news-config');

        if (!class_exists('CreateNewsTables')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_news_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_news_tables.php'),
            ], 'news-migrations');
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/jetstream'),
        ], 'news-views');
    }

    public function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/news.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('news.prefix'),
            'middleware' => config('news.middleware'),
        ];
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }
}
