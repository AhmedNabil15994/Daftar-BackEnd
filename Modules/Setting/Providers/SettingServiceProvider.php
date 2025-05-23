<?php

namespace Modules\Setting\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Setting;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Setting', 'Database/Migrations'));
        
        if (Schema::hasTable('settings')) {
            $this->setSettingConfigurations();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(LocalesServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        // $this->app->bind(SettingInterface::class,SettingRepository::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Setting', 'Config/config.php') => config_path('setting.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Setting', 'Config/config.php'),
            'setting'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/setting');

        $sourcePath = module_path('Setting', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/setting';
        }, \Config::get('view.paths')), [$sourcePath]), 'setting');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/setting');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'setting');
        } else {
            $this->loadTranslationsFrom(module_path('Setting', 'Resources/lang'), 'setting');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Setting', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }


    private function setSettingConfigurations()
    {
        $this->app->config->set([

            'mail.markdown.theme' => (is_rtl() == 'rtl') ? 'default-rtl' : 'default',

            'app.name'  => Setting::lang(locale())->get('app_name'),

            'setting' => [
                'free_delivery'              => Setting::get('free_delivery'),
                'fiexed_delivery'            => Setting::get('fiexed_delivery'),
                'last_time_order'            => Setting::get('last_time_order'),
                'other'                      => Setting::get('other'),
                'social'                     => Setting::get('social'),
                'store'                      => Setting::get('store'),
                'other'                      => Setting::get('other'),
                'logo'                       => Setting::get('logo') ? url(Setting::get('logo')) : null,
                'favicon'                    => Setting::get('favicon') ? url(Setting::get('favicon')) : null,
                'contact_us'                 => Setting::get('contact_us'),
            ],

        ]);
    }
}
