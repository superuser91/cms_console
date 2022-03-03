<?php

namespace Vgplay\CmsConsole;

use Illuminate\Support\ServiceProvider;

class CmsConsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'vgplay');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'vgplay');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
