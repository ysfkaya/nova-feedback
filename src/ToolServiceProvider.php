<?php

namespace Ysfkaya\NovaFeedback;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Ysfkaya\NovaFeedback\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-feedback');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'nova-feedback');

        $this->loadPublishes();


        $this->app->booted(function () {
            $this->routes();

            Feedback::setOptions();
            Feedback::observers();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }


        Route::middleware(['nova', Authorize::class])
            ->namespace(__NAMESPACE__ . '\\Http\\Controllers')
            ->prefix('nova-vendor/nova-feedback')
            ->group(__DIR__ . '/../routes/api.php');
    }


    protected function loadPublishes()
    {

        $this->publishes([
            __DIR__ . '/../config/nova-feedback.php' => config_path('nova-feedback.php'),
        ], 'nova-feedback-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nova-feedback'),
        ], 'nova-feedback-views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/nova-feedback'),
        ], 'nova-feedback-lang');


        $this->publishes([
            __DIR__ . '/../database/migrations/create_feedback_tables.php.stub' =>
                database_path('migrations/' . date('Y_m_d_His', time()) . '_create_feedback_tables.php'),
        ], 'nova-feedback-migrations');
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-feedback.php', 'nova-feedback');
    }
}
